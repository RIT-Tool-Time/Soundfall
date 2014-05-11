<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1390424384513284',
      xfbml      : true,
      version    : 'v2.0'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div class="col-md-2 artist_container">
	<div class="sidebar">
		<div class="col-md-6">
			<div class="profile-card">
				<div class="profile-avatar text-center">
					<img class="img-rect" src="<?php echo get_avatar($artist->id, 100, 100);?>" width="100" height="100" alt="profile avatar" />
					<h2><?php echo $artist->username; ?></h2>
				</div>
			</div>
			
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
				<img class="album-art hide-mobile" src="/resource/img/album_art/<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
			<?php else: ?>
				<img class="album-art" src="/resource/img/Background_Triangles_Blue.png" />
		<?php endif; ?>
        </div>        
        <div class="col-md-10">
      		<div class="col-md-6">
				
			<!-- album art -->
			<?php if($song->picture != NULL): ?>
				<div class="song-image">
					<img class="album-art visible-md visible-sm visible-xs" src="/resource/img/album_art/<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
				</div>
		    <?php endif; ?>
		        
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
			<button type="button" class="btn btn-default btn-lg action-btn" data-toggle="modal" data-target="#share-modal-<?php echo $song->id; ?>">
				<span class="glyphicon glyphicon-share-alt"></span> <span class="hide-mobile"><?php echo lang('music_share'); ?></span>
			</button>
			<!-- share modal -->
			<div class="modal fade" id="share-modal-<?php echo $song->id; ?>" tabindex="-1" role="dialog" aria-labelledby="share-modal-<?php echo $song->id; ?>-label" aria-hidden="true">
				<div class="modal-dialog modal-sm">
				  <div class="modal-content">
				    <div class="modal-header">
				      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				      <h4 class="modal-title" id="share-modal-<?php echo $song->id; ?>-label"><?php echo lang('music_share'); ?></h4>
				    </div>
				    <div class="modal-body">
						<div class="sharing-options">
							<!-- Facebook -->
							<div class="facebook-container">
							<div class="fb-share-button" data-href="<?php echo base_url('song/'.$song->id); ?>" data-type="button"></div>
							</div>
							<!-- /Facebook -->
							<!-- Twitter -->
							<div class="twitter-container">
							<a href="https://twitter.com/share" data-dnt="true" data-count="none" class="twitter-share-button" data-lang="en" data-url="<?php echo base_url('song/'.$song->id); ?>">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							</div>
							<!-- /Twitter -->
							<!-- Google+ -->
							<div class="google-container">
							<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>
							<div class="g-plus" data-action="share" data-annotation="none" data-width="57" data-href="<?php echo base_url('song/'.$song->id); ?>"></div>
							</div>
							<!-- /Google+ -->
						</div>
				    </div>
				  </div>
				</div>
			</div>
			
			<!-- plays, downloads, and shares -->
			<div class="song-stats">
				<span class="glyphicon glyphicon-play-circle"></span><span class="play-count-<?php echo $song->id; ?>"><?php echo $song->plays; ?></span>
				<span class="glyphicon glyphicon-save"></span><span><?php echo $song->downloads; ?></span>
			</div>
		</div>
    </div>
    <?php
    endforeach;
    else: ?>
    	<div class="alert alert-danger">Sorry this user has no saved songs.</div>
    <?php endif; ?>
</div>
