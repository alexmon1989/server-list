<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Список серверів :: Авторизація</title>

    <link rel="stylesheet" href="<?php echo asset('packages/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/signin.css'); ?>">

    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
        <?php if (Session::get('message')): ?>        
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Ошибка:</span>
                <?php echo Session::get('message'); ?>
            </div>        
        <?php endif; ?>

        <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Авторизація</h2>
        <label for="login" class="sr-only">Email або логін</label>
        <input type="text" id="login" name="login" class="form-control" placeholder="Email або логін" required autofocus>
        <label for="password" class="sr-only">Пароль</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Пароль" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me" name="remember"> Запам'ятати мене
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Вхід</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>

