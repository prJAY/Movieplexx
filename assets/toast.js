var a = document.getElementById("msg");
if(a.value != "")
{
    showToast(a.value);
}

function showToast(data){
    var msg = data.split(":");
    var displaymsg = msg[1];
    
    if(msg[0] != "200"){
        $("#toast_bg").removeClass("bg-success");
        $("#toast_bg").addClass("bg-danger");
    }
    else{
        $("#toast_bg").removeClass("bg-danger");
        $("#toast_bg").addClass("bg-success");
    }
    var toastbody = document.getElementById("toast_content");
    toastbody.innerHTML = displaymsg;
    //console.log(displaymsg);
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl)
    });
    toastList.forEach(toast => toast.show());
}