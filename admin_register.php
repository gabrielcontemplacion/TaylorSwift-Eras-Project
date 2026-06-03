<?php
session_start();

$db = new mysqli('localhost', 'root', '', 'taylors_db');
if ($db->connect_error) die('DB error: ' . $db->connect_error);

$msg = '';
$msg_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($db->real_escape_string($_POST['username'] ?? ''));
    $password  = $_POST['password']  ?? '';
    $confirm   = $_POST['confirm']   ?? '';
    $role      = in_array($_POST['role'] ?? '', ['admin','editor']) ? $_POST['role'] : 'editor';

    if (!$username || !$password || !$confirm) {
        $msg = 'All fields are required.';
        $msg_type = 'err';
    } elseif (strlen($username) < 3) {
        $msg = 'Username must be at least 3 characters.';
        $msg_type = 'err';
    } elseif (strlen($password) < 6) {
        $msg = 'Password must be at least 6 characters.';
        $msg_type = 'err';
    } elseif ($password !== $confirm) {
        $msg = 'Passwords do not match.';
        $msg_type = 'err';
    } else {
        // Check if username already exists
        $check = $db->query("SELECT user_id FROM users WHERE username = '$username' LIMIT 1");
        if ($check && $check->num_rows > 0) {
            $msg = 'Username already taken. Choose another.';
            $msg_type = 'err';
        } else {
            $now = date('Y-m-d H:i:s');
            // Store plain password (matching your schema — use password_hash if you upgrade later)
            $db->query("INSERT INTO users (username, password, role, created_at, updated_at)
                        VALUES ('$username', '$password', '$role', '$now', '$now')");
            if ($db->affected_rows > 0) {
                $msg = "Account \"$username\" created successfully! You can now log in.";
                $msg_type = 'ok';
            } else {
                $msg = 'Something went wrong: ' . $db->error;
                $msg_type = 'err';
            }
        }
    }
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Taylor's Version Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&family=Playfair+Display:ital,wght@0,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --purple: #A78BFA;
            --red: #D32F2F;
            --lover-gradient: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 50%, #fde484 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--lover-gradient);
            background-attachment: fixed;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 20px 40px;
        }

        /* ── Top bar ── */
        .top-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(15px);
            padding: 18px 5%;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            z-index: 100;
        }
        .top-bar .logo {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: #1A1A1A;
        }

        /* ── Register card ── */
        .register-card {
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 25px;
            padding: 50px 45px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            text-align: center;
        }

        .register-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #1A1A1A;
            margin-bottom: 6px;
        }
        .register-card .sub {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--red);
            font-weight: 700;
            margin-bottom: 30px;
        }

        .accent {
            width: 50px;
            height: 4px;
            background: var(--purple);
            border-radius: 10px;
            margin: 0 auto 30px;
        }

        /* ── Messages ── */
        .msg-ok {
            background: rgba(167,139,250,0.15);
            border: 1px solid var(--purple);
            color: #5b21b6;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.88rem;
            margin-bottom: 20px;
            text-align: left;
        }
        .msg-err {
            background: rgba(211,47,47,0.1);
            border: 1px solid var(--red);
            color: var(--red);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.88rem;
            margin-bottom: 20px;
            text-align: left;
        }

        /* ── Fields ── */
        .field {
            margin-bottom: 18px;
            text-align: left;
        }
        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #555;
            margin-bottom: 7px;
        }
        .field input,
        .field select {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid rgba(255,255,255,0.6);
            border-radius: 12px;
            background: rgba(255,255,255,0.5);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            color: #1A1A1A;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .field input:focus,
        .field select:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(167,139,250,0.2);
        }

        /* Password strength bar */
        .strength-bar {
            height: 4px;
            border-radius: 10px;
            margin-top: 8px;
            background: #e0e0e0;
            overflow: hidden;
        }
        .strength-fill {
            height: 100%;
            border-radius: 10px;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }
        .strength-label {
            font-size: 0.68rem;
            color: #888;
            margin-top: 4px;
            text-align: right;
        }

        /* ── Buttons ── */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: var(--purple);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-top: 6px;
        }
        .btn-register:hover {
            background: #7c3aed;
            transform: translateY(-2px);
        }

        .divider {
            border: none;
            border-top: 1px solid rgba(0,0,0,0.1);
            margin: 22px 0;
        }

        .login-link {
            font-size: 0.82rem;
            color: #555;
        }
        .login-link a {
            color: var(--red);
            font-weight: 700;
            text-decoration: none;
        }
        .login-link a:hover { text-decoration: underline; }

        .back-link {
            display: inline-block;
            margin-top: 14px;
            font-size: 0.78rem;
            color: #777;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .back-link:hover { color: var(--red); }

        /* ── Success state ── */
        .success-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="logo">Taylor's Version</div>
    </div>

    <div class="register-card">

        <?php if ($msg_type === 'ok'): ?>
            <!-- Success state -->
            <div class="success-icon">✅</div>
            <p class="sub">Account Created</p>
            <h2>You're In!</h2>
            <div class="accent"></div>
            <div class="msg-ok"><?= htmlspecialchars($msg) ?></div>
            <a href="admin_login.php" class="btn-register" style="display:block; text-decoration:none; padding:14px; background:var(--red);">
                <i class="fas fa-sign-in-alt"></i> Go to Login
            </a>
            <br>
            <a href="admin_register.php" class="back-link">+ Register another account</a>

        <?php else: ?>
            <!-- Register form -->
            <p class="sub">Admin Panel</p>
            <h2>Create Account</h2>
            <div class="accent"></div>

            <?php if ($msg): ?>
                <div class="msg-err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form method="POST" action="" onsubmit="return validateForm()">

                <div class="field">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                           placeholder="At least 3 characters" required autocomplete="username">
                </div>

                <div class="field">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="At least 6 characters" required autocomplete="new-password"
                           oninput="checkStrength(this.value)">
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <div class="strength-label" id="strengthLabel"></div>
                </div>

                <div class="field">
                    <label for="confirm"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" id="confirm" name="confirm"
                           placeholder="Re-enter your password" required autocomplete="new-password">
                </div>

                <div class="field">
                    <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                    <select id="role" name="role">
                        <option value="editor" <?= ($_POST['role'] ?? '') === 'editor' ? 'selected' : '' ?>>Editor</option>
                        <option value="admin"  <?= ($_POST['role'] ?? '') === 'admin'  ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>

            <hr class="divider">
            <p class="login-link">Already have an account? <a href="admin_login.php">Log in</a></p>
            <a href="index.php" class="back-link">← Back to main site</a>
        <?php endif; ?>

    </div>

    <script>
        function checkStrength(pw) {
            const fill  = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');
            let score = 0;
            if (pw.length >= 6)  score++;
            if (pw.length >= 10) score++;
            if (/[A-Z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;

            const levels = [
                { pct: '20%',  color: '#e53935', text: 'Very Weak' },
                { pct: '40%',  color: '#fb8c00', text: 'Weak' },
                { pct: '60%',  color: '#fdd835', text: 'Fair' },
                { pct: '80%',  color: '#7cb342', text: 'Strong' },
                { pct: '100%', color: '#43a047', text: 'Very Strong' },
            ];
            const lvl = levels[Math.max(0, score - 1)];
            if (!pw) { fill.style.width = '0%'; label.textContent = ''; return; }
            fill.style.width    = lvl.pct;
            fill.style.background = lvl.color;
            label.textContent   = lvl.text;
            label.style.color   = lvl.color;
        }

        function validateForm() {
            const pw  = document.getElementById('password').value;
            const cfm = document.getElementById('confirm').value;
            if (pw !== cfm) {
                alert('Passwords do not match!');
                return false;
            }
            if (pw.length < 6) {
                alert('Password must be at least 6 characters.');
                return false;
            }
            return true;
        }
    </script>

</body>
</html>
