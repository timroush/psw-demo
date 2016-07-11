$(function(){
    $("#login-form").submit(function(){
        if($("#username").val().trim() == ''){
            alert('Please enter a value');
            $("#username").val('');
            $("#username").focus();
            return false;
        }
    });
    
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
        if($("#restaurantSuggestName").val().trim() == ''){
            alert('Please enter a name');
            $("#restaurantSuggestName").val('');
            $("#restaurantSuggestName").focus();
            $("#restaurantSuggestName").closest('.form-group').addClass('has-error');
            return false;
        }
        else{
            $("#restaurantSuggestName").closest('.form-group').removeClass('has-error');
        }
        if($("#restaurantSuggestAddr").val().trim() == ''){
            alert('Please enter an address');
            $("#restaurantSuggestAddr").val('');
            $("#restaurantSuggestAddr").focus();
            $("#restaurantSuggestAddr").closest('.form-group').addClass('has-error');
            return false;
        }
        else{
            $("#restaurantSuggestAddr").closest('.form-group').removeClass('has-error');
        }
        return true;
    });
    
    $("#add-a-comment-form").submit(function(){
        var comment = $("#new-comment-text").val();
        restid = $(this).attr('data-restid');
        userid = $(this).attr('data-userid');
        if(comment == ''){
            return;
        }
        $.ajax({
            url: '/psw-demo/ajax/restaurant-comment',
            data: {
                'restaurant-id': restid, 
                'user-id': userid,
                'comment': comment
            },
            method: "POST",
            success: function(data, status, xhr){
                $("#current-comments").prepend('<div class="comment"><span class="comment-date">'+data['date'] + '</span><span class="comment-user">'+data['user']+' said:</span><p class="comment-text"> ' + data['comment'] + '</p></div>');
            }
        });
        return false;
    });
    
    $("#togglecomments").click(function(){
        var icon = $(this).children('.glyphicon');
        if(icon.hasClass('glyphicon-minus')){
            icon.removeClass('glyphicon-minus');
            icon.addClass('glyphicon-plus');
        }
        else if(icon.hasClass('glyphicon-plus')){
            icon.removeClass('glyphicon-plus');
            icon.addClass('glyphicon-minus');
        }
        $("#current-comments").slideToggle();
    });
});