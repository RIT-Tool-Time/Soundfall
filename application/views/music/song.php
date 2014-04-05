<div class="col-md-6">
    <h3 class="title-red"><?php echo $song->name; ?></h3>
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
    <div class="stats-box col-sm-6">
        <h3 class="stats-number">93</h3>
        <h4 class="stats-desc"><?php echo lang('music_shares'); ?></h4>
    </div>
</div>

<!-- wave with tags or other stuff -->
<div class="clearfix"></div>
<div id="waves">
    <audio src="" controls preload="auto">
        
    </audio>
</div>