function updateBill(id){
    var amt = $('#amt').val();
    var scount = document.getElementById('scount');
    var amount = document.getElementById('amount');
    var seatids = document.getElementById('seatids');

    var value = $('#'+id).is(":checked");

    if(value){
        scount.value++;
        seatids.value += ":"+id;
    }
    else{
        scount.value--;
        seatids.value = seatids.value.replace(":"+id,"");
    }
    amount.value = scount.value * amt;
}