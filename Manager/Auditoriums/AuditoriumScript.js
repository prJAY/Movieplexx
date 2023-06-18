angular.module('App', []).controller('Ctrl', function($scope,$http) {

    $scope.inputform = false;

    $http.get("/api/auditoriums/get.php")
    .then(function (response) {$scope.audis = response.data;});

});