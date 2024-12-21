<!DOCTYPE html>
<html>
<head>
    <title>Thêm Danh Mục</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #dc3545; /* Changed to Bootstrap red */
            --secondary-color: #6c757d;
            --background-color: #fff;
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
            border-radius: 1rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(220, 53, 69, 0.15); /* Red tinted shadow */
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
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

        /* Custom red button - override Bootstrap's primary color */
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #bb2d3b !important;
            border-color: #bb2d3b !important;
        }

        /* Add red accents */
        .card {
            border-top: 3px solid #dc3545;
        }
    </style>
</head>
<body>
    <?php
    include 'connect_db.php';
    include 'function.php';

    $sql = "SELECT * FROM `menu_product`";
    $menu = mysqli_query($con, $sql);
    $menu_pro = mysqli_fetch_all($menu, MYSQLI_ASSOC);
    
    if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $error = null;
            
            if ($_GET['action'] == 'edit' && !empty($_GET['id'])) {
                $result = mysqli_query($con, "UPDATE `menu_product` SET `name` = '" . $_POST['name'] . "' WHERE `menu_product`.`id` = " . $_GET['id']);
            } else {
                $result = mysqli_query($con, "INSERT INTO `menu_product` (`id`, `name`) VALUES (NULL, '" . $_POST['name'] . "');");
            }
            
            if (!$result) {
                $error = "Danh mục đã tồn tại";
            }
            ?>
            
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <?php if ($error): ?>
                                    <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size: 3rem;"></i>
                                    <h4 class="card-title mb-4">Thông báo</h4>
                                    <p class="card-text text-danger"><?= $error ?></p>
                                <?php else: ?>
                                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                                    <h4 class="card-title mb-4">Thành công!</h4>
                                    <p class="card-text text-success">Thêm danh mục thành công</p>
                                <?php endif; ?>
                                <a href="menu_product.php" class="btn btn-primary mt-3">Quay lại danh sách danh mục</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php }
    } else { ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center mb-4">Thêm Danh Mục Mới</h4>
                            <form id="product-form" method="POST" action="?action=add" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục:</label>
                                    <input type="text" name="name" class="form-control" required />
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Lưu danh mục</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
