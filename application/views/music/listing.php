<!-- Wavesurfer -->
<script type="text/javascript" src="/resource/js/wavesurfer.js"></script>
<script type="text/javascript" src="/resource/js/webaudio.js"></script>
<script type="text/javascript" src="/resource/js/drawer.js"></script>
<script type="text/javascript" src="/resource/js/drawer.canvas.js"></script>

<!-- searching and filtering -->
<div class="search visible-xs">
	<input type="text" name="search" placeholder="search" />
</div>
<div id="filters" class="col-lg-2 hide-mobile">
	<div class="sidebar">
	    <h2 style="font-weight: 500;">Explore</h2>
		<div class="search"> 
			<form action="search">
				<input type="text" name="Search" placeholder="Search"><br>
			</form>
		</div>
		<div id="accordion">
			<h3>Tags</h3>
			<div>
	    		<form name="explore" role="form">
	    			<input name="box" value="Average" type="checkbox">Average<br>
		    		<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
				</form>
			</div>
			<h3>Color</h3>
			<div>
				<form name="explore" role="form">
	    			<input name="box" value="Average" type="checkbox">Average<br>
		    		<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
				</form>
			</div>
			<h3>Patterns</h3>
			<div>
				<form name="explore" role="form">
	    			<input name="box" value="Average" type="checkbox">Average<br>
		    		<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
	    			<input name="box" value="Average" type="checkbox">Average<br>
				</form>
			</div>
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
        <div class="col-md-2 hide-mobile">
            <!-- song image -->
		<?php if($song->picture != NULL): ?>
			<img class="album-art hide-mobile" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
		<?php else: ?>
			<?php echo '<img class="album-art hide-mobile" src="/resource/img/Background_Triangles_Blue.png" />'; ?>
		<?php endif; ?>
        </div>
        <div class="col-md-10">
      		<div class="col-md-6">
				
				<!-- album art -->
				<?php if($song->picture != NULL): ?>
		        	<img class="visible-xs" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
		        <?php endif; ?>
		        <div class="song-image">
					<?php echo '<img class="album-art visible-xs" src="/resource/img/Background_Triangles_Blue.png" />'; ?>
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
			            	<span class="tags"><?php echo $song->tags; ?></span>
						<?php endif; ?>
						<span class="tags">Funky</span>
						<span class="tags">Dance</span>
						<span class="tags">Music</span>
		            </div>
				</h4>
			</div>
        </div>
        <div class="col-md-10">
        	
        	<!-- play song and update counter -->
        	<div class="play-song">
        		<div id="wave_<?php echo $song->id; ?>"></div>
       		</div>
        </div>
        
        <div class="col-md-10">
			
			<!-- play, download and share -->
			<button id="music-controls-<?php echo $song->id; ?>" type="button" class="btn btn-default btn-lg action-btn upload-counter">
				<span class="glyphicon glyphicon-play"></span> <span class="hide-mobile">Play</span>
			</button>
			
			<button type="button" class="btn btn-default btn-lg action-btn" onclick="document.location='/song/download/' + '<?php echo $song->id; ?>'">
				<span class="glyphicon glyphicon-save"></span> <span class="hide-mobile">Download</span>
			</button>
			<button type="button" class="btn btn-default btn-lg action-btn">
				<span class="glyphicon glyphicon-share-alt"></span> <span class="hide-mobile">Share</span>
			</button>
			<!-- plays, downloads, and shares -->
			<div class="song-stats">
				<span class="glyphicon glyphicon-play-circle"></span><span class="play-count-<?php echo $song->id; ?>"><?php echo $song->plays; ?></span>
				<span class="glyphicon glyphicon-save"></span><span><?php echo $song->downloads; ?></span>
				<span class="glyphicon glyphicon-share-alt"></span><span>17</span>
			</div>
		</div>
		
		<script type="text/javascript">
                
        	// Generate waveforms for each of the mp3's
			
			var wavesurfer_<?php echo $song->id; ?> = Object.create(WaveSurfer);
			
			wavesurfer_<?php echo $song->id; ?>.init({
				container: document.getElementById('wave_<?php echo $song->id; ?>'),
				fillParent: true,
				waveColor: '#5174a5'
			});
			
			// Music events
			
			wavesurfer_<?php echo $song->id; ?>.on('play', function () {
		
				// If we can update the number of plays do so only once
				
				if($('#music-controls-<?php echo $song->id ?>').hasClass('upload-counter')) {
					// Counter for the number of plays
				
					var playCount = parseInt($('.play-count-<?php echo $song->id; ?>').text());
				  	playCount++;
				  	
				  	// Update the counter text with the new value
				  	
				  	$('.play-count-<?php echo $song->id; ?>').text(playCount);
				  	
				  	// Post the number of plays to the database
				  	
					$.post('/api/music/add_play/', { song_id: <?php echo $song->id; ?> });
				}
			});
								
			$('#music-controls-<?php echo $song->id ?>').on('click', function() {
			
				// Toggle the audio between play and pause
				
				wavesurfer_<?php echo $song->id; ?>.playPause();
				
				// Update the button to reflect the current play state
				
				if($(this).children('span.glyphicon').hasClass('glyphicon-play')) {
					$(this).removeClass('upload-counter');
					$(this).children('span.glyphicon').removeClass('glyphicon-play');
					$(this).children('span.glyphicon').addClass('glyphicon-pause');
					$(this).children('span.glyphicon').next().text('Pause');
				}
				else
				{
					$(this).children('span.glyphicon').removeClass('glyphicon-pause');
					$(this).children('span.glyphicon').addClass('glyphicon-play');
					$(this).children('span.glyphicon').next().text('Play');
				}				
			});
				
			// Loading the audio file
			wavesurfer_<?php echo $song->id; ?>.load('music/<?php echo $song->file; ?>');

        </script>
    </div>
    <?php
    endforeach;
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
		active: false
	});
	     
	// When a user reaches the bottom of the page, and ajax call is made
	// to load more songs
	
	$(window).bind('scrollstop', function(){
    	if (document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight) { 
			
			isLoading = true;
			
			if(isLoading == true) {
				pageNumber++;
			
		     	$.getJSON("/api/music/music/" + pageNumber, function(data) {
					
					if (data.length	> 0) {
						/*$.each(data, function(key, val) {
							var id = val.id;
							var name = val.name;
							var picture = val.picture;
							var file = val.file;
							var tags = val.tags;
							
							$('#song-listing').append('<div class="song-list"><div class="col-md-2"><!--img src="'+ picture +'" alt="'+ name +'" /--></div><div class="col-md-4"><h4 class=""><a href="song/'+ id +'">'+ name +'</a></h4><h4><a href="http://tooltime.cias.rit.edu/song/download/'+ id +'">download</a></h4><div class="song-tags"><span class="tags">'+ tags +'</span></div></div><div class="col-md-6"><div class="play-song"><audio src="music/'+ file +'" controls preload="metadata"></audio></div></div>');					
						});*/
					}
					else {
						isLoading = false;
						pageNumber--;						
					}
				}); 
			}
	    }
	});
</script>