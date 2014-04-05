<div class="col-md-6">
    <h3 class="title-red"><?php echo $artist->username; ?></h3>
    <p>Some random text to fill up space, that is better than lorem ipsum. Some random text to fill up space, that is better than lorem ipsum. Some random text to fill up space, that is better than lorem ipsum. Some random text to fill up space, that is better than lorem ipsum. Some random text to fill up space, that is better than lorem ipsum. Some random text to fill up space, that is better than lorem ipsum. Some random text to fill up space, that is better than lorem ipsum.</p>
</div>
<div class="col-md-6">
    <div class="stats-box col-sm-6">
        <h3 class="stats-number"><?php echo $songs_count; ?></h3>
        <h4 class="stats-desc"><?php echo lang('music_songs'); ?></h4>
    </div>
    <div class="stats-box col-sm-6">
        <h3 class="stats-number">1428</h3>
        <h4 class="stats-desc"><?php echo lang('music_likes'); ?></h4>
    </div>
    <div class="stats-box col-sm-6">
        <h3 class="stats-number">357</h3>
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
    
</div>

<!-- listing of songs -->
<div id="song-listing">
    <?php
    if($songs_count > 0):
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
                <!--<span class="label label-success">PLAYFUL</span>
				<div id="tags"></div>
                <span class="labellabel-success">FUNNY</span>
                <span class="label label-success">BRIGHT</span>
                <span class="label label-success">CUTE</span>-->
				<span class="labellabel-success">FUNNY</span>
				<img src="/resource/img/tag_inactive.png" alt="alt"/>
				<img src="/resource/img/tag_inactive.png" alt="alt"/>
				<img src="/resource/img/tag_inactive.png" alt="alt"/>
				<img src="/resource/img/tag_inactive.png" alt="alt"/>
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