$(function(){
    $(".thumbs-box .thumb").click(function(){
        var restid, custid, vote = 0;
        if($(this).hasClass('thumb-bad')){
            $(this).addClass('bg-danger');
            $(this).siblings('.thumb-good').hide();
            vote = '0';
        }
        else if($(this).hasClass('thumb-good')){
            $(this).addClass('bg-success');
            $(this).siblings('.thumb-bad').hide();
            vote = '1';
        }
        restid = $(this).attr('data-restid');
        userid = $(this).attr('data-userid');
        var ratingsBox = $(this).parent().siblings('.rest-rating');
        $.ajax({
            url: '/psw-demo/ajax/restaurant-vote',
            data: {
                'restaurant-id': restid, 
                'user-id': userid,
                'vote': vote
            },
            success: function(data, status, xhr){
                if(data['total'] > 0){
                    var positive = 100 * (data['up'] / data['total']).toFixed(2);
                    ratingsBox.html(data['total'] +' ratings, '+positive+'% positive');
                }
            }
        });
    });
    
    $("#restaurantSuggestForm").submit(function(){
        if($("#restaurantSuggestName").val() == ''){
            alert('Please enter a name');
            $("#restaurantSuggestName").focus();
            $("#restaurantSuggestName").closest('.form-group').addClass('has-error');
            return false;
        }
        else{
            $("#restaurantSuggestName").closest('.form-group').removeClass('has-error');
        }
        if($("#restaurantSuggestAddr").val() == ''){
            alert('Please enter an address');
            $("#restaurantSuggestAddr").focus();
            $("#restaurantSuggestAddr").closest('.form-group').addClass('has-error');
            return false;
        }
        else{
            $("#restaurantSuggestAddr").closest('.form-group').removeClass('has-error');
        }
        return true;
    });
});