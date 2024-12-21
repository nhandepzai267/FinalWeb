<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
    <link rel="icon" type="logo/png" sizes="32x32" href="logo/logo.png">
        <title>Đổi thông tin thành viên</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body {
                background-color: #ffffff;
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            
            .box-content {
                margin: 0 auto;
                width: 100%;
                max-width: 500px;
                padding: 2.5rem;
                background-color: #ffffff;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            .box-content h1 {
                color: #333;
                font-size: 24px;
                margin-bottom: 1.5rem;
                font-weight: 600;
            }

            .form-control {
                background-color: #f8f9fa;
                border: 1px solid #e0e0e0;
                padding: 12px;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                background-color: #fff;
                border-color: #ff3333;
                box-shadow: 0 0 0 0.2rem rgba(255, 51, 51, 0.25);
            }

            .form-label {
                color: #555;
                font-weight: 500;
                margin-bottom: 0.5rem;
            }

            .btn-primary {
                background-color: #ff3333;
                border: none;
                padding: 12px 24px;
                border-radius: 8px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #e60000;
                transform: translateY(-1px);
            }

            .alert {
                border-radius: 8px;
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .alert-danger {
                background-color: #fff2f2;
                border-color: #ffcccc;
                color: #cc0000;
            }

            .alert-success {
                background-color: #f2fff2;
                border-color: #ccffcc;
                color: #008000;
            }

            .box-content a {
                color: #ff3333;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .box-content a:hover {
                color: #e60000;
                text-decoration: underline;
            }

            @media (max-width: 576px) {
                .box-content {
                    margin: 1rem;
                    padding: 1.5rem;
                }
                
                .box-content h1 {
                    font-size: 20px;
                }
            }
        </style>
    </head>
    <body>
        <?php
        include './connect_db.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            if (isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['old_password']) && !empty($_POST['old_password']) && isset($_POST['new_password']) && !empty($_POST['new_password'])
            ) {
                $userResult = mysqli_query($con, "Select * from `user` WHERE (`id` = " . $_POST['user_id'] . " AND `password` = '" . md5($_POST['old_password']) . "')");
                if ($userResult->num_rows > 0) {
                    $result = mysqli_query($con, "UPDATE `user` SET `password` = MD5('" . $_POST['new_password'] . "'), `last_updated`=" . time() . " WHERE (`id` = " . $_POST['user_id'] . " AND `password` = '" . md5($_POST['old_password']) . "')");
                    if (!$result) {
                        $error = "Không thể cập nhật tài khoản";
                    }
                } else {
                    $error = "Mật khẩu cũ không đúng.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: '<?= $error ?>',
                            confirmButtonColor: '#ff3333'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = './doimatkhau.php';
                            }
                        });
                    </script>
                <?php } else { ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Mật khẩu đã được cập nhật thành công!',
                            confirmButtonColor: '#ff3333'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = './index.php';
                            }
                        });
                    </script>
                <?php } ?>
            <?php } else { ?>
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Vui lòng nhập đủ thông tin để sửa tài khoản',
                        confirmButtonColor: '#ff3333'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './doimatkhau.php';
                        }
                    });
                </script>
            <?php
            }
        } else {
            session_start();
            $user = $_SESSION['user'];
            if (!empty($user)) {
                ?>
                <div id="edit_user" class="box-content">
                    <h1 class="mb-4">Xin chào "<?= $user['fullname'] ?>". Bạn đang thay đổi mật khẩu</h1>
                    <form action="./doimatkhau.php?action=edit" method="Post" autocomplete="off">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Password cũ</label>
                            <input type="password" class="form-control" name="old_password" value="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password mới</label>
                            <input type="password" class="form-control" name="new_password" value="" />
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                    </form>
                </div>
                <?php
            }
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    </body>
</html>
