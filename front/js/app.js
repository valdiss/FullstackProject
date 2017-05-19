var shoppingList = angular.module('shoppingList', []);

shoppingList.controller('shoppingListController', function shoppingListController($scope, $http) {

  //configuration des parametres la methode get
  var get = {
    method: 'GET',
    url: '/someUrl'
  };
  //configuration des parametres la methode post

  $scope.list = [
    {
      article: "Book",
      quantity: 55,
      bought: false,
      action: "create"
    }, {
      article: "Book",
      quantity: 55,
      bought: false,
      action: "create"
    }, {
      article: "Book",
      quantity: 55,
      bought: false,
      action: "create"
    }, {
      article: "Book",
      quantity: 55,
      bought: false,
      action: "create"
    }
  ];

  //fonction de reset des champs du formulaire
  $scope.reset = function() {

    $scope.newItem.article = '';
    $scope.newItem.quantity = '';
  };

  //fonction qui s'applique a la validation du formulaire
  $scope.create = function() {
    //récupération des valeurs mises dans le formulaire, et transformation sous forme de JSON
    newItem = JSON.stringify({article: $scope.newItem.article, quantity: $scope.newItem.quantity, bought: false, action: 'create', category: $scope.newItem.category});
    //reset des valeurs dans les champs du formulaire
    $scope.newItem.article = '';
    $scope.newItem.quantity = '';
    //post de l'item créé à la base de donnée
    $http.post(posturl, newItem).then(function successCallback(response) {
      console.log('post success : ' + response);
    }, function errorCallback(response) {
      console.log('error on the post method');
    })
  };

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
