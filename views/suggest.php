<?php
global $added;

echo view('user_home_nav.php');

if(isset($added) && ($added !== null)){
    if($added === true){?>
        <div class="alert alert-success" role="alert">Successfully Added!</div>
    <?php
    }
    else{ ?>
        <div class="alert alert-warning" role="alert"><?php echo $added ?></div>
        <?php
    }
}
?>
<form method="POST" id="restaurantSuggestForm">
    <div class="form-group">
        <input id="restaurantSuggestName" type="text" class="form-control" name="name" placeholder="What's the name of the restaurant?">
    </div>
    <div class="form-group">
        <input id="restaurantSuggestAddr" type="text" class="form-control" name="address" placeholder="Restaurant Address">
    </div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>