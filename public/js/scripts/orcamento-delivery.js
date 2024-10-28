var hotel = $(".hotel");
var hotelInfo = $(".hotelInfo");

var local = $(".local");
var localInfo = $(".localInfo");

var season = $(".season");
var seasonInfo = $(".seasonInfo");

var despachar = $(".despachar");
var despacharInfo = $(".despacharInfo");

var deliverySelect = $('.deliverySelect');
var showDelivery = $('.showDelivery');

var deliveryOnTime = $(".deliveryOnTime");
var deliveryOnTimeInfo = $(".deliveryOnTimeInfo");

deliverySelect.click(function(){
    if($(this).is(":checked")){
        $(this).closest('#stop').find('.showDelivery').hide();
        $(this).closest('#stop').find('.hotelInfo').hide();
        $(this).closest('#stop').find('.despacharInfo').hide();
        $(this).closest('#stop').find('.localInfo').hide();
        $(this).closest('#stop').find('.seasonInfo').hide();
        $(this).closest('#stop').find('.deliveryOnTimeInfo').hide();
    }else{
        console.log($(this).closest('#stop').find('.showDelivery'));
        $(this).closest('#stop').find('.showDelivery').show();
    }
});

hotel.click(function(){
    if($(this).is(":checked")){
        $(this).closest('#stop').find('.hotelInfo').show();
        $(this).closest('#stop').find('.localInfo').hide();
        $(this).closest('#stop').find('.seasonInfo').hide();
        $(this).closest('#stop').find('.despacharInfo').hide();
        $(this).closest('#stop').find('.deliveryOnTimeInfo').hide();
    }else{
        $(this).closest('#stop').find('.hotelInfo').hide();
    }
});

despachar.click(function(){
    if($(this).is(":checked")){
        $(this).closest('#stop').find('.despacharInfo').show();
        $(this).closest('#stop').find('.hotelInfo').hide();
        $(this).closest('#stop').find('.localInfo').hide();
        $(this).closest('#stop').find('.seasonInfo').hide();
        $(this).closest('#stop').find('.deliveryOnTimeInfo').hide();
    }else{
        $(this).closest('#stop').find('despacharInfo').hide();
    }
});

local.click(function(){
    if($(this).is(":checked")) {
        $(this).closest('#stop').find('.localInfo').show();
        $(this).closest('#stop').find('.seasonInfo').hide();
        $(this).closest('#stop').find('.hotelInfo').hide();
        $(this).closest('#stop').find('.despacharInfo').hide();
        $(this).closest('#stop').find('.deliveryOnTimeInfo').hide();
    } else {
        $(this).closest('#stop').find('.localInfo').hide();
    }
});

season.click(function(){
    if($(this).is(":checked")) {
        $(this).closest('#stop').find('.seasonInfo').show();
        $(this).closest('#stop').find('.hotelInfo').hide();
        $(this).closest('#stop').find('.localInfo').hide();
        $(this).closest('#stop').find('.despacharInfo').hide();
        $(this).closest('#stop').find('.deliveryOnTimeInfo').hide();
    } else {
        $(this).closest('#stop').find('.seasonInfo').hide();
    }
});

deliveryOnTime.click(function(){
    if($(this).is(":checked")) {
        $(this).closest('#stop').find('.deliveryOnTimeInfo').show();
        $(this).closest('#stop').find('.seasonInfo').hide();
        $(this).closest('#stop').find('.hotelInfo').hide();
        $(this).closest('#stop').find('.despacharInfo').hide();
        $(this).closest('#stop').find('.localInfo').hide();
    } else {
        $(this).closest('#stop').find('.deliveryOnTimeInfo').hide();
    }
});
