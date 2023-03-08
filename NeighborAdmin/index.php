<?php





?>
<html ng-app="neighbor">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Inicio de Sesion para la aplicacion de AdminEnvios">
    <meta name="author" content="Victor Daniel Ortega Cruz">
    <meta name="generator" content="danweb 0.9">
    <title>.:NeighborAdmin:.</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <link href="css/signin.css" rel="stylesheet" type="text/css" />
    <script src="js/angular.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/neighbor.js"></script>

  </head>
  <body class="text-center" ng-controller="InicioSesionController" ng-init="inicializaLogin()">
    <main class="form-signin w-100 m-auto">
      <form>
        <img class="mb-4" src="/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Inicio de Sesion</h1>

        <div class="form-floating">
          <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" ng-model="paramsLogin.login">
          <label for="floatingInput">Email / Usuario / Telefono </label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password" ng-model="paramsLogin.passwd">
          <label for="floatingPassword">Contrasena</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="button" ng-click="inicioSesion()">Ingresar <i class="bi bi-door-open"></i></button>
        <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
      </form>
    </main>

  </body>
</html>
