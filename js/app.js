var shoppingList = angular.module('shoppingList', []);

shoppingList.controller('shoppingListController', function shoppingListController($scope, $http) {

  //configuration des parametres la methode get
  var get = {
    method: 'GET',
    url: '/someUrl'
  };
  //configuration des parametres la methode post
  var post = {
    method: 'POST',
    url: '/someUrl',
    data: {}
  }
//fonction de reset des champs du formulaire
  $scope.reset = function() {
    $scope.newItem.article = '';
    $scope.newItem.quantity = '';
  }



//fonction de raffraichissement afin d'actualiser
  $scope.getList = function() {
    console.log('getList called');
    $http(get).then(function successCallback(response) {
      // this callback will be called asynchronously
      // when the response is available
      $scope.list = response;
    }, function errorCallback(response) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    })
  };

  //Appel de getList au chargement du DOM
  angular.element(document).ready(function() {
    console.log('getList called');
    $http(get).then(function successCallback(response) {
      // this callback will be called asynchronously
      // when the response is available
      $scope.list = response;
    }, function errorCallback(response) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    })
  })

});
