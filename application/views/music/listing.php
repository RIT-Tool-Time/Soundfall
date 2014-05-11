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
<!-- searching and filtering -->
<div class="search visible-xs">
	<?php echo form_open('search', array('role' => 'form')); ?>
		<input type="text" id="search" name="search" placeholder="Search">
	<?php echo form_close(); ?></div>
<div id="filters" class="col-lg-2 invisible-xs">
	<div class="sidebar">
	    <h2 style="font-weight: 500;">Explore</h2>
		<div class="search"> 
			<?php echo form_open('search', array('role' => 'form')); ?>
				<input type="text" id="search" name="search" placeholder="Search">
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- listing of songs -->
<div id="song-listing" class="col-lg-10">
    <?php
    	if($stats['music_total'] > 0):
		foreach($songs as $song):
    ?>
    <div class="song-list">
        <div class="col-md-2 visible-lg">
            <!-- song image -->
			<?php if($song->picture != NULL): ?>
				<img class="album-art hide-mobile" src="/resource/img/album_art/<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
			<?php else: ?>
				<img class="album-art hide-mobile" src="/resource/img/Background_Triangles_Blue.png" alt="<?php echo $song->name; ?>" />
			<?php endif; ?>
        </div>
        <div class="col-md-10">
      		<div class="col-md-6">
				
				<!-- album art -->
				<?php if($song->picture != NULL): ?>
					<img class="visible-xs" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
				<?php endif; ?>
				<div class="song-image">
					<img class="album-art visible-md visible-sm visible-xs" src="/resource/img/Background_Triangles_Blue.png" />
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
					<?php foreach($song->tags as $id => $tag): ?>
						<span class="tags tag-<?php echo $id; ?>"><?php echo $tag; ?></span>
					<?php endforeach; ?>
				<?php endif; ?>
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
				<span class="glyphicon glyphicon-save"></span> <span class="hide-mobile"><?php echo lang('music_download'); ?></span>
			</button>
			<?php if ($this->authentication->is_signed_in()): ?>				
				<button type="button" class="btn btn-default btn-lg action-btn">
					<span class="glyphicon glyphicon-floppy-saved"></span> <span class="hide-mobile"><?php echo lang('music_save'); ?></span>
				</button>
			<?php endif; ?>
			
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
			
			<div class="song-stats">
				<span class="glyphicon glyphicon-play-circle"></span><span class="play-count-<?php echo $song->id; ?>"><?php echo $song->plays; ?></span>
				<span class="glyphicon glyphicon-save"></span><span><?php echo $song->downloads; ?></span>
			</div>
		</div>
    </div>
    <?php
    endforeach;
    else:
	echo '<div class="alert alert-danger">'.lang('music_none')."</div>";
    endif;
    ?>
</div>
<script type="text/javascript">

	// Scrolling functions - detect when a user stops scrolling
	
    var special = jQuery.event.special,
        uid1 = 'D' + (+new Date()),
        uid2 = 'D' + (+new Date() + 1);
        
    special.scrollstart = {
        setup: function() {
            
            var timer,
                handler =  function(evt) {
                    
                    var _self = this,
                        _args = arguments;
                    
                    if (timer) {
                        clearTimeout(timer);
                    } else {
                        evt.type = 'scrollstart';
                        jQuery.event.dispatch.apply(_self, _args);
                    }
                    
                    timer = setTimeout( function(){
                        timer = null;
                    }, special.scrollstop.latency);
                    
                };
            
            jQuery(this).bind('scroll', handler).data(uid1, handler);
            
        },
        teardown: function(){
            jQuery(this).unbind('scroll', jQuery(this).data(uid1));
        }
    };
    
    special.scrollstop = {
        latency: 300,
        setup: function() {
            
            var timer,
                    handler = function(evt) {
                    
                    var _self = this,
                        _args = arguments;
                    
                    if (timer) {
                        clearTimeout(timer);
                    }
                    
                    timer = setTimeout( function(){
                        
                        timer = null;
                        evt.type = 'scrollstop';
                        jQuery.event.dispatch.apply(_self, _args);
                        
                    }, special.scrollstop.latency);
                    
                };
            
            jQuery(this).bind('scroll', handler).data(uid2, handler);
            
        },
        teardown: function() {
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );
        }
    };
	
	var pageNumber = 1;
	var isLoading = false;
	
	// Collapsible menu for the tags
	
	$('#accordion').accordion({
		collapsible: true,
		heightStyle: 'content'	});
	     
	// When a user reaches the bottom of the page, and ajax call is made
	// to load more songs
	
	$(window).bind('scrollstop', function(){
    	if (document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight) { 
			
			isLoading = true;
			
			if(isLoading == true) {
				pageNumber++;
				
		     	$.getJSON("/api/music/music/" + pageNumber, function(data) {
					
					if (data.length	> 0) {
						$.each(data, function(key, val) {
							var id = val.id;
							var owner = val.owner;
							var owner2 = val.owner2;
							var name = val.name;
							var picture = val.picture;
							var file = val.file;
							var date = val.date;
							var tags = val.tags;
							var plays = val.plays;
							var downloads = val.downloads;
							var username = val.username;
							var username2 = val.username2;
							
							// Script for Facebook							
							var fScript = document.createElement('script');
							fScript.type = 'text/javascript';
							fScript.src = 'https://connect.facebook.net/en_US/sdk.js';
							
												
							// Script for Twitter							
							var tScript = document.createElement('script');
							tScript.type = 'text/javascript';
							tScript.src = 'https://platform.twitter.com/widgets.js';

							// Script for Google
							var gScript = document.createElement('script');
							gScript.type = 'text/javascript';
							gScript.src = 'https://apis.google.com/js/platform.js';							

							if(owner !== null) {
								username = '<a href="/artist/'+owner+'">'+username+'</a>';
							}
							else {
								username = '';
							}
							
							if(owner2 !== null) {
								username2 = ' and <a href="/artist/'+owner2+'">'+username2+'</a>';
							}	
							else {
								username2 = '';
							}
							
							if(picture !== null) {
								picture = 'resource/img/album_art/'+picture;
							}
							else {
								picture = 'resource/img/Background_Triangles_Blue.png';
							}
							
							var downloadLink = '/song/download/'+id+'';
							
							var btns = '<button type="button" class="btn btn-default btn-lg action-btn" onclick="document.location=&#39;'+downloadLink+'&#39;"><span class="glyphicon glyphicon-save"></span> <span class="hide-mobile">Download</span></button> <button type="button" class="btn btn-default btn-lg action-btn" data-toggle="modal" data-target="#share-modal-'+id+'"><span class="glyphicon glyphicon-share-alt"></span> <span class="hide-mobile">Share</span></button>';
							
							var shareModal = '<div class="modal fade" id="share-modal-'+id+'" tabindex="-1" role="dialog" aria-labelledby="'+id+'-label" aria-hidden="true"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="share-modal-'+id+'-label">Share</h4></div><div class="modal-body"><div class="sharing-options"><!-- Facebook --><div id="fScript'+id+'" class="facebook-container"><div class="fb-share-button" data-href="https://tooltime.cias.rit.edu/song/'+id+'" data-type="button"></div></div><!-- /Facebook --> <!-- Twitter --><div id="tScript'+id+'" class="twitter-container"><a href="https://twitter.com/share" data-dnt="true" data-count="none" class="twitter-share-button" data-lang="en" data-url="https://tooltime.cias.rit.edu:443/song/'+id+'">Tweet</a></div><!-- /Twitter --> <!-- Google --><div id="gScript'+id+'" class="google-container"><div class="g-plus" data-action="share" data-annotation="none" data-width="57" data-href="https://tooltime.cias.rit.edu/song/'+id+'"></div></div><!-- /Google --></div></div></div></div></div>';
							
							var songStats = '<div class="song-stats"><span class="glyphicon glyphicon-play-circle"></span><span class="play-count-'+id+'">'+plays+'</span><span class="glyphicon glyphicon-save"></span><span>'+downloads+'</span></div>';
	
							$('#song-listing').append('<div class="song-list"><div class="col-md-2 visible-lg"><!-- song image --><img class="album-art hide-mobile" src="'+picture+'" /></div><div class="col-md-10"><div class="col-md-6"><!-- album art --><div class="song-image"><img class="album-art visible-md visible-sm visible-xs" src="'+picture+'" /></div><!-- creators --><div class="creators">'+username+username2+'<!-- upload date --><span class="pull-right">'+date+'</span></div><!-- song name --><h4 class="song-name"><a href="song/'+id+'">'+name+'</a><!-- tags --></h4></div></div><div class="col-md-10"><div class="play-song"><audio id="audio'+id+'" class="upload-counter" controls><source src="/music/'+file+'" /></audio></div></div><div class="col-md-10">'+btns+'<!-- share modal -->'+shareModal+songStats+'</div>');
							
							document.getElementById('audio'+id+'').addEventListener('play', function(){
					
								if($(this).hasClass('upload-counter')) {
									
									// Counter for the number of plays				
									var playCount = parseInt($('.play-count-'+id+'').text());
								  	playCount++;
							  	
								  	// Update the counter text with the new value			  	
								  	$('.play-count-'+id+'').text(playCount);
							  	
								  	// Post the number of plays to the database
									$.post('/api/music/add_play/', { song_id: id });
									
									$(this).removeClass('upload-counter');
								}
							});
							
							// Add each of the script elements to the necessary containers
							setTimeout(function(){								
								// Twitter container
								$('#tScript'+id+'').prepend(tScript);

								// Google container
								$('#gScript'+id+'').prepend(gScript);
								
								fbAsyncInit();
							}, 1000);
						}); 	
					}
				});
			}
	    }
	});
</script>
<script type="text/javascript" src="https://apis.google.com/js/platform.js"></script>