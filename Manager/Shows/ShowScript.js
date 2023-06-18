angular.module('App', []).controller('Ctrl', function($scope,$http) {

    $scope.inputform = false;

    $scope.loadvars = function(){
        var movie_id = $('#movie_id').find(":selected").val();

        $http.get("/api/movies/variations/get.php?movie_id="+movie_id)
        .then(function (response) {$scope.vars = response.data;});
    };

    $http.get("/api/auditoriums/get.php")
    .then(function (response) {$scope.audis = response.data;});

    $http.get("/api/movies/get.php")
    .then(function (response) {$scope.movies = response.data;});

});