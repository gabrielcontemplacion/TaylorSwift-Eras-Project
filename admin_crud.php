<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php'); exit;
}

$db = new mysqli('localhost', 'root', '', 'taylors_db');
if ($db->connect_error) die('DB error: ' . $db->connect_error);

$section = $_GET['section'] ?? 'albums';
$action  = $_GET['action']  ?? 'add';
$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$pk_map = [
    'albums'        => 'album_id',
    'songs'         => 'song_id',
    'tours'         => 'tour_id',
    'awards'        => 'award_id',
    'personal_info' => 'info_id',
    'users'         => 'user_id',
];
$pk = $pk_map[$section] ?? 'id';

// ── Field definitions ────────────────────────────────────────────────────────
$field_defs = [
    'albums' => [
        ['name'=>'title',        'label'=>'Album Title',     'type'=>'text'],
        ['name'=>'release_year', 'label'=>'Release Year',    'type'=>'number'],
        ['name'=>'description',  'label'=>'Description',     'type'=>'textarea'],
        ['name'=>'cover_image',  'label'=>'Cover Image File','type'=>'text','placeholder'=>'e.g. img/album.jpg'],
    ],
    'songs' => [
        ['name'=>'album_id',   'label'=>'Album ID (FK)',    'type'=>'number'],
        ['name'=>'title',      'label'=>'Song Title',       'type'=>'text'],
        ['name'=>'youtube_id', 'label'=>'YouTube Video ID', 'type'=>'text','placeholder'=>'e.g. dQw4w9WgXcQ'],
    ],
    'tours' => [
        ['name'=>'tour_name',   'label'=>'Tour Name',       'type'=>'text'],
        ['name'=>'description', 'label'=>'Description',     'type'=>'textarea'],
        ['name'=>'image',       'label'=>'Image File',      'type'=>'text','placeholder'=>'e.g. img/tour.jpg'],
        ['name'=>'total_sales', 'label'=>'Total Sales ($)', 'type'=>'text'],
        ['name'=>'attendance',  'label'=>'Attendance',      'type'=>'number'],
        ['name'=>'songs_count', 'label'=>'Songs Count',     'type'=>'number'],
    ],
    'awards' => [
        ['name'=>'award_name',  'label'=>'Award Name',  'type'=>'text'],
        ['name'=>'description', 'label'=>'Description', 'type'=>'textarea'],
        ['name'=>'image',       'label'=>'Image File',  'type'=>'text','placeholder'=>'e.g. img/award.jpg'],
    ],
    'personal_info' => [
        ['name'=>'category',    'label'=>'Category',    'type'=>'text','placeholder'=>'Childhood / Education / Career…'],
        ['name'=>'title',       'label'=>'Title',       'type'=>'text'],
        ['name'=>'description', 'label'=>'Description', 'type'=>'textarea'],
        ['name'=>'image',       'label'=>'Image File',  'type'=>'text','placeholder'=>'e.g. img/info.jpg'],
    ],
    'users' => [
        ['name'=>'username', 'label'=>'Username', 'type'=>'text'],
        ['name'=>'password', 'label'=>'Password', 'type'=>'password'],
        ['name'=>'role',     'label'=>'Role',     'type'=>'select','options'=>['admin','editor']],
    ],
];
$fields = $field_defs[$section] ?? [];

// ── Fetch record for edit ────────────────────────────────────────────────────
$record = [];
if ($action === 'edit' && $id) {
    $r = $db->query("SELECT * FROM `$section` WHERE `$pk` = $id LIMIT 1");
    if ($r && $r->num_rows) $record = $r->fetch_assoc();
}

// ── Handle POST save ─────────────────────────────────────────────────────────
$msg = ''; $msg_type = 'ok';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['post_action'] ?? '') === 'save') {

    $now  = date('Y-m-d H:i:s');
    $cols = [];
    $vals = [];

    foreach ($fields as $f) {
        $val = trim($_POST[$f['name']] ?? '');
        // Skip blank password on edit (keep existing)
        if ($f['type'] === 'password' && $action === 'edit' && $val === '') continue;
        $cols[] = $f['name'];
        $vals[] = $val;
    }

    if ($action === 'add') {
        // Add timestamps
        $cols[] = 'created_at';
        $vals[] = $now;
        $cols[] = 'updated_at';
        $vals[] = $now;

        $col_sql = '`' . implode('`, `', $cols) . '`';
        $ph_sql  = implode(', ', array_fill(0, count($vals), '?'));
        $types   = str_repeat('s', count($vals));

        $stmt = $db->prepare("INSERT INTO `$section` ($col_sql) VALUES ($ph_sql)");
        if ($stmt) {
            $stmt->bind_param($types, ...$vals);
            if ($stmt->execute()) {
                $stmt->close(); $db->close();
                header("Location: dashboard.php?section=$section&saved=1");
                exit;
            } else {
                $msg = 'Insert error: ' . $stmt->error;
                $msg_type = 'err';
                $stmt->close();
            }
        } else {
            $msg = 'Prepare error: ' . $db->error;
            $msg_type = 'err';
        }

    } else {
        // UPDATE
        $cols[] = 'updated_at';
        $vals[] = $now;
        $vals[] = $id; // for WHERE clause

        $set_sql = '`' . implode('` = ?, `', $cols) . '` = ?';
        $types   = str_repeat('s', count($vals));

        $stmt = $db->prepare("UPDATE `$section` SET $set_sql WHERE `$pk` = ?");
        if ($stmt) {
            $stmt->bind_param($types, ...$vals);
            if ($stmt->execute()) {
                $msg = 'Record updated successfully!';
            } else {
                $msg = 'Update error: ' . $stmt->error;
                $msg_type = 'err';
            }
            $stmt->close();
            // Refresh record
            $r = $db->query("SELECT * FROM `$section` WHERE `$pk` = $id LIMIT 1");
            if ($r && $r->num_rows) $record = $r->fetch_assoc();
        } else {
            $msg = 'Prepare error: ' . $db->error;
            $msg_type = 'err';
        }
    }
}

$db->close();
$title_label = ucfirst(str_replace('_', ' ', $section));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $action==='add'?'Add':'Edit'; ?> <?php echo $title_label; ?> | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&family=Playfair+Display:ital,wght@0,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --purple:#A78BFA; --red:#D32F2F; --lover-gradient:linear-gradient(135deg,#fbc2eb 0%,#a6c1ee 50%,#fde484 100%); }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { min-height:100vh; background:var(--lover-gradient); background-attachment:fixed; font-family:'Montserrat',sans-serif; color:#1A1A1A; }

        .top-bar {
            position:fixed; top:0; left:0; right:0;
            background:rgba(255,255,255,0.2); backdrop-filter:blur(15px);
            padding:16px 5%; border-bottom:1px solid rgba(255,255,255,0.3);
            display:flex; align-items:center; justify-content:space-between; z-index:200;
        }
        .top-bar .logo { font-family:'Playfair Display',serif; font-weight:900; font-size:1.4rem; }
        .btn-back {
            background:rgba(255,255,255,0.3); color:#1A1A1A; border:1px solid rgba(255,255,255,0.5);
            padding:8px 18px; border-radius:20px; font-family:'Montserrat',sans-serif;
            font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;
            cursor:pointer; text-decoration:none; transition:background 0.3s;
        }
        .btn-back:hover { background:rgba(255,255,255,0.5); }

        .page-wrap { display:flex; padding-top:65px; min-height:100vh; }

        .sidebar {
            width:220px; min-height:calc(100vh - 65px);
            background:rgba(0,0,0,0.15); backdrop-filter:blur(10px);
            padding:30px 0; position:fixed; top:65px; left:0; bottom:0; overflow-y:auto;
        }
        .sidebar h3 { font-size:0.65rem; text-transform:uppercase; letter-spacing:3px;
            color:#888; padding:0 25px 12px; border-bottom:1px solid rgba(255,255,255,0.2); margin-bottom:10px; }
        .sidebar a {
            display:flex; align-items:center; gap:10px; padding:12px 25px;
            text-decoration:none; color:#1A1A1A; font-size:0.8rem; font-weight:600;
            text-transform:uppercase; letter-spacing:1px; transition:background 0.2s;
        }
        .sidebar a:hover, .sidebar a.active { background:rgba(255,255,255,0.3); color:var(--red); border-left:3px solid var(--red); }
        .sidebar a i { width:16px; text-align:center; }

        .form-content { margin-left:220px; flex:1; padding:40px; display:flex; flex-direction:column; align-items:center; }

        .form-card {
            width:100%; max-width:720px;
            background:rgba(255,255,255,0.35); backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.5); border-radius:25px;
            overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,0.08);
        }
        .form-card-header {
            padding:25px 35px; border-bottom:1px solid rgba(255,255,255,0.3);
            display:flex; align-items:center; justify-content:space-between;
        }
        .form-card-header h2 { font-family:'Playfair Display',serif; font-size:1.8rem; }
        .breadcrumb { font-size:0.75rem; color:#888; }
        .breadcrumb a { color:var(--red); text-decoration:none; }

        .form-body { padding:35px; }

        .msg-ok  { background:rgba(167,139,250,0.2); border:1px solid var(--purple); color:#5b21b6; padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:0.88rem; }
        .msg-err { background:rgba(211,47,47,0.1); border:1px solid var(--red); color:var(--red); padding:12px 16px; border-radius:10px; margin-bottom:20px; font-size:0.88rem; }

        .field { margin-bottom:22px; }
        .field label { display:block; font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#555; margin-bottom:8px; }
        .field input, .field textarea, .field select {
            width:100%; padding:12px 16px;
            border:1.5px solid rgba(255,255,255,0.6); border-radius:12px;
            background:rgba(255,255,255,0.5);
            font-family:'Montserrat',sans-serif; font-size:0.95rem; color:#1A1A1A; outline:none;
            transition:border-color 0.3s, box-shadow 0.3s;
        }
        .field textarea { min-height:120px; resize:vertical; }
        .field input:focus, .field textarea:focus, .field select:focus { border-color:var(--purple); box-shadow:0 0 0 3px rgba(167,139,250,0.2); }

        .form-actions { display:flex; gap:14px; margin-top:10px; }
        .btn-save {
            flex:1; padding:14px; background:var(--red); color:white; border:none;
            border-radius:12px; font-family:'Montserrat',sans-serif; font-size:0.85rem;
            font-weight:700; text-transform:uppercase; letter-spacing:2px; cursor:pointer;
            transition:background 0.3s, transform 0.2s;
        }
        .btn-save:hover { background:#b71c1c; transform:translateY(-2px); }
        .btn-cancel {
            padding:14px 22px; background:rgba(255,255,255,0.3); color:#1A1A1A;
            border:1px solid rgba(255,255,255,0.5); border-radius:12px;
            font-family:'Montserrat',sans-serif; font-size:0.85rem; font-weight:700;
            text-transform:uppercase; letter-spacing:1px; cursor:pointer; text-decoration:none;
            transition:background 0.3s;
        }
        .btn-cancel:hover { background:rgba(255,255,255,0.5); }
    </style>
</head>
<body>

<div class="top-bar">
    <div class="logo">Taylor's Version — Admin</div>
    <a href="admin_dashboard.php?section=<?php echo $section; ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="page-wrap">
    <nav class="sidebar">
        <h3>Manage</h3>
        <a href="admin_dashboard.php?section=albums"         class="<?php echo $section==='albums'       ?'active':''; ?>"><i class="fas fa-compact-disc"></i> Albums</a>
        <a href="admin_dashboard.php?section=songs"          class="<?php echo $section==='songs'        ?'active':''; ?>"><i class="fas fa-music"></i> Songs</a>
        <a href="admin_dashboard.php?section=tours"          class="<?php echo $section==='tours'        ?'active':''; ?>"><i class="fas fa-map-marker-alt"></i> Tours</a>
        <a href="admin_dashboard.php?section=awards"         class="<?php echo $section==='awards'       ?'active':''; ?>"><i class="fas fa-trophy"></i> Awards</a>
        <a href="admin_dashboard.php?section=personal_info"  class="<?php echo $section==='personal_info'?'active':''; ?>"><i class="fas fa-user"></i> Personal Info</a>
        <a href="admin_dashboard.php?section=users"          class="<?php echo $section==='users'        ?'active':''; ?>"><i class="fas fa-users-cog"></i> Users</a>
        <br>
        <h3>Site</h3>
        <a href="index.php" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a>
    </nav>

    <div class="form-content">
        <div class="form-card">
            <div class="form-card-header">
                <h2><?php echo $action==='add'?'Add New':'Edit'; ?> <?php echo $title_label; ?></h2>
                <div class="breadcrumb">
                    <a href="admin_dashboard.php?section=<?php echo $section; ?>">← <?php echo $title_label; ?></a>
                </div>
            </div>
            <div class="form-body">

                <?php if ($msg): ?>
                    <div class="msg-<?php echo $msg_type; ?>"><?php echo htmlspecialchars($msg); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="post_action" value="save">

                    <?php foreach ($fields as $f): ?>
                    <div class="field">
                        <label for="<?php echo $f['name']; ?>"><?php echo $f['label']; ?></label>
                        <?php
                        $val = $record[$f['name']] ?? ($_POST[$f['name']] ?? '');
                        $ph  = htmlspecialchars($f['placeholder'] ?? '');
                        if ($f['type'] === 'textarea'): ?>
                            <textarea id="<?php echo $f['name']; ?>" name="<?php echo $f['name']; ?>" placeholder="<?php echo $ph; ?>"><?php echo htmlspecialchars($val); ?></textarea>
                        <?php elseif ($f['type'] === 'select'): ?>
                            <select id="<?php echo $f['name']; ?>" name="<?php echo $f['name']; ?>">
                                <?php foreach ($f['options'] as $opt): ?>
                                    <option value="<?php echo $opt; ?>" <?php echo $val===$opt?'selected':''; ?>><?php echo ucfirst($opt); ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input type="<?php echo $f['type']; ?>" id="<?php echo $f['name']; ?>" name="<?php echo $f['name']; ?>"
                                   value="<?php echo htmlspecialchars($val); ?>" placeholder="<?php echo $ph; ?>">
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                    <div class="form-actions">
                        <button type="submit" class="btn-save"><i class="fas fa-save"></i> Save</button>
                        <a href="admin_dashboard.php?section=<?php echo $section; ?>" class="btn-cancel">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>
