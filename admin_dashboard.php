<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php'); exit;
}

$db = new mysqli('localhost', 'root', '', 'taylors_db');
if ($db->connect_error) die('DB error: ' . $db->connect_error);

$section = $_GET['section'] ?? 'albums';

$pk_map = [
    'albums'        => 'album_id',
    'songs'         => 'song_id',
    'tours'         => 'tour_id',
    'awards'        => 'award_id',
    'personal_info' => 'info_id',
    'users'         => 'user_id',
];
$pk = $pk_map[$section] ?? 'id';

// Label field per table (what shows in the list)
$label_map = [
    'albums'        => 'title',
    'songs'         => 'title',
    'tours'         => 'tour_name',
    'awards'        => 'award_name',
    'personal_info' => 'title',
    'users'         => 'username',
];
$label_field = $label_map[$section] ?? 'id';

// Handle delete
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $del_id = (int)$_POST['record_id'];
    $db->query("DELETE FROM `$section` WHERE `$pk` = $del_id");
    $msg = 'Record deleted.';
}

// Fetch all rows for list
$rows = [];
$r = $db->query("SELECT * FROM `$section` ORDER BY `$pk` DESC");
if ($r) while ($row = $r->fetch_assoc()) $rows[] = $row;

// Selected record
$selected_id = isset($_GET['id']) ? (int)$_GET['id'] : ($rows[0][$pk] ?? 0);
$selected = null;
foreach ($rows as $row) {
    if ($row[$pk] == $selected_id) { $selected = $row; break; }
}

$db->close();

$sections = ['albums','songs','tours','awards','personal_info','users'];
$title_label = ucfirst(str_replace('_',' ', $section));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Taylor's Version</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&family=Playfair+Display:ital,wght@0,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --purple:#A78BFA; --red:#D32F2F; --lover-gradient:linear-gradient(135deg,#fbc2eb 0%,#a6c1ee 50%,#fde484 100%); }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { min-height:100vh; background:var(--lover-gradient); background-attachment:fixed; font-family:'Montserrat',sans-serif; color:#1A1A1A; }

        /* ── Top bar ── */
        .top-bar {
            position:fixed; top:0; left:0; right:0; height:60px;
            background:rgba(255,255,255,0.2); backdrop-filter:blur(15px);
            border-bottom:1px solid rgba(255,255,255,0.3);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 30px; z-index:200;
        }
        .top-bar .logo { font-family:'Playfair Display',serif; font-weight:900; font-size:1.3rem; }
        .top-bar .user { font-size:0.75rem; color:#555; display:flex; align-items:center; gap:12px; }
        .btn-logout {
            background:var(--red); color:white; border:none; padding:7px 16px;
            border-radius:20px; font-family:'Montserrat',sans-serif; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:1px;
            cursor:pointer; text-decoration:none; transition:background 0.3s;
        }
        .btn-logout:hover { background:#b71c1c; }

        /* ── Page wrap ── */
        .page { padding-top:60px; min-height:100vh; display:flex; flex-direction:column; }

        /* ── Tab bar (top section tabs) ── */
        .tab-bar {
            display:flex; gap:8px; padding:16px 24px 0;
            background:rgba(255,255,255,0.15);
            border-bottom:1px solid rgba(255,255,255,0.3);
            flex-wrap:wrap;
        }
        .tab-bar a {
            padding:10px 20px; border-radius:10px 10px 0 0;
            text-decoration:none; font-size:0.75rem; font-weight:700;
            text-transform:uppercase; letter-spacing:1px; color:#555;
            background:rgba(255,255,255,0.2);
            border:1px solid rgba(255,255,255,0.3); border-bottom:none;
            transition:background 0.2s, color 0.2s;
        }
        .tab-bar a:hover { background:rgba(255,255,255,0.4); color:#1A1A1A; }
        .tab-bar a.active { background:rgba(255,255,255,0.6); color:var(--red); font-weight:800; }

        /* ── Main panel ── */
        .main-panel {
            flex:1; display:flex; gap:0;
            margin:20px 24px 24px;
            background:rgba(255,255,255,0.25);
            backdrop-filter:blur(15px);
            border:1px solid rgba(255,255,255,0.4);
            border-radius:20px; overflow:hidden;
            box-shadow:0 15px 40px rgba(0,0,0,0.08);
            min-height:500px;
        }

        /* ── Left list panel (dark) ── */
        .list-panel {
            width:260px; min-width:260px;
            background:rgba(30,30,30,0.75);
            backdrop-filter:blur(10px);
            display:flex; flex-direction:column;
            border-right:1px solid rgba(255,255,255,0.1);
        }
        .list-panel .list-header {
            padding:16px 18px;
            border-bottom:1px solid rgba(255,255,255,0.1);
            font-size:0.68rem; text-transform:uppercase;
            letter-spacing:2px; color:#aaa; font-weight:700;
        }
        .list-panel .search-box {
            padding:10px 12px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }
        .list-panel .search-box input {
            width:100%; padding:8px 12px; border-radius:8px;
            border:1px solid rgba(255,255,255,0.15);
            background:rgba(255,255,255,0.08);
            color:white; font-family:'Montserrat',sans-serif;
            font-size:0.8rem; outline:none;
        }
        .list-panel .search-box input::placeholder { color:#888; }
        .list-items { flex:1; overflow-y:auto; }
        .list-items::-webkit-scrollbar { width:4px; }
        .list-items::-webkit-scrollbar-thumb { background:rgba(255,255,255,0.2); border-radius:4px; }
        .list-item {
            padding:13px 18px; cursor:pointer;
            border-bottom:1px solid rgba(255,255,255,0.06);
            color:#ccc; font-size:0.82rem; font-weight:600;
            transition:background 0.2s, color 0.2s;
            display:flex; align-items:center; gap:10px;
        }
        .list-item:hover { background:rgba(255,255,255,0.08); color:white; }
        .list-item.active { background:rgba(167,139,250,0.25); color:white; border-left:3px solid var(--purple); }
        .list-item .item-id { font-size:0.65rem; color:#666; min-width:24px; }

        /* ── Right detail panel ── */
        .detail-panel {
            flex:1; display:flex; flex-direction:column;
            background:rgba(255,255,255,0.15);
        }
        .detail-header {
            padding:18px 24px;
            border-bottom:1px solid rgba(255,255,255,0.3);
            display:flex; align-items:center; justify-content:space-between;
        }
        .detail-header h2 { font-family:'Playfair Display',serif; font-size:1.5rem; color:#1A1A1A; }
        .detail-header .count { font-size:0.72rem; color:#888; }

        .detail-body { flex:1; padding:24px; overflow-y:auto; }

        /* ── Field rows in detail ── */
        .field-row {
            display:flex; gap:0;
            border-bottom:1px solid rgba(255,255,255,0.3);
            padding:12px 0;
        }
        .field-row:last-child { border-bottom:none; }
        .field-key {
            min-width:160px; font-size:0.72rem; font-weight:700;
            text-transform:uppercase; letter-spacing:1px; color:#888;
            padding-top:2px;
        }
        .field-val {
            flex:1; font-size:0.9rem; color:#1A1A1A; line-height:1.6;
            word-break:break-word;
        }

        .no-selection {
            flex:1; display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            color:#aaa; gap:12px;
        }
        .no-selection i { font-size:3rem; opacity:0.3; }
        .no-selection p { font-size:0.85rem; }

        /* ── Bottom action bar ── */
        .action-bar {
            padding:16px 24px;
            border-top:1px solid rgba(255,255,255,0.3);
            display:flex; gap:10px; align-items:center;
            background:rgba(255,255,255,0.1);
            flex-wrap:wrap;
        }
        .btn-action {
            padding:10px 22px; border:none; border-radius:10px;
            font-family:'Montserrat',sans-serif; font-size:0.75rem;
            font-weight:700; text-transform:uppercase; letter-spacing:1px;
            cursor:pointer; text-decoration:none; display:inline-flex;
            align-items:center; gap:7px; transition:opacity 0.2s, transform 0.2s;
        }
        .btn-action:hover { opacity:0.85; transform:translateY(-1px); }
        .btn-add  { background:var(--purple); color:white; }
        .btn-edit { background:#1A1A1A; color:white; }
        .btn-del  { background:var(--red); color:white; }
        .btn-view { background:rgba(255,255,255,0.4); color:#1A1A1A; border:1px solid rgba(255,255,255,0.5); }

        .msg-bar {
            margin:0 24px 0; padding:10px 16px;
            background:rgba(167,139,250,0.2); border:1px solid var(--purple);
            color:#5b21b6; border-radius:10px; font-size:0.85rem;
            margin-top:12px;
        }
    </style>
</head>
<body>

<!-- Top bar -->
<div class="top-bar">
    <div class="logo">Taylor's Version — Admin</div>
    <div class="user">
        Logged in as <strong><?php echo htmlspecialchars($_SESSION['admin_user']); ?></strong>
        &nbsp;(<?php echo htmlspecialchars($_SESSION['admin_role']); ?>)
        <a href="admin_logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="page">

    <!-- Tab bar -->
    <div class="tab-bar">
        <?php
        $tab_icons = ['albums'=>'fa-compact-disc','songs'=>'fa-music','tours'=>'fa-map-marker-alt','awards'=>'fa-trophy','personal_info'=>'fa-user','users'=>'fa-users-cog'];
        foreach ($sections as $s):
            $active = $s === $section ? 'active' : '';
            $icon   = $tab_icons[$s] ?? 'fa-circle';
            $label  = ucfirst(str_replace('_',' ',$s));
        ?>
            <a href="?section=<?php echo $s; ?>" class="<?php echo $active; ?>">
                <i class="fas <?php echo $icon; ?>"></i> <?php echo $label; ?>
            </a>
        <?php endforeach; ?>
        <a href="index.php" target="_blank" style="margin-left:auto;">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>
    </div>

    <?php if ($msg): ?>
        <div class="msg-bar"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <!-- Main split panel -->
    <div class="main-panel">

        <!-- LEFT: record list -->
        <div class="list-panel">
            <div class="list-header">
                <?php echo $title_label; ?> &nbsp;(<?php echo count($rows); ?>)
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterList()">
            </div>
            <div class="list-items" id="listItems">
                <?php if ($rows): ?>
                    <?php foreach ($rows as $row): ?>
                        <div class="list-item <?php echo $row[$pk] == $selected_id ? 'active' : ''; ?>"
                             onclick="location.href='?section=<?php echo $section; ?>&id=<?php echo $row[$pk]; ?>'">
                            <span class="item-id">#<?php echo $row[$pk]; ?></span>
                            <span><?php echo htmlspecialchars($row[$label_field] ?? '—'); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-item" style="color:#666;cursor:default;">No records found</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT: detail view -->
        <div class="detail-panel">
            <div class="detail-header">
                <h2><?php echo $selected ? htmlspecialchars($selected[$label_field] ?? 'Record #'.$selected_id) : 'Select a record'; ?></h2>
                <span class="count"><?php echo $title_label; ?></span>
            </div>

            <?php if ($selected): ?>
                <div class="detail-body">
                    <?php foreach ($selected as $key => $val): ?>
                        <div class="field-row">
                            <div class="field-key"><?php echo htmlspecialchars(str_replace('_',' ',$key)); ?></div>
                            <div class="field-val"><?php echo htmlspecialchars($val ?? '—'); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Action buttons -->
                <div class="action-bar">
                    <a href="admin_crud.php?section=<?php echo $section; ?>&action=add" class="btn-action btn-add">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                    <a href="admin_crud.php?section=<?php echo $section; ?>&action=edit&id=<?php echo $selected_id; ?>" class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this record?')">
                        <input type="hidden" name="action"    value="delete">
                        <input type="hidden" name="record_id" value="<?php echo $selected_id; ?>">
                        <button type="submit" class="btn-action btn-del">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>

            <?php else: ?>
                <div class="no-selection">
                    <i class="fas fa-hand-pointer"></i>
                    <p>Select a record from the list</p>
                    <a href="admin_crud.php?section=<?php echo $section; ?>&action=add" class="btn-action btn-add" style="margin-top:10px;">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            <?php endif; ?>

        </div><!-- /detail-panel -->
    </div><!-- /main-panel -->

</div><!-- /page -->

<script>
function filterList() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#listItems .list-item').forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>
