angular.module('App', []).controller('Ctrl', function($scope,$http) {

    $scope.editor = false;

    $scope.openeditor = function(index)
    {
        $scope.vars[index].edit = true;
    };
    $scope.closeeditor = function(index)
    {
        $scope.vars[index].edit = false;
    };
    
    var q = window.location.search;
    var urlParams = new URLSearchParams(q);
    var id = urlParams.get("movie_id");

    $http.get("/api/movies/variations/getall.php?movie_id="+id)
    .then(function (response) {$scope.vars = response.data;});
});