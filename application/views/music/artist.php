<div id="filters" class="col-lg-2">
	<div class="sidebar">
	    <h2 style="font-weight: 500;">Explore</h2>
		<div class="search"> 
			<?php echo form_open('search', array('role' => 'form')); ?>
				<input type="text" id="search" name="search" placeholder="Search">
			<?php echo form_close(); ?>
		</div>
		<div class="col-md-6">
			<div class="song-activity">
		        <span class="glyphicon glyphicon-music"></span>
				<span><?php echo $songs_count . ' ' . lang('music_songs'); ?></span>
			</div>
			<div class="song-activity">
		        <span class="glyphicon glyphicon-thumbs-up"></span>
				<span><?php echo $songs_count . ' ' . lang('music_likes'); ?></span>
			</div>
			<div class="song-activity">
		        <span class="glyphicon glyphicon-save"></span>
				<span><?php echo $songs_count . ' ' . lang('music_downloads'); ?></span>
			</div>
			<div class="song-activity">
		        <span class="glyphicon glyphicon-share-alt"></span>
				<span><?php echo $songs_count . ' ' . lang('music_shares'); ?></span>
			</div>
	    </div>
	</div>
</div>

<!-- listing of songs -->
<div id="song-listing"  class="col-lg-10">
    <?php
    if($songs_count > 0):
    foreach($songs as $song):
    ?>
    <div class="song-list">
    	<div class="col-md-2 visible-lg">
            <!-- song image -->
			<?php if($song->picture != NULL): ?>
				<img class="album-art hide-mobile" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
			<?php else: ?>
			<?php echo '<img class="album-art" src="/resource/img/Background_Triangles_Blue.png" />'; ?>
		<?php endif; ?>
        </div>        
        <div class="col-md-10">
      		<div class="col-md-6">
				
			<!-- album art -->
			<?php if($song->picture != NULL): ?>
				<img class="visible-xs" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
		        <?php endif; ?>
		        <div class="song-image">
				<?php echo '<img class="album-art visible-md visible-sm visible-xs" src="/resource/img/Background_Triangles_Blue.png" />'; ?>
		        </div>

				<!-- creators -->
				<div class="creators">
					<?php if($song->owner != NULL): ?>
						<?php echo anchor('artist/'.$song->owner, get_username($song->owner)); ?>
					<?php if($song->owner2 != NULL){ echo ' and ' . anchor('artist/'.$song->owner2, get_username($song->owner2)); } ?>
				<?php endif; ?>
					<!-- upload date -->
					<span class="pull-right">
						<?php echo $song->date; ?>
					</span>
				</div>
				
				<!-- song name -->
				<h4 class="song-name"><?php echo anchor('song/'.$song->id, $song->name); ?>
					<!-- tags -->
		            <div class="song-tags">
		            	<?php if($song->tags != NULL): ?>
			            	<span class="tags">&amp;<?php echo $song->tags; ?></span>
						<?php endif; ?>
						<span class="tags">Space</span>
						<span class="tags">Funky</span>
						<span class="tags">Fast</span>
		            </div>
				</h4>
			</div>
        </div>
        <div class="col-md-10">
        	<div class="play-song">
	        	<audio id="audio<?php echo $song->id; ?>" class="upload-counter" controls>
					<source src="/music/<?php echo $song->file; ?>" />
				</audio>
        	</div>				
			<script type="text/javascript">				
				document.getElementById('audio<?php echo $song->id; ?>').addEventListener('play', function(){
					
					if($(this).hasClass('upload-counter')) {
						
						// Counter for the number of plays				
						var playCount = parseInt($('.play-count-<?php echo $song->id; ?>').text());
					  	playCount++;
				  	
					  	// Update the counter text with the new value			  	
					  	$('.play-count-<?php echo $song->id; ?>').text(playCount);
				  	
					  	// Post the number of plays to the database
						$.post('/api/music/add_play/', { song_id: <?php echo $song->id; ?> });
						
						$(this).removeClass('upload-counter');
					}
				});
			</script>
        </div>
        <div class="col-md-10">					
			<button type="button" class="btn btn-default btn-lg action-btn" onclick="document.location='/song/download/<?php echo $song->id; ?>'">
				<span class="glyphicon glyphicon-save"></span> <span class="hide-mobile">Download</span>
			</button>
			<button type="button" class="btn btn-default btn-lg action-btn">
				<span class="glyphicon glyphicon-share-alt"></span> <span class="hide-mobile">Share</span>
			</button>
			<!-- plays, downloads, and shares -->
			<div class="song-stats">
				<span class="glyphicon glyphicon-play-circle"></span><span class="play-count-<?php echo $song->id; ?>"><?php echo $song->plays; ?></span>
				<span class="glyphicon glyphicon-save"></span><span><?php echo $song->downloads; ?></span>
			</div>
		</div>
    </div>
    <?php
    endforeach;
    endif;
    ?>
</div>
