<!DOCTYPE html>
<html>
<head>
  <title>Administrator Login Page</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" />
  <link href="assets/css/login-css.css" rel="stylesheet">
  <script type="text/javascript" src = "assets/js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="assets/js/validation.min.js"></script>
  <script type="text/javascript" src="assets/js/login.js"></script>

</head>
<body>
  <!--Inspired by http://tutorialzine.com/2012/02/apple-like-login-form/ - Apple-like Login Form with CSS 3D Transforms -->

  <div class="container">
    <div class="row">
      <div class="container" id="formContainer">

        <form class="form-signin" id="login-form" role="form"  method="POST">
        <h3 class="form-signin-heading">&nbsp;</h3>
          <input type="text" class="form-control" name="login_username" id="login_username" oninvalid="setCustomValidity('username tidak boleh kosong')" onchange="try{setCustomValidity('')}catch(e){}" placeholder="username" required autofocus>

          <input type="password" class="form-control" name="login_password" id="login_password" oninvalid="setCustomValidity('password tidak boleh kosong')" onchange="try{setCustomValidity('')}catch(e){}"  placeholder="password" required>

          <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_button">Log in</button>
          <div id="error"></div>
        </form>

      </div> <!-- /container -->
    </div>
  </div>

</body>
</html>