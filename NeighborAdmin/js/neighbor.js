var neighbor;

(function() {
  neighbor = angular.module('neighbor', ['chieffancypants.loadingBar'])
  .config(function (cfpLoadingBarProvider) {
            cfpLoadingBarProvider.includeSpinner = true;
        });

  var datosUsuario = {};

  neighbor.controller('InicioSesionController', function ($scope, $http, $window, $location) {

/*
    $scope.inicializaLogin = function(){
      $scope.paramsLogin = {
        login: 'daniel'
        ,passwd: ''
      };
    };

    $scope.inicioSesion = function(){
      alert($scope.paramsLogin);
    };
*/

    $scope.calTamVen = function () {
      tamanio.tamx = screen.width;
      tamanio.tamy = screen.height;
      tamanio.tamx = parseInt((tamanio.tamx * .8), 10);
      tamanio.tamy = parseInt((tamanio.tamy * .8), 10);
    };

  });

  neighbor.controller('MenuPrincipalController', function ($scope, $http, $window, $location) {

  });


})();
