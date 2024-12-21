<head>
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

        .forgot-password-form {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 2.5rem;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border: none !important;
        }

        .forgot-password-form h4 {
            color: #333;
            font-size: 24px;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .form-label {
            color: #555;
            font-weight: 500;
            margin-bottom: 0.5rem;
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

        .has-error {
            color: #ff3333;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .btn-primary {
            background-color: #ff3333;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            color: #ffffff;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #e60000;
            transform: translateY(-1px);
        }

        @media (max-width: 576px) {
            .forgot-password-form {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .forgot-password-form h4 {
                font-size: 20px;
            }
        }
    </style>
</head>

<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'connect_db.php';
$loi = [];
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    if (empty($email)) {
        $loi['email'] = "Bạn chưa nhập email";
    }
    if (empty($loi)) {
        $sql = mysqli_query($con, "SELECT * FROM `user` WHERE `email` = '$email'");
        // print_r($sql);
        $test = mysqli_num_rows($sql);
        // print_r($test);
        if ($test == 0) {
            $loi['email'] = "Email không tồn tại";
        } else {
            $result = sendnewpd($email);
        }
    }
}
?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>

<?php
function sendnewpd($email)
{
    include  "PHPMailer/src/PHPMailer.php";
    include  "PHPMailer/src/Exception.php";
    include  "PHPMailer/src/OAuth.php";
    include  "PHPMailer/src/POP3.php";
    include  "PHPMailer/src/SMTP.php";
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'huunhandepzai26@gmail.com';
        $mail->Password = 'vsnx pqcx xhrg kooo';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = "UTF-8";
        $mail->setFrom('ComputerStore@gmail.com', 'Computerstore.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Thư gửi lại mật khẩu";
        $mail->Body = "Xin chào,<br><br>
                       Để đặt lại mật khẩu, vui lòng click vào link bên dưới:<br>
                       <a href='http://localhost/doanWeb/kichhoat.php?email=$email'>Đặt lại mật khẩu</a><br><br>
                       Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.";
        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>

<form method="post" class="forgot-password-form">
    <h4 class="mb-4 text-center">QUÊN MẬT KHẨU</h4>
    <div class="mb-3">
        <label for="email" class="form-label">Email của bạn</label>
        <input value="<?php if (isset($email)) echo $email ?>" 
               type="email" 
               class="form-control" 
               id="email" 
               name="email" 
               placeholder="Nhập email của bạn">
        <div class="has-error">
            <span><?php echo (isset($loi['email'])) ? $loi['email'] : '' ?></span>
        </div>
    </div>
    <button type="submit" name="submit" value="submit" class="btn btn-primary">
        Gửi yêu cầu
    </button>
</form>