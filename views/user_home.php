<?php
global $user;
echo view('user_home_nav.php');

$restaurants = Restaurants::getAll();
if(empty($restaurants)){ ?>
    <div class="alert alert-info" role="alert">No Restaurants Suggested. <a href="<?php echo BASE_URL ?>/suggest">Got any ideas?</a></div>
    <?php
}
else{
    foreach($restaurants as $restaurant){ ?>
        <div class="rest-grid">
            <a href="<?php echo BASE_URL ?>/restaurants/<?php echo RESTAURANT::url($restaurant->name()) ?>">
                <img class="thumbnail" src="<?php echo BASE_URL ?>/images/rest-thumb.jpg" />
            </a>
            <div class="rest-label">
                <span class="rest-name">
                    <a href="<?php echo BASE_URL ?>/restaurants/<?php echo RESTAURANT::url($restaurant->name()) ?>">
                        <?php echo $restaurant->name() ?>
                    </a>
                </span>
                <span class="rest-suggestor">Suggested by: <?php echo $restaurant->suggestor() ?></span>
                <span class="rest-rating"><?php echo $restaurant->rating() ?></span>
                <div class="thumbs-box">
                <?php
                    $vote = $user->getUserVoteForRestaurant($restaurant->id());
                    if($vote === null){ ?>
                            <span class="thumb pointer thumb-bad glyphicon glyphicon-thumbs-down" data-restid="<?php echo $restaurant->id() ?>" data-userid="<?php echo $user->userID() ?>"></span>
                            <span class="thumb pointer thumb-good glyphicon glyphicon-thumbs-up" data-restid="<?php echo $restaurant->id() ?>" data-userid="<?php echo $user->userID() ?>"></span>
                        <?php
                    }
                    else{
                        if($vote){ ?>
                            <span class="thumb bg-success thumb-good glyphicon glyphicon-thumbs-up" data-restid="<?php echo $restaurant->id() ?>" data-userid="<?php echo $user->userID() ?>"></span>
                            <?php                        
                        }
                        else{ ?>
                            <span class="thumb bg-danger thumb-bad glyphicon glyphicon-thumbs-down" data-restid="<?php echo $restaurant->id() ?>" data-userid="<?php echo $user->userID() ?>"></span>
                            <?php
                        }                    
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>