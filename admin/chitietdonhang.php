<?php
include 'connect_db.php';
if(!isset($_SESSION)) {
    session_start();
}

// Lấy order_id từ URL
$order_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Query để lấy thông tin chi tiết đơn hàng
$sql = "SELECT orders_detail.*, product.name as product_name, product.image 
        FROM orders_detail 
        LEFT JOIN product ON orders_detail.product_id = product.id 
        WHERE orders_detail.order_id = $order_id";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết đơn hàng</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="../logo/png" sizes="32x32" href="../logo/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet">
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .content {
            padding: 2rem;
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .order-details {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .order-header {
            background:rgb(255, 0, 0);
            color: #fff;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0;
        }

        .order-header h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 500;
        }

        .table-responsive {
            padding: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            padding: 1rem;
            border-bottom: 2px solid #dee2e6;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .quantity {
            background: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 500;
        }

        .price {
            font-weight: 600;
            color:rgb(0, 0, 0);
        }

        .total-row {
            background: #f8f9fa;
        }

        .total-row td {
            font-size: 1.4rem !important;
            font-weight: 700;
            padding: 1.5rem 1rem !important;
        }

        .total-row .price {
            color: #e74c3c;
            font-size: 1.6rem !important;
        }

        .btn-back {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            margin: 1.5rem;
            background:rgb(255, 0, 0);
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background:rgb(192, 43, 43);
            color: #fff;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }

            .table th, 
            .table td {
                padding: 0.75rem;
            }

            .table img {
                width: 60px;
                height: 60px;
            }

            .order-header h2 {
                font-size: 1.2rem;
            }

            .btn-back {
                padding: 0.6rem 1.2rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body class="theme-red">
    <section class="content">
        <div class="container-fluid">
            <div class="order-details">
                <div class="order-header">
                    <h2>CHI TIẾT ĐƠN HÀNG #<?php echo $order_id; ?></h2>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="100">Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th width="100">Số lượng</th>
                                <th width="150">Đơn giá</th>
                                <th width="150">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            while($row = mysqli_fetch_array($result)) {
                                $subtotal = $row['price'] * $row['quantity'];
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td><img src="../<?php echo $row['image']; ?>" width="80"></td>
                                <td class="product-name"><?php echo $row['product_name']; ?></td>
                                <td class="text-center"><span class="quantity"><?php echo $row['quantity']; ?></span></td>
                                <td class="price text-right"><?php echo number_format($row['price']); ?>đ</td>
                                <td class="price text-right"><?php echo number_format($subtotal); ?>đ</td>
                            </tr>
                            <?php } ?>
                            <tr class="total-row">
                                <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                                <td class="price text-right"><strong><?php echo number_format($total); ?>đ</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="dathang.php" class="btn-back">
                        <i class="material-icons"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Include your admin footer scripts here -->
</body>
</html> 