angular.module('UserApp', []).controller('ctrl', function($scope,$http) {

    $scope.inputform = false;

    $http.get("/api/users/get.php")
    .then(function (response) {$scope.users = response.data;});

    $scope.update = function(index){
        $scope.user = $scope.users[index];
        $scope.users[index].edit = false;
        var requestdata = "user_id="+$scope.user.user_id+"&user_password="+$scope.user.user_password+"&user_name="+$scope.user.user_name+"&user_type="+$scope.user.user_type.substring(0,1);

        $.post('/api/users/update.php', requestdata ,
        function(data, status){
            showToast(data);
        });
    };

    var del_id;
    $scope.selected = function(index){
        del_id = $scope.users[index].user_id;
    }
    $scope.delete =function(){
        $http.get("/api/users/delete.php?id="+del_id)
        .then(function (response) {showToast(response.data);});
    }
    
    $scope.openeditor = function(index){
        $scope.user = $scope.users[index];
        $scope.user.index = index;
        $scope.user.edit = true;
    };
});

function mysubmit(){
    $.post('/api/users/insert.php', $('#form1').serialize() ,
        function(data, status){
            //console.log(data);
            showToast(data);
    });
}

function showToast(data){
    var msg = data.split(":");

    var toastbody = document.getElementById("toast_content");
    toastbody.innerHTML = msg[1];
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl)
    });
    toastList.forEach(toast => toast.show());

    if(msg[0] != "200"){
        $("#toast_bg").removeClass("bg-success");
        $("#toast_bg").addClass("bg-danger");
        setTimeout(function(){location.reload();}, 5000);
    }
    else{
        $("#toast_bg").removeClass("bg-danger");
        $("#toast_bg").addClass("bg-success");
    }
}