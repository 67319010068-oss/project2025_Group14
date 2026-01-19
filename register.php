<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก - Cosmetic Shop</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Sarabun:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-pink: #ff8e8e;
            --dark-pink: #ff6b6b;
            --accent-gold: #d4af37;
            --glass-white: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Sarabun', sans-serif;
            /* พื้นหลังไล่เฉดสีแบบนุ่มนวล */
            background: linear-gradient(45deg, #fdf2f2 0%, #fae1e1 50%, #fdf2f2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .register-card {
            background: var(--glass-white);
            backdrop-filter: blur(10px); /* เอฟเฟกต์กระจกฝ้า */
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            width: 100%;
            max-width: 480px;
            transition: transform 0.3s ease;
        }

        .brand-logo {
            font-size: 3.5rem;
            background: linear-gradient(to right, var(--dark-pink), var(--accent-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 5px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .register-card h2 {
            font-family: 'Playfair Display', serif; /* ฟอนต์หัวข้อแบบหรูหรา */
            color: #444;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
            margin-left: 5px;
        }

        .input-group {
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border-radius: 12px;
            overflow: hidden;
        }

        .input-group-text {
            background-color: #fff;
            border: 1px solid #eee;
            border-right: none;
            color: var(--primary-pink);
            padding-left: 1.2rem;
        }

        .form-control {
            border: 1px solid #eee;
            border-left: none;
            padding: 12px 15px;
            font-size: 0.95rem;
            color: #555;
        }

        .form-control:focus {
            border-color: #eee;
            box-shadow: none;
            background-color: #fff;
        }

        .btn-register {
            background: linear-gradient(to right, #ff6b6b, #ff8e8e);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            transition: all 0.4s ease;
            box-shadow: 0 8px 15px rgba(255, 107, 107, 0.2);
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(255, 107, 107, 0.3);
            filter: brightness(1.05);
        }

        .login-link {
            text-align: center;
            margin-top: 2rem;
            color: #888;
            font-size: 0.9rem;
        }

        .login-link a {
            color: var(--dark-pink);
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: all 0.3s;
        }

        .login-link a:hover {
            border-bottom: 1px solid var(--dark-pink);
        }

        /* ตกแต่ง Alert ให้ดูละมุนขึ้น */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 0.85rem;
        }
        .alert-danger { background-color: #fff5f5; color: #e03131; }
        .alert-success { background-color: #f3fbf7; color: #2f9e44; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="brand-logo">
        <i class="fa-solid fa-wand-magic-sparkles"></i>
    </div>
    <h2>Create Account</h2>
    
    <?php if(isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger d-flex align-items-center animate__animated animate__shakeX" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <div>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])) : ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            <div>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        </div>
    <?php endif; ?>

    <form action="register_db.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                <input type="text" name="username" class="form-control" placeholder="ชื่อผู้ใช้ของคุณ" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-envelope-open-text"></i></span>
                <input type="email" name="email" class="form-control" placeholder="example@shop.com" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน (6 ตัวขึ้นไป)" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-check-double"></i></span>
                <input type="password" name="confirm_password" class="form-control" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-register">
                SIGN UP NOW
            </button>
        </div>
    </form>
    
    <div class="login-link">
        มีบัญชีผู้ใช้แล้วใช่ไหม? <a href="login.php">เข้าสู่ระบบ</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>