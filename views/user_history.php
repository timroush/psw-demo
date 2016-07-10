<?php
global $votes, $user;
?>
<h1 class="text-center">Vote history for <?php echo $user->userName() ?></h1>
<?php
if(empty($votes)){ ?>
    <div class="well">No votes yet. <a href="<?php echo BASE_URL ?>/suggest">Try suggesting a restaurant?</a></div>
    <?php
}
else{
    foreach($votes as $vote){ ?>
        <div class="vote-history-entry">
            <a href="<?php echo BASE_URL ?>/restaurants/<?php echo RESTAURANT::url($vote['restaurant']) ?>">
                <img src="<?php echo BASE_URL ?>/images/rest.jpg" class="rest-picture" />
                <div class="vote-details">
                    <span class="rest-name"><strong><?php echo $vote['restaurant'] ?></strong></span>
                    <span class="vote-date">Voted on <?php echo $vote['date'] ?></span>
                    <?php
                    if($vote['vote']){ ?>
                        <span class="vote-value glyphicon bg-success glyphicon-thumbs-up"></span>
                        <?php
                    }
                    else{ ?>
                        <span class="vote-value glyphicon bg-danger glyphicon-thumbs-down"></span>
                        <?php
                    }
                    ?>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php    
    }
}
?>