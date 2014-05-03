<script type="text/javascript" src="<?php echo base_url().RES_DIR; ?>/js/bootstrap-multiselect.js"></script>
<script>
//https://davidstutz.github.io/bootstrap-multiselect/
//load the CSS
$(document).ready(function()
{
    var fileref = document.createElement("link");
    fileref.setAttribute("rel", "stylesheet");
    fileref.setAttribute("type", "text/css");
    fileref.setAttribute("href", "<?php echo base_url().RES_DIR; ?>/css/bootstrap-multiselect.css");
    document.getElementsByTagName("head")[0].appendChild(fileref);
});    
</script>

<?php
echo validation_errors();
$form = form_open('', array('role' => 'form'));

$form .= '<div class="form-group">';
$form .= form_label(lang('song_name'), 'song_name');
$form .= form_input(array('id' => 'song_name', 'name' => 'song_name', 'class' => 'form-control'), set_value('song_name', $song->name));

$form .= '</div><div class="form-group">';
$form .= form_label(lang('song_description'), 'song_description');
$form .= form_textarea(array('id' => 'song_description', 'name' => 'song_description', 'class' => 'form-control'), set_value('song_description', $song->description, TRUE));

$form .= '</div><div class="checkbox">';
$form .= form_checkbox(array('class' => 'checkbox', 'id' => 'song_private', 'name' => 'song_private'), set_checkbox('song_private', $song->private)) . lang('song_private');
$form .= '</div>';

$form .= '<div class="form-group">';
$form .= form_label(lang('song_tags'), 'song_tags');
$form .= '<select id="song_tags" name="song_tags[]" class="multiselect" multiple="multiple">';

foreach($tags as $tag)
{
    $selected = NULL;
    foreach($song->tags as $id => $nm)
    {
        if($id == $tag->id)
        {
            $selected = "selected";
        }
    }
    $form .= '<option value="'.$tag->id.'" '.$selected.'>'.$tag->name.'</option>';
}
$form .= '</select>';
$form .= '</div>';

$form .= form_submit(array('class' => 'btn btn-primary btn-lg'), 'submit');
$form .= form_close();
echo $form;
?>

<!-- Script for multiselect -->
<script>
$(document).ready(function() {$('.multiselect').multiselect({
    numberDisplayed: 3,
    });
});

//make sure that only 3 can be selected
$(document).ready(function()
{
    $('#song_tags').multiselect({
        onChange: function(option, checked)
        {
            // Get selected options.
            var selectedOptions = $('#song_tags option:selected');
            
            if(selectedOptions.length >= 3)
            {
                // Disable all other checkboxes.
                var nonSelectedOptions = $('#song_tags option').filter(function()
                {
                    return !$(this).is(':selected');
                });
                
                var dropdown = $('#song_tags').siblings('.multiselect-container');
                nonSelectedOptions.each(function()
                {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            }
            else
            {
                // Enable all checkboxes.
                var dropdown = $('#song_tags').siblings('.multiselect-container');
                $('#song_tags option').each(function()
                {
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
});
</script>