<?php
include('./constant/layout/head.php');
include('./constant/connect.php');
session_start();

if (isset($_SESSION['userId'])) {
  // Si ya inició sesión, redirige
  // header('location:'.$store_url.'login.php');
}

$errors = array();

if ($_POST) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    if ($email == "") {
      $errors[] = "Email es requerido";
    }
    if ($password == "") {
      $errors[] = "Contraseña es requerida";
    }
  } else {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $connect->query($sql);

    if ($result->num_rows == 1) {
      $password = md5($password);
      $mainSql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
      $mainResult = $connect->query($mainSql);

      if ($mainResult->num_rows == 1) {
        $value = $mainResult->fetch_assoc();
        $user_id = $value['user_id'];

        $_SESSION['userId'] = $user_id;
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">Login</h3>
            <p>Acceso Exitoso</p>
            <p><?php echo "<script>setTimeout(\"location.href = 'dashboard.php';\",1500);</script>"; ?></p>
          </div>
        </div>
        <?php
      } else {
        ?>
        <div class="popup popup--icon -error js_error-popup popup--visible">
          <div class="popup__background"></div>
          <div class="popup__content">
            <h3 class="popup__content__title">Error</h3>
            <p>Correo o Contraseña Incorrectos</p>
            <p><a href="login.php"><button class="button button--error">Cerrar</button></a></p>
          </div>
        </div>
        <?php
      }
    } else {
      ?>
      <div class="popup popup--icon -error js_error-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
          <h3 class="popup__content__title">Error</h3>
          <p>Correo no existe</p>
          <p><a href="login.php"><button class="button button--error">Cerrar</button></a></p>
        </div>
      </div>
      <?php
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/popup_style.css">
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Open Sans", sans-serif;
      font-size: 16px;
      margin: 0;
      padding: 0;
      background: url('assets/uploadImage/Logo/banner3.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-form {
      background: rgba(255, 255, 255, 0.52);
      padding: 90px;
      border-radius: 10px;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.68);
      width: 100%;
      max-width: 500px;
    }

    .login-form img {
      display: block;
      width: 100px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      color: white;
      font-weight: 600;
    }

    input.form-control {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: none;
      margin-top: 5px;
    }

    .btn-login {
      width: 100%;
      background-color: #102b49;
      color: white;
      border: none;
      padding: 15px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
    }

    .login-form label {
    color: #000000;
    text-transform: capitalize;
    font-weight: 500;
  }
    .btn-login:hover {
      background-color: #1a3b6b;
      color: white;
    }

    .popup__content__title {
      margin: 0;
    }

    .button--error {
      background: #c0392b;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
    }

    .button--error:hover {
      background: #e74c3c;
    }
  </style>
</head>
<body>

  <div class="login-form">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <center><img src="./assets/uploadImage/Logo/logo.png" alt="Logo"></center>
      <div class="form-group">
        <label for="email">Correo</label>
        <input type="text" name="email" id="email" class="form-control" placeholder="correo" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="contraseña" required>
      </div>
      <button type="submit" name="login" class="btn-login">Ingresar</button>
    </form>
  </div>


<script src="./assets/js/lib/jquery/jquery.min.js"></script>

<script src="./assets/js/lib/bootstrap/js/popper.min.js"></script>
<script src="./assets/js/lib/bootstrap/js/bootstrap.min.js"></script>

<script src="./assets/js/jquery.slimscroll.js"></script>

<script src="./assets/js/sidebarmenu.js"></script>

<script src="./assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

<script src="./assets/js/custom.min.js"></script>
<footer class="bg-white text-dark text-center text-lg-start border-top fixed-bottom">
</div>
</body>

</html>