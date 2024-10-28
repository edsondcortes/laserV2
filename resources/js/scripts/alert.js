$(document).ready(function(){

    $("#alert").validate({
        rules:{
            hotel: {
                required: true
            }
        },
        errorElement: 'div'
    });
});
