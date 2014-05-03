<div id="song-listing" class="is-col-lg-12">
<div class="song-list">
    <div class="col-md-2 visible-lg">
        <!-- song image -->
        <?php if($song->picture != NULL): ?>
            <img class="album-art hide-mobile" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
        <?php else: ?>
            <?php echo '<img class="album-art" src="/resource/img/Background_Triangles_Blue.png" />'; ?>
        <?php endif; ?>
        </div>
        <div class="col-md-10 is-col-md-10">
            <div class="col-md-6 is-col-md-6">
                <!-- album art -->
                <?php if($song->picture != NULL): ?>
                    <img class="visible-xs" src="<?php echo $song->picture; ?>" alt="<?php echo $song->name; ?>" />
                <?php endif; ?>
                <div class="song-image">
                    <?php echo '<img class="album-art visible-md visible-sm visible-xs" src="/resource/img/Background_Triangles_Blue.png" />'; ?>
                </div>

                <!-- creators -->
                <div class="creators">
                <?php if($song->owner != NULL): 
                    echo anchor('artist/'.$song->owner, get_username($song->owner));
                    if($song->owner2 != NULL){ echo ' and ' . anchor('artist/'.$song->owner2, get_username($song->owner2)); } 
                endif;
                if($this->authentication->is_signed_in())
                {
                    if($song->owner == $this->session->userdata('account_id') || $song->owner2 == $this->session->userdata('account_id'))
                    {
                        echo '<div class="pull-right">' . anchor('song/edit/'.$song->id, '<span class="glyphicon glyphicon-pencil"></span> ' . lang('music_song_edit'), array('class' => 'btn btn-warning')) . '</div>';
                    }
                }
                ?>
                
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
                        <div class="g-plus" data-action="share" data-annotation="none" data-href="<?php echo base_url('song/'.$song->id); ?>"></div>
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

<!-- claiming the song -->
<?php
if($claim && $this->authentication->is_signed_in())
{
    echo form_open('', array('role' => 'form'));
    echo '<h2>'.lang('music_claim').'</h2>';
    echo validation_errors();
    if(isset($message))
    {
        if($message === 'success')
        {
            echo '<div class="alert alert-success alert-dismissable">'.lang('music_msg_added').'</div>';
        }
        elseif($message === 'failure')
        {
            echo '<div class="alert alert-warning alert-dismissable">'.lang('music_msg_added_fail').'</div>';
        }
    }
    if(!(isset($message) && $message === 'success'))
    {
        echo '<div class="form-group">';
        echo form_label(lang('music_control_code'), 'control-code', array('class' => 'sr-only'));
        echo form_input(array('class' => 'form-control', 'placeholder' => lang('music_control_code'), 'name' => 'control_code', 'id' => 'control-code'));
        echo '</div>';
        echo form_submit(array('class' => 'btn btn-primary', 'type' => 'submit', 'value' => lang('music_claim')));
    }
    echo form_close();
}
elseif($claim && !$this->authentication->is_signed_in())
{
    echo '<div class="alert alert-warning alert-dismissable">'.lang('music_claim_account_needed').'</div>';
}   
?>
</div>
