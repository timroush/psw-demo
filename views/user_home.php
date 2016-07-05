<?php
echo view('user_home_nav.php');

$restaurants = Restaurants::getAll();
if(empty($restaurants)){ ?>
    <div class="alert alert-info" role="alert">No Restaurants Suggested. <a href="/suggest">Got any ideas?</a></div>
    <?php
}
else{
    foreach($restaurants as $restaurant){ ?>
        <div class="rest-grid">
            <a href="/restaurants/<?php echo $restaurant->url() ?>">
                <img class="thumbnail" src="/images/rest-thumb.jpg" />
            </a>
            <div class="rest-label">
                <span class="rest-name">
                    <a href="/restaurants/<?php echo $restaurant->url() ?>">
                        <?php echo $restaurant->name() ?>
                    </a>
                </span>
                <span class="rest-suggestor">Suggested by: <?php echo $restaurant->suggestor() ?></span>
                <span class="rest-rating"><?php echo $restaurant->rating() ?></span>
            </div>
        </div>
        <?php
    }
}
?>