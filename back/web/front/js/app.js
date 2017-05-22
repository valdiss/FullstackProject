var shoppingList = angular.module('shoppingList', []);

shoppingList.controller('shoppingListController', function shoppingListController($scope, $http) {

  //configuration des parametres la methode get
  var get = {
    method: 'GET',
    url: '/myshoppinglist/1/1/show'
  };
  //configuration des parametres la methode post

  posturl = '/myshoppinglist';

  $scope.list=[];

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
    $http.post('/myshoppinglist/1/1/new', newItem).then(function successCallback(response) {
      console.log('post success, here\'s the response: ');
      console.log(response.data);
    }, function errorCallback(response) {
      console.log('error on the post method');
    })
  };

  $scope.buy = function(item) {
    item.bought = true;
    newChange = JSON.stringify(item);
    $http.post(posturl, newChange).then(function successCallback(response) {
      console.log('change success, here\'s the response: ');
      console.log(response.data);
    }, function errorCallback(response) {
      console.log('error on the post method');
    })
  };

  //fonction de raffraichissement afin d'actualiser
  $scope.getList = function() {
    $http(get).then(function successCallback(response) {
      // this callback will be called asynchronously
      // when the response is available
      $scope.list = response.data;
      console.log('getList success');
    }, function errorCallback(response) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    })
  };

  //Appel de getList au chargement du DOM
  angular.element(document).ready(function() {
    $http(get).then(function successCallback(response) {
      // this callback will be called asynchronously
      // when the response is available

      console.log(response);

      $scope.list = response.data;
      console.log($scope.list);
    }, function errorCallback(response) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    })
  })

});
