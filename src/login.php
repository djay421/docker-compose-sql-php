<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = require 'partials/dbconnection.php';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid password';
            }
        } else {
            $error = 'User not found';
        }
        $stmt->close();
    } else {
        $error = 'Please enter username and password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — RevZone Scooter Parts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Barlow:wght@300;400;500;600&family=Oswald:wght@300;400;500;600;700&display=swap">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Barlow:wght@300;400;500;600&family=Oswald:wght@300;400;500;600;700&display=swap');

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --carbon:      #0a0a0c;
            --carbon-light:#17171e;
            --red:         #e8001a;
            --red-dim:     rgba(232,0,26,0.15);
            --chrome:      #c8cdd8;
            --chrome-dim:  #6e7480;
            --text:        #d4d8e2;
            --text-bright: #f0f2f8;
            --text-muted:  #44475a;
            --ff-display: 'Oswald', sans-serif;
            --ff-condensed:'Barlow Condensed', sans-serif;
            --ff-body:    'Barlow', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--ff-body);
            background: var(--carbon);
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,0.012) 2px, rgba(255,255,255,0.012) 4px),
                repeating-linear-gradient(-45deg, transparent, transparent 2px, rgba(255,255,255,0.008) 2px, rgba(255,255,255,0.008) 4px);
            background-size: 8px 8px;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--red);
            z-index: 999;
        }

        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }

        .auth-card {
            background: var(--carbon-light);
            border: 1px solid rgba(200, 205, 216, 0.1);
            border-radius: 12px;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--red) 0%, transparent 100%);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .auth-logo-mark {
            width: 44px; height: 44px;
            background: var(--red);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .auth-logo-mark svg { width: 24px; height: 24px; }

        .auth-brand {
            font-family: var(--ff-display);
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-bright);
        }

        .auth-brand em {
            color: var(--red);
            font-style: normal;
        }

        .auth-title {
            font-family: var(--ff-display);
            font-size: 1.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-bright);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            font-size: 0.9rem;
            color: var(--chrome-dim);
            font-weight: 300;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            min-width: 0;
        }

        .form-label {
            font-family: var(--ff-condensed);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--chrome-dim);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(200, 205, 216, 0.15);
            border-radius: 6px;
            padding: 0.95rem 1rem;
            font-family: var(--ff-body);
            font-size: 1rem;
            color: var(--text-bright);
            transition: all 0.3s;
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(232, 0, 26, 0.1);
        }

        .form-submit {
            background: linear-gradient(135deg, var(--red) 0%, #ff2a3a 100%);
            border: none;
            border-radius: 6px;
            padding: 1.1rem;
            font-family: var(--ff-condensed);
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .form-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(232, 0, 26, 0.3);
        }

        .form-submit:active {
            transform: translateY(0);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(200, 205, 216, 0.15);
        }

        .auth-divider-text {
            font-size: 0.8rem;
            color: var(--chrome-dim);
            font-weight: 500;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .auth-footer a {
            color: var(--red);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .auth-footer a:hover {
            opacity: 0.8;
        }

        .error-message {
            background: rgba(232, 0, 26, 0.15);
            border: 1px solid rgba(232, 0, 26, 0.35);
            border-radius: 6px;
            padding: 1rem;
            color: #ff6b7a;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .error-message::before {
            content: '⚠';
            flex-shrink: 0;
            font-size: 1.2rem;
        }

        @media (max-width: 640px) {
            .auth-container {
                padding: 1rem;
            }

            .auth-card {
                padding: 2rem 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <div class="auth-logo-mark">
                    <svg viewBox="0 0 20 20" fill="white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2L3 6v8l7 4 7-4V6L10 2z"/>
                    </svg>
                </div>
                <span class="auth-brand">REV<em>ZONE</em></span>
            </div>
            <h1 class="auth-title">Welcome</h1>
            <p class="auth-subtitle">Sign in to your performance parts account</p>
        </div>

        <?php if ($error): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input" placeholder="Enter your username" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="form-submit">Sign In</button>
        </form>

        <div class="auth-divider">
            <span class="auth-divider-text">NEW TO REVZONE?</span>
        </div>

        <div class="auth-footer">
            <a href="register.php">Create an account →</a>
        </div>
    </div>
</div>

</body>
</html>
