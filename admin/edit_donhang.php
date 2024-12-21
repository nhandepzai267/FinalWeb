<?php
include './connect_db.php';
$error = false;
$success = false;

if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $content = mysqli_real_escape_string($con, $_POST['content']);
        $status = mysqli_real_escape_string($con, $_POST['status']);
        
        $query = "UPDATE `orders` SET 
            `name` = '$name',
            `email` = '$email',
            `phone` = '$phone',
            `address` = '$address',
            `content` = '$content',
            `status` = '$status'
            WHERE `id` = '$id'";
            
        $result = mysqli_query($con, $query);
        
        if (!$result) {
            $error = "Không thể cập nhật. Lỗi SQL: " . mysqli_error($con);
        } else {
            $success = true;
        }
        mysqli_close($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đổi thông tin đơn hàng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php if ($error): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '<?= $error ?>',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location.href = './dathang.php';
            });
        </script>
    <?php endif; ?>

    <?php if ($success): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: 'Cập nhật đơn hàng thành công',
                confirmButtonText: 'OK'
            }).then((result) => {
                window.location.href = './dathang.php';
            });
        </script>
    <?php endif; ?>

    <?php
    if (!$error && !$success) {
        $result = mysqli_query($con, "SELECT * FROM orders where `id`=" . $_GET['id']);
        $user = mysqli_fetch_assoc($result);
        if (!empty($user)) {
            ?>
            <div style="width: 600px; margin: 0 auto;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Sửa đơn hàng "<?= $user['id'] ?>"</h4>
                        <form action="./edit_donhang.php?action=edit" method="Post" autocomplete="off">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>" />
                        
                        <div class="form-group">
                            <label class="form-label">Tên khách hàng:</label>
                            <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Số điện thoại:</label>
                            <input type="text" class="form-control" name="phone" value="<?= $user['phone'] ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Địa chỉ:</label>
                            <textarea class="form-control" name="address" rows="3"><?= $user['address'] ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nội dung:</label>
                            <textarea class="form-control" name="content" rows="3"><?= $user['content'] ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tình trạng:</label>
                            <select class="form-select" name="status">
                                <option <?= $user['status'] == 0 ? 'selected' : '' ?> value="0">Đang xử lý</option>
                                <option <?= $user['status'] == 1 ? 'selected' : '' ?> value="1">Đang giao hàng</option>
                                <option <?= $user['status'] == 2 ? 'selected' : '' ?> value="2">Thành công</option>
                                <option <?= $user['status'] == 3 ? 'selected' : '' ?> value="3">Đơn hàng bị hủy</option>
                            </select>
                        </div>
                        
                        <div class="text-center mt-4">
                        <input type="submit" class="btn btn-primary" value="Cập nhật" style="padding: 0.375rem 0.75rem; font-size: 14px;" />
                        <a href="./dathang.php" class="btn btn-secondary ms-2" style="padding: 0.375rem 0.75rem; font-size: 14px;">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    }
    ?>

    <!-- Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
