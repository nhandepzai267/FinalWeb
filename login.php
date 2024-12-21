<link rel="icon" type="logo/png" sizes="32x32" href="logo/logo.png">
<?php
session_start();
?>
<style>
    /* CSS Libraries Used

*Animate.css by Daniel Eden.
*FontAwesome 4.7.0
*Typicons

*/

@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400');

body, html {
  font-family: 'Source Sans Pro', sans-serif;
  background-color: #f8f9fa;
  padding: 0;
  margin: 0;
  height: 100%;
}

#particles-js {
  position: fixed;
  width: 100%;
  height: 100%;
  background-color: #ffffff;
  z-index: -1;
}

.container {
  margin: 0;
  top: 50%;
  left: 50%;
  position: absolute;
  text-align: center;
  transform: translate(-50%, -50%);
  background-color: white;
  border-radius: 15px;
  width: 400px;
  padding: 40px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.box h4 {
  font-family: 'Source Sans Pro', sans-serif;
  color: #333;
  font-size: 24px;
  margin-bottom: 5px;
  font-weight: 600;
}

.box h4 span {
  color: #CF111A;
  font-weight: 600;
}

.box h5 {
  font-family: 'Source Sans Pro', sans-serif;
  font-size: 14px;
  color: #666;
  margin-bottom: 30px;
}

.box input[type = "text"],.box input[type = "password"] {
  display: block;
  margin: 20px auto;
  background: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 12px 15px;
  width: 100%;
  outline: none;
  color: #333;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

.box input[type = "text"]:focus,.box input[type = "password"]:focus {
  border-color: #CF111A;
  box-shadow: 0 0 0 2px rgba(207,17,26,0.1);
}

.btn1 {
  border: none;
  background: #CF111A;
  color: white;
  border-radius: 8px;
  width: 100%;
  padding: 12px;
  font-size: 16px;
  font-weight: 500;
  margin-top: 20px;
  transition: all 0.3s ease;
  cursor: pointer;
}

.btn1:hover {
  background: #e31922;
  transform: translateY(-1px);
  box-shadow: 0 5px 15px rgba(207,17,26,0.2);
}

.forgetpass {
  display: block;
  text-align: right;
  color: #CF111A;
  font-size: 14px;
  margin: 10px 0;
  text-decoration: none;
}

.dnthave {
  display: block;
  color: #666;
  font-size: 14px;
  margin-top: 20px;
  text-decoration: none;
}

.dnthave:hover, .forgetpass:hover {
  color: #e31922;
  text-decoration: none;
}

.error {
  background: #CF111A;
  color: white;
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 14px;
  display: none;
}

/* Responsive design */
@media (max-width: 480px) {
  .container {
    width: 90%;
    padding: 20px;
  }
}
</style>

<body id="particles-js"></body>
<?php

         include './connect_db.php';
         if(isset($_POST['username']))
         {
             $username = $_POST['username'];
             $password = $_POST['password'];
             $sql = "SELECT * FROM `user` WHERE (`username` = '$username' AND `password` =  md5('$password'))";
             $query = mysqli_query($con,$sql);
             $data = mysqli_fetch_assoc($query);
             $checkUser = mysqli_num_rows($query);
            //  echo "<pre>";
            //  print_r($data);
            //  die();
             if($checkUser == 1)
             {
              $_SESSION['user'] = $data;
               header("Location: index.php");

             }

             else
             {
               ?>
              <div id="edit-notify" class="" align="center">
              <h3 style="margin-top: 16px;"><?= "Thông tin đăng nhập không chính xác" ?></h3>
               <?php
             }
         }

        
       ?>
<div class="animated bounceInDown">
  <div class="container">
    <span class="error animated tada" id="msg"></span>
    <form acton="./login.php" name="form1" class="box" onsubmit="return checkStuff()" method="Post" autocomplete="off">
      <h4>Welcome<span> Back</span></h4>
      <h5>Sign in to your account.</h5>
        <input type="text" name="username" placeholder="Username" autocomplete="off">
        <i class="typcn typcn-eye" id="eye"></i>
        <input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">

        <a href="quenmatkhau.php" class="forgetpass">Bạn quên mật khẩu ?</a>
        <input type="submit" value="Sign in" class="btn1">
      </form>
        <a href="register.php" class="dnthave">Click vào đây nếu bạn không có tài khoản</a>
  </div>
</div>

<script>
    var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');

eye.addEventListener('click',togglePass);

function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}

// Form Validation

function checkStuff() {
  var email = document.form1.email;
  var password = document.form1.password;
  var msg = document.getElementById('msg');

  if (email.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your email";
    email.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }

   if (password.value == "") {
    msg.innerHTML = "Please enter your password";
    password.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (!re.test(email.value)) {
    msg.innerHTML = "Please enter a valid email";
    email.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
}

// ParticlesJS

// ParticlesJS Config.
particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 60,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.1,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 6,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.1,
      "width": 2
    },
    "move": {
      "enable": true,
      "speed": 1.5,
      "direction": "top",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": false,
        "mode": "repulse"
      },
      "onclick": {
        "enable": false,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});
</script>