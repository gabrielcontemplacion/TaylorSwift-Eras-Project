<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli('localhost', 'root', '', 'taylors_db');

    if ($db->connect_error) {
        $error = 'Database connection failed.';
    } else {
        $username = $db->real_escape_string($_POST['username']);
        $password = $_POST['password'];

        $result = $db->query("SELECT * FROM users WHERE username = '$username' LIMIT 1");

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Use password_verify if passwords are hashed; plain compare for now
            if ($password === $user['password'] || password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user']      = $user['username'];
                $_SESSION['admin_role']      = $user['role'];
                header('Location: admin_dashboard.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
        $db->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Taylor's Version</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&family=Playfair+Display:ital,wght@0,700;1,900&display=swap" rel="stylesheet">
    <style>
        :root {
            --yellow: #F6E27F;
            --purple: #A78BFA;
            --red: #D32F2F;
            --white: #F7F7F7;
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
        }

        /* ── top bar (mirrors header in main site) ── */
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

        /* ── login card ── */
        .login-card {
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 25px;
            padding: 50px 45px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #1A1A1A;
            margin-bottom: 6px;
        }
        .login-card .sub {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--red);
            font-weight: 700;
            margin-bottom: 30px;
        }

        .accent { width: 50px; height: 4px; background: var(--red); border-radius: 10px; margin: 0 auto 30px; }

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
        .field input {
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
        .field input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(167,139,250,0.2);
        }

        .error-msg {
            background: rgba(211,47,47,0.1);
            border: 1px solid rgba(211,47,47,0.3);
            color: var(--red);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.85rem;
            margin-bottom: 16px;
            text-align: left;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--red);
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
        .btn-login:hover { background: #b71c1c; transform: translateY(-2px); }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 0.78rem;
            color: #555;
            text-decoration: none;
            letter-spacing: 1px;
        }
        .back-link:hover { color: var(--red); }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="logo">Taylor's Version</div>
    </div>

    <div class="login-card">
        <p class="sub">Admin Panel</p>
        <h2>Welcome Back</h2>
        <div class="accent"></div>

        <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required autocomplete="username">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">Log In</button>
        </form>

        <hr style="border:none;border-top:1px solid rgba(0,0,0,0.1);margin:20px 0;">
        <p style="font-size:0.82rem;color:#555;">No account yet? <a href="admin_register.php" style="color:var(--red);font-weight:700;text-decoration:none;">Register here</a></p>
        <a href="index.php" class="back-link">← Back to main site</a>
    </div>

</body>
</html>
