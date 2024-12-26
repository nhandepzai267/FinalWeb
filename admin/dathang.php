<?php
include 'connect_db.php';
if(!isset($_SESSION))
{
    session_start();
}
$category = mysqli_query($con, "SELECT * FROM `orders` ");
//B1: tính tổng số bản ghi

$total = mysqli_num_rows($category);

//B2 : THiết lập số bảng ghi trên 1 trang
$limit = 5;
//B3: tính số trang
$page = ceil($total / $limit);
//B4: lấy trang hiện tại
$current_page = (isset($_GET['page']) ? $_GET['page'] : 1);
//B5: tính start
$start = ($current_page - 1) * $limit;
//B6: query sử dụng limit
$category = mysqli_query($con,"SELECT * FROM `orders` ORDER BY created_time DESC");
    ?>
<!DOCTYPE html>
<html>

<head>
    <style>
       img{
  width: 100%;
}
.buttons{
    text-align: right;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 15px;
    line-height: 38px;
}
.buttons a{
    color: #FFF;
    padding: 10px;
    background: #f44336;
}
 .buttons a:hover {
    color: #ffffff;
    text-decoration: none;
    opacity: 0.8;
}
.page-item {
    border: 1px solid rgba(0,0,0,0.4);
    width: 35px;
    display: inline-block;
    text-align: center;
    line-height: 20px;
    color: black;
}

    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Quan ly don hang</title>
    <!-- Favicon-->
    <link rel="icon" type="../logo/png" sizes="32x32" href="../logo/logo.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar" style="background-color: #000000;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">ADMIN PAGE</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <?php
            include "info.php";
            ?>
            <!-- Menu -->
            <?php
            include "menu.php";
           ?>
            
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
       
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Quản lý</h2>
            </div>

            <!-- Widgets -->
            <?php
            include "quanly.php";
            ?>
            <!-- #END# Widgets -->
            
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quản lý đơn hàng
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID đơn hàng</th>
                                            <th>ID khách hàng</th>
                                            <th>Tên khách hàng </th>
                                            <th>Email khách hàng </th>
                                            <th>Số điện thoại </th>
                                            <th>Địa chỉ</th>
                                            <th>Nội dung</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tình trạng</th>
                                            <th>Chi tiết</th>
                                            <th>Sửa</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    while ($row = mysqli_fetch_array($category)) {
                                    ?>
                                        <tr> 
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['user_id'] ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td><?php echo $row['phone'] ?></td>
                                        <td><?php echo $row['address'] ?></td>
                                        <td><?php echo $row['content'] ?></td>
                                        <td><?php echo date('d/m/Y H:i', $row['created_time']) ?></td>
                                        <?php
                                        if ($row['status']==0) 
                                        {
                                            echo '<td class="text-danger">Đang Xử Lý</td>';
                                        }
                                        elseif($row['status']==1)
                                        {
                                        echo '<td class="text-success">Đang Giao Hàng</td>';
                                        }
                                        elseif($row['status']==2)
                                        {
                                        echo '<td class="text-success">Thành Công</td>';
                                        }
                                        else
                                            echo '<td class="text-danger">Đơn hàng bị hủy</td>';
                                        ?>
                                    <td>
                                        <a href="chitietdonhang.php?id=<?= $row['id'] ?>" class="btn btn-danger">Chi tiết</a>
                                    </td>    
                                    <td>
                                        <a href="./edit_donhang.php?id=<?= $row['id'] ?> " class="btn btn-danger">Edit</a>
                                    </td>
                                    <td><a onclick="return confirmDelete(<?= $row['id'] ?>)" href="javascript:void(0)" class="btn btn-danger">Xóa</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                     
                                </table>
                                <div class="pagination-bar my-3">
                                <div class="col-12">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                        
                                        <ul class="pagination">
                                           
                                        <?php if($current_page -1 > 0) { ?>
                                            <li><a href="dathang.php?page=<?php echo $current_page -1 ?>">&laquo;</a></li>
                                            <?php } ?>
                                            <?php for($i=1; $i<=$page ;$i++) { ?>
                                                <li class="<?php echo ($current_page ==$i) ? 'active' : '' ?>"><a href="dathang.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                              <?php  }?>
                                              
                                              <?php if($current_page +1 <= $page ) { ?>
                                            <li><a href="dathang.php?page=<?php echo $current_page +1 ?>">&raquo;</a></li>
                                            <?php } ?>
                                        </ul>
                                        
                                        
                                        </ul>
                                    </nav>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            
        </div>
        <?php


?>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <style>
    .swal2-popup {
        font-size: 1.2em !important;
    }
    /* body.swal2-shown > [aria-hidden="true"] {
        transition: 0.1s filter;
        filter: blur(1px);
    } */
    body.swal2-shown {
        padding-right: 0 !important;
        overflow-y: auto !important;
    }
    .swal2-container {
        padding-right: 0 !important;
    }
</style>
    
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: '<div>Xác nhận xóa?</div>',
            html: '<div>Bạn có chắc chắn muốn đơn hàng này không?</div>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#0d6efd',
            confirmButtonText: '<div>Xóa</div>',
            cancelButtonText: '<div>Hủy</div>',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_donhang.php',
                    type: 'GET',
                    data: {id: id},
                    success: function(response) {
                        if(response.trim() === 'success') {
                            Swal.fire({
                                title: '<div>Đã xóa!</div>',
                                html: '<div>Đơn hàng đã được xóa thành công.</div>',
                                icon: 'success',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: '<div">Lỗi!</div>',
                                html: '<div>Đã xảy ra lỗi khi xóa đơn hàng.</div>',
                                icon: 'error',
                            });
                        }
                    }
                });
            }
        });
        return false;
    }
    </script>


  


    
    
</body>

</html>
