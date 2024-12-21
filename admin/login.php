<?php
session_start();
include './connect_db.php';

$error_message = '';
$error_title = '';

if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($con, "SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password'");
    
    if (!$result) {
        $error_title = 'Lỗi';
        $error_message = mysqli_error($con);
    } else {
        $admin = mysqli_fetch_assoc($result);
        if ($admin) {
            // Kiểm tra status
            if ($admin['status'] == 0) {
                $error_title = 'Tài khoản bị khóa';
                $error_message = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Admin.';
            } else {
                $_SESSION['admin'] = $admin;
                header('Location: index.php');
                exit();
            }
        } else {
            $error_title = 'Đăng nhập thất bại';
            $error_message = 'Thông tin đăng nhập không chính xác';
        }
    }
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đăng nhập hệ thống</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <style>
            :root {
                --primary-color: #4e73df;
                --secondary-color: #858796;
                --background-color: #f8f9fc;
                --card-color: #ffffff;
            }

            body {
                min-height: 100vh;
                background: var(--background-color);
                display: flex;
                align-items: center;
            }

            .login-wrapper {
                width: 100%;
                padding: 2rem 0;
            }

            .login-container {
                max-width: 850px;
                margin: 0 auto;
                background: var(--card-color);
                border-radius: 1rem;
                overflow: hidden;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }

            .login-row {
                display: flex;
                flex-wrap: wrap;
            }

            .login-left {
                flex: 1;
                padding: 3rem;
                background: linear-gradient(145deg, var(--primary-color), #224abe);
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .login-right {
                flex: 1;
                padding: 3rem;
            }

            .login-header {
                margin-bottom: 2rem;
            }

            .form-control {
                padding: 1rem;
                border-radius: 0.5rem;
                border: 1px solid #e3e6f0;
            }

            .form-control:focus {
                border-color: #bac8f3;
                box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            }

            .btn-login {
                padding: 0.75rem;
                border-radius: 0.5rem;
                background: var(--primary-color);
                border: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-login:hover {
                background: #224abe;
                transform: translateY(-1px);
            }

            .divider {
                position: relative;
                text-align: center;
                margin: 1.5rem 0;
            }

            .divider::before {
                content: "";
                position: absolute;
                left: 0;
                top: 50%;
                width: 45%;
                height: 1px;
                background: #e3e6f0;
            }

            .divider::after {
                content: "";
                position: absolute;
                right: 0;
                top: 50%;
                width: 45%;
                height: 1px;
                background: #e3e6f0;
            }

            .social-login button {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #e3e6f0;
                border-radius: 0.5rem;
                background: white;
                margin-bottom: 1rem;
                transition: all 0.3s ease;
            }

            .social-login button:hover {
                background: #f8f9fc;
            }

            @media (max-width: 768px) {
                .login-left {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <?php if (empty($_SESSION['admin'])) { ?>
        <div class="login-wrapper">
            <div class="container">
                <div class="login-container">
                    <div class="login-row">
                        <!-- Left Side -->
                        <div class="login-left">
                            <h2 class="mb-4">Welcome Back!</h2>
                            <p class="mb-4">Truy cập bảng điều khiển quản trị viên bằng tài khoản cá nhân của bạn. Quản lý tất cả nội dung, người dùng và cài đặt của bạn ở cùng một nơi.</p>
                            <!-- <img src="https://i.imgur.com/ax0NCsK.gif" alt="Logo" class="img-fluid" style="max-width: 200px;"> -->
                        </div>

                        <!-- Right Side -->
                        <div class="login-right">
                            <div class="login-header">
                                <h4 class="mb-2">Đăng nhập</h4>
                                <p class="text-muted">Nhập thông tin xác thực của bạn để truy cập vào tài khoản của bạn</p>
                            </div>

                            <form action="./login.php" method="post" autocomplete="off">
                                <div class="mb-4">
                                    <label class="form-label">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <!-- <span class="input-group-text"><i class="fas fa-user"></i></span> -->
                                        <input type="text" class="form-control" name="username" placeholder="Nhập tên đăng nhập" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label">Mật khẩu</label>
                                        <!-- <a href="#" class="text-decoration-none small">Forgot Password?</a> -->
                                    </div>
                                    <div class="input-group">
                                        <!-- <span class="input-group-text"><i class="fas fa-lock"></i></span> -->
                                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary btn-login w-100">
                                        Đăng nhập
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } else {
            header('location:index.php');
        } ?>
        
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php if (!empty($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '<?php echo $error_title; ?>',
                text: '<?php echo $error_message; ?>',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Đóng'
            });
        </script>
        <?php endif; ?>
    </body>
</html>


<html>

<head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
  
</head>

<body>
  

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>


