<!-- the very top - site statistics -->
<div class="col-md-6">
    <h3 class="title-red"><?php echo lang('about_soundfall_title'); ?></h3>
    <p><?php echo lang('about_sundfall_explain'); ?></p>
</div>
<div class="col-md-6">
    <div class="stats-box">
        <h3 class="stats-number"><?php echo $stats['music_total']; ?></h3>
        <h4 class="stats-desc"><?php echo lang('music_songs'); ?></h4>
    </div>
</div>

<!-- wave with tags or other stuff -->
<div class="clearfix"></div>
<div id="waves">
    
</div>

<!-- listing of songs -->
<div id="song-listing">
    <?php
    if($stats['music_total'] > 0):
    foreach($songs as $song):
    ?>
    <div class="song-list">
        <div class="col-md-2">
            <!-- song image -->
	    <?php if($song->picture != NULL): ?>
            <img src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <!-- song name and creators -->
            <h4 class=""><?php echo anchor('song/'.$song->id, $song->name); ?></h4>
            <!-- tags -->
            <div class="song-tags">
            </div>
        </div>
        <div class="col-md-6">
            <!-- play -->
            <div class="play-song">
                <audio src="music/<?php echo $song->file; ?>" controls preload="metadata">
                    
                </audio>
            </div>
            <!-- download, like, share buttons -->
        </div>
    </div>
    <?php
    endforeach;
    endif;
    ?>
</div>