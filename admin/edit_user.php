<!DOCTYPE html>
<html>
<head>
    <title>Đổi thông tin người dùng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #dc3545; /* Changed to red */
            --secondary-color: #6c757d;
            --background-color: #ffffff; /* Light pink/red tint background */
            --card-color: #ffffff;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            background: var(--background-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .card {
            border: none;
            margin: 20px auto;
            border-radius: 1rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(220, 53, 69, 0.15);
            border-top: 3px solid #dc3545; /* Red accent */
            width: 600px; /* Thêm độ rộng cố định */
            max-width: 100%; /* Đảm bảo responsive trên màn hình nhỏ */
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus {
            border-color: #ff8b96; /* Light red */
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25); /* Red shadow */
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #bb2d3b; /* Darker red */
            transform: translateY(-1px);
            border-color: #bb2d3b;
        }

        .btn-primary:focus,
        .btn-primary:active {
            background-color: #bb2d3b !important;
            border-color: #bb2d3b !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 700;
        }

        .form-label {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <?php
    include './connect_db.php';
    $error = false;
    if (isset($_GET['action']) && $_GET['action'] == 'edit') {
        if (isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $fullname = $_POST['name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $gioitinh = $_POST['gender'];
            $sdt = $_POST['phone'];
            
            $result = mysqli_query($con, "UPDATE `user` SET 
                `password` = MD5('" . $_POST['password'] . "'), 
                `fullname` = '$fullname', 
                `email` = '$email', 
                `username` = '$username', 
                `gioitinh` = '$gioitinh',
                `sdt` = '$sdt',  
                `last_updated`=" . time() . " 
                WHERE `user`.`id` = " . $_POST['user_id'] . ";");

            if ($result) {
                echo "success";
            } else {
                echo "error";
            }
            exit;
        }
    } else {
        $result = mysqli_query($con, "SELECT * FROM user where `id`=" . $_GET['id']);
        $user = $result->fetch_assoc();
        mysqli_close($con);
        if (!empty($user)) { ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center mb-4">Sửa tài khoản "<?= $user['username'] ?>"</h4>
                                <form action="./edit_user.php?action=edit" method="Post" autocomplete="off">
                                    <div class="mb-4">
                                        <label class="form-label">Họ tên</label>
                                        <input type="text" name="name" class="form-control" 
                                               value="<?= isset($user['fullname']) ? htmlspecialchars($user['fullname']) : '' ?>" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" 
                                               value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" 
                                               value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : '' ?>" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" class="form-control" required />
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="tel" name="phone" class="form-control" 
                                               value="<?= isset($user['sdt']) ? htmlspecialchars($user['sdt']) : '' ?>" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Giới tính</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="">Chọn giới tính</option>
                                            <option value="Nam" <?= (isset($user['gioitinh']) && $user['gioitinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                            <option value="Nữ" <?= (isset($user['gioitinh']) && $user['gioitinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    } ?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap JS -->
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('./edit_user.php?action=edit', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if(data.includes("success")) {
            Swal.fire({
                title: 'Thành công!',
                text: 'Cập nhật thông tin thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './khachhang.php';
                }
            });
        } else {
            Swal.fire({
                title: 'Lỗi!',
                text: 'Có lỗi xảy ra khi cập nhật thông tin',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Lỗi!',
            text: 'Có lỗi xảy ra khi gửi yêu cầu',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});
</script>
</body>
</html>
