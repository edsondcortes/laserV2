$(document).ready(function(){

    $("#IndexOrcamento").validate({
        rules:{
            orcamento: {
                required: true
            }
        },
        errorElement: 'div'
    });
});
