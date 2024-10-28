$(document).ready(function(){

    $("#hotelCreate").validate({
        rules:{
            hotel: {
                required: true
            }
        },
        errorElement: 'div'
    });
});
