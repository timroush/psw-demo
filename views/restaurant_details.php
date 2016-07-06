<?php
global $restaurant;
?>
<div class="pull-left col-md-6">
    <img src="/images/rest.jpg" />
</div>
<div class="pull-right col-md-6">
    <h1><?php echo $restaurant->name() ?></h1>
    <h4>Added <?php echo date('m/d/Y', strtotime($restaurant->modified())) ?> by <?php echo $restaurant->suggestor() ?></h4>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $restaurant->ratingScore() ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $restaurant->ratingScore() ?>%;">
            <?php echo $restaurant->ratingScore() ?>% Rating
        </div>
    </div>
    <?php
    $votes = $restaurant->getVotesBreakdown();
    if($votes){ ?>
        <ul class="list-group">
        <?php
        foreach($votes as $vote){ ?>
            <li class="list-group-item"><?php echo $vote['name'] ?> voted
            <?php
            if($vote['vote'] == '1'){ ?>
                <span class="glyphicon glyphicon-thumbs-up"></span>
                <?php
            }
            else{ ?>
                <span class="glyphicon glyphicon-thumbs-down"></span>
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
