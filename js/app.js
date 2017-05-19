var shoppingList = angular.module('ShoppingList', []);
shoppingList.controller('shoppingListController', function shoppingListController($scope) {

  var getList = {
    method: 'GET',
    url: '/someUrl'
  };

  var postList = {
    method : 'POST',
    url: '/someUrl',
    data:{}
  }

  $http(getList).then(function successCallback(response) {
    // this callback will be called asynchronously
    // when the response is available
    $scope.list = response;
  }, function errorCallback(response) {
    // called asynchronously if an error occurs
    // or server returns response with an error status.
  });

});
