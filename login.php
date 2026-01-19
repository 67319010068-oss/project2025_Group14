<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - Cosmetic Shop</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-pink: #ff6b6b;
            --hover-pink: #ee5253;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background: linear-gradient(135deg, #fdf2f2 0%, #fae1e1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.15);
            width: 100%;
            max-width: 400px;
        }

        .brand-logo {
            font-size: 3rem;
            color: var(--primary-pink);
            text-align: center;
            margin-bottom: 10px;
        }

        .login-card h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #aaa;
        }

        .input-group .form-control {
            border-left: none;
        }

        .btn-login {
            background-color: var(--primary-pink);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: var(--hover-pink);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(238, 82, 83, 0.3);
        }

        .error-msg {
            background-color: #fff5f5;
            color: #e03131;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ffc9c9;
            margin-bottom: 1rem;
            text-align: center;
            font-size: 0.9rem;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #777;
        }

        .register-link a {
            color: var(--primary-pink);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-logo">
        <i class="fa-solid fa-circle-user"></i>
    </div>
    <h2>เข้าสู่ระบบ</h2>

    <?php if(isset($error)): ?>
        <div class="error-msg">
            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">ชื่อผู้ใช้</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="กรอกชื่อผู้ใช้" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">รหัสผ่าน</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่าน" required>
            </div>
        </div>

        <button type="submit" name="login" class="btn btn-login">
            เข้าสู่ระบบ
        </button>
    </form>

    <div class="register-link">
        ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิกที่นี่</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>