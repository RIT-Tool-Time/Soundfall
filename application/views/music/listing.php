<!-- searching and filtering -->
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
	    		<form name="explore" action="form">
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
				<form name="explore" action="form">
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
				<form name="explore" action="form">
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
	    	<h3>Popular</h3>
			<div>
				<form name="explore" action="form">
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
            	<img class="hide-mobile" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
            <?php endif; ?>
			<img class="hide-mobile" src="http://placehold.it/130x130">
        </div>
        <div class="col-md-10">
        
            <!-- song name and creators -->
			<div class="col-md-6">
				<?php if($song->picture != NULL): ?>
		        	<img class="show-mobile" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
		        <?php endif; ?>
				<img class="show-mobile song-image" src="http://placehold.it/64x64">
				
				<!-- time stamp -->
				<p class="creators">Tyler and Andrew<span style="float: right;">1h</span></p>
				<h4 class="song-name"><?php echo anchor('song/'.$song->id, $song->name); ?></h4>
			</div>
		
            <!-- tags -->
            <!--div class="col-md-6 hide-mobile">
	            <div class="song-tags">
	            	<!--?php if($song->tags != NULL): ?-->
		            	<!--span class="tags"><?php echo $song->tags; ?></span-->
					<!--?php endif; ?-->
	            <!--/div>
            </div-->
        </div>
        <div class="col-md-10">
        	
        	<!-- play song -->
        	<div class="play-song">
                <audio src="music/<?php echo $song->file; ?>" controls preload="metadata">
                    
                </audio>
                <script type="text/javascript">
                
                </script>
            </div>
        </div>
        
        <div class="col-md-10">
			
			<!-- downloading and sharing -->
			<button type="button" class="btn btn-default btn-lg action-btn" onclick="document.location='http://tooltime.cias.rit.edu/song/download/' + '<?php echo$song->id ?>'">
				<span class="glyphicon glyphicon-save"></span> <span class="hide-mobile">Download</span>
			</button>
			<button type="button" class="btn btn-default btn-lg action-btn">
				<span class="glyphicon glyphicon-share-alt"></span> <span class="hide-mobile">Share</span>
			</button>
			<!-- plays, downloads, and shares -->
			<div class="song-stats">
				<span class="glyphicon glyphicon-play-circle"></span><span><?php echo $song->plays; ?></span>
				<span class="glyphicon glyphicon-save"></span><span><?php echo $song->downloads; ?></span>
				<span class="glyphicon glyphicon-share-alt"></span><span>17</span>
			</div>
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
	
	$('#accordion').accordion({
		collapsible: true
	});
	
	$(window).bind('scrollstop', function(){
    	if (document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight) { 
			
			isLoading = true;
			
			if(isLoading == true) {
				pageNumber++;
			
		     	$.getJSON("http://tooltime.cias.rit.edu/api/music/music/" + pageNumber, function(data) {
					
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