$(function(){
    $(".thumbs-box .thumb").click(function(){
        if($(this).hasClass('thumb-bad')){
            $(this).addClass('bg-danger');
            $(this).siblings('.thumb-good').hide();
        }
        else if($(this).hasClass('thumb-good')){
            $(this).addClass('bg-success');
            $(this).siblings('.thumb-bad').hide();
        }
    });
});