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
            <h4><?php echo anchor('song/'.$song->id, $song->name); ?></h4>
            <h4><?php echo anchor('song/download/'.$song->id, 'download'); ?></h4>
            <!-- tags -->
            <div class="song-tags">
            	<?php if($song->tags != NULL): ?>
	            	<span class="tags"><?php echo $song->tags; ?></span>
				<?php endif; ?>
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
<script type="text/javascript">
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
                        jQuery.event.dispatch.apply(_self, _args );
                    }
                    
                    timer = setTimeout( function(){
                        timer = null;
                    }, special.scrollstop.latency);
                    
                };
            
            jQuery(this).bind('scroll', handler).data(uid1, handler);
            
        },
        teardown: function(){
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );
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
                        jQuery.event.dispatch.apply(_self, _args );
                        
                    }, special.scrollstop.latency);
                    
                };
            
            jQuery(this).bind('scroll', handler).data(uid2, handler);
            
        },
        teardown: function() {
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );
        }
    };
</script>
<script type="text/javascript">

	var pageNumber = 1;
	var isLoading = false;

	$(window).bind('scrollstop', function(){
    	if (document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight) { 
			
			isLoading = true;
			
			if(isLoading == true) {
				pageNumber++;
			
		     	$.getJSON("http://tooltime.cias.rit.edu/api/music/music/" + pageNumber, function(data) {
					
					if (data.length	> 0) {
						$.each(data, function(key, val) {
							var id = val.id;
							var name = val.name;
							var picture = val.picture;
							var file = val.file;	
							
							$('#song-listing').append('<div class="song-list"><div class="col-md-2"><!--img src="'+ picture +'" alt="'+ name +'" /--></div><div class="col-md-4"><h4 class=""><a href="song/'+ id +'">'+ name +'</a></h4><h4><a href="http://tooltime.cias.rit.edu/song/download/'+ id +'">download</a></h4><div class="song-tags"></div></div><div class="col-md-6"><div class="play-song"><audio src="music/'+ file +'" controls preload="metadata"></audio></div></div>');					
						});
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