<!DOCTYPE html>
<html>
<head>
    <title>Đặt lại mật khẩu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="logo/png" sizes="32x32" href="logo/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Lato', sans-serif;
        }

        .reset-password-form {
            width: 24%;
            margin: 0 auto;
            padding: 30px 64px;
            background-color: #ffffff;
            border-radius: 10px;
            border: 2px solid #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .reset-password-form h4 {
            color: #333;
            font-size: 26px;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .reset-password-form .form-label {
            color: #555;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 15px;
        }

        .reset-password-form .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: none;
            border-bottom: 2px solid #e6e6e6;
            outline: none;
            color: #000000;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }

        .reset-password-form .form-control:focus {
            border-bottom: 2px solid #ff3333;
            box-shadow: none;
        }

        .reset-password-form .has-error {
            color: #ff3333;
            font-size: 13px;
            margin-top: -15px;
            margin-bottom: 15px;
            display: block;
        }

        .reset-password-form .btn-primary {
            background: #ff3333;
            color: #FFFFFF;
            text-align: center;
            padding: 14px 0;
            border: none;
            border-radius: 100px;
            border-bottom: 5px solid #e60000;
            font-size: 17px;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }

        .reset-password-form .btn-primary:hover {
            background: #e60000;
            border-bottom: 5px solid #ff3333;
            transform: translateY(-1px);
        }

        @media (max-width: 1280px) {
            .reset-password-form {
                width: 30%;
            }
        }

        @media (max-width: 1080px) {
            .reset-password-form {
                width: 40%;
            }
        }

        @media (max-width: 800px) {
            .reset-password-form {
                width: 50%;
                padding: 30px 40px;
            }
        }

        @media (max-width: 480px) {
            .reset-password-form {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <?php
    if(!isset($_SESSION)) {
        session_start();
    }
    include 'connect_db.php';
    $error = [];
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    ?>
    
    <div class="container">
        <form method="POST" class="reset-password-form">
            <h4>ĐẶT LẠI MẬT KHẨU</h4>
            <div class="mb-3">
                <label class="form-label">Nhập mật khẩu mới</label>
                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới">
                <div class="has-error">
                    <span><?php echo (isset($error['password'])) ? $error['password'] : '' ?></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" name="rpassword" placeholder="Nhập lại mật khẩu mới">
                <div class="has-error">
                    <span><?php echo (isset($error['rpassword'])) ? $error['rpassword'] : '' ?></span>
                </div>
            </div>
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <button type="submit" name="submit" class="btn btn-primary">Xác nhận</button>
        </form>
    </div>
</body>
</html>