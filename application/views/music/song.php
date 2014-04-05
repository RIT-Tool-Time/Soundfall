<div class="col-md-6">
    <h3 class="title-red"><?php echo $song->name; ?></h3>
    <?php if($song->owner != NULL): ?>
    <div class="authors">
        <?php echo anchor('artist/'.$song->owner, $owner->username); ?><br />
        <?php if($song->owner2 != NULL){ echo anchor('artist/'.$song->owner2), $owner2->username; } ?>
    </div>
    <?php endif; ?>
    <p><?php echo $song->description; ?></p>
</div>
<div class="col-md-6">
    <div class="stats-box col-sm-6">
        <h3 class="stats-number"><?php echo $song->likes; ?></h3>
        <h4 class="stats-desc"><?php echo lang('music_likes'); ?></h4>
    </div>
    <div class="stats-box col-sm-6">
        <h3 class="stats-number"><?php echo $song->downloads; ?></h3>
        <h4 class="stats-desc"><?php echo lang('music_downloads'); ?></h4>
    </div>
</div>

<!-- wave with tags or other stuff -->
<div class="clearfix"></div>
<div id="waves">
    <audio src="music/<?php echo $song->file; ?>" controls preload="auto">
        
    </audio>
</div>
<!-- download file -->
<div>
    <a href="song/download/<?php echo $song->id; ?>" class="btn btn-primary btn-lg btn-block"><?php echo lang('music_download'); ?></a>
</div>