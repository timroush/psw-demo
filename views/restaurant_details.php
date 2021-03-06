<?php
global $restaurant, $user;
$votes = $restaurant->getVotesBreakdown();
?>
<div class="pull-left col-md-6">
    <img src="<?php echo BASE_URL ?>/images/rest.jpg" />
    <?php
    $score = 0;
    $votesCounted = 0;
    if(!empty($votes)){ ?>
        <div class="text-center"><strong>Ratings Trend</strong></div>
        <div id="rest-vote-trend-graph-box">
            <div id="rest-vote-trend-graph-box-inner">
                <?php
                $width = round(70 / count($votes));
                $left = 1;
                foreach(array_reverse($votes) as $vote){
                    $votesCounted++;
                    $score += $vote['vote'];
                    $currentScore = number_format(($score / $votesCounted), 2) * 100;
                    ?>
                    <span class="rest-vote-bar" style="height:<?php echo $currentScore ?>%; left: <?php echo $left; ?>%; width: <?php echo $width ?>%">
                        <?php echo $currentScore ?>%
                    </span>
                    <?php
                    $left += (100 / count($votes)) - 1;
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="pull-right col-md-6">
    <h1><?php echo $restaurant->name() ?></h1>
    <h4>Added <?php echo date('m/d/Y', strtotime($restaurant->modified())) ?> by <?php echo $restaurant->suggestor() ?></h4>
    <iframe
      width="600"
      height="250"
      frameborder="0" style="border:0; margin: 25px 0px"
      src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBBWt07qo3fiL09SP_V8Y6UXItJu5c4B1g&q=<?php echo urlencode($restaurant->address()) ?>" allowfullscreen>
    </iframe>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $restaurant->ratingScore() ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $restaurant->ratingScore() ?>%;min-width:20px">
            <?php echo $restaurant->ratingScore() ?>% Rating
        </div>
    </div>
    <hr/>
    <div id="restaurant-comments">
        <h4 class="pointer" id="togglecomments"><span class="glyphicon glyphicon-minus"></span> Comments</h4>        
        <div id="add-a-comment">
            <form id="add-a-comment-form" data-restid="<?php echo $restaurant->id() ?>" data-userid="<?php echo $user->userID() ?>">
                <textarea id="new-comment-text" class="form-control" rows="3"  placeholder="Add a Comment"></textarea>
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </form>
        </div>
        <div id="current-comments">
            <?php
            $comments = $restaurant->loadComments();
            foreach($comments as $comment){
                ?>
                <div class="comment">
                    <span class="comment-date"><?php echo date('m/d/Y g:i:s A', strtotime($comment['date'])) ?></span>
                    <span class="comment-user"><?php echo $comment['name'] ?> said:</span>
                    <p class="comment-text"><?php echo $comment['comment'] ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    if($votes){ ?>
        <hr/>
        <ul class="list-group rest-vote-history-list">
        <?php
        foreach($votes as $vote){ ?>
            <li class="list-group-item"><?php echo $vote['name'] ?> voted
            <?php
            if($vote['vote'] == '1'){ ?>
                <span class="glyphicon bg-success glyphicon-thumbs-up"></span>
                <?php
            }
            else{ ?>
                <span class="glyphicon bg-danger glyphicon-thumbs-down"></span>
                <?php
            }
            ?>
            on <?php echo date('m/d/Y', strtotime($vote['date_added'])) ?>
            </li>
            <?php
        } ?>
        </ul>
        <?php
    }
    ?>
</div>
