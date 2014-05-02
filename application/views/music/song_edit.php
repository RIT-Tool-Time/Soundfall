<script type="text/javascript" src="<?php echo base_url().RES_DIR; ?>js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>css/bootstrap-multiselect.css" type="text/css"/>
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
$form .= '<select id="tags" name="tags[]" class="multiselect" multiple="multiple">';
foreach($tags as $key => $tag)
{
    $selected = NULL;
    foreach($song->tags as $id => $nm)
    {
        if($id === $key)
        {
            $selected = "selected";
        }
    }
    $form .= '<option value="'.$key.'" '.$selected.'>'.$tag.'</option>';
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
    numberDisplayed: 4
    });
});

//make sure that only 4 can be selected
$(document).ready(function() {
    $('#example37').multiselect({
        onChange: function(option, checked)
        {
            // Get selected options.
            var selectedOptions = $('#example37 option:selected');
            
            if (selectedOptions.length >= 4)
            {
                // Disable all other checkboxes.
                var nonSelectedOptions = $('#example37 option').filter(function()
                {
                    return !$(this).is(':selected');
                });
                
                var dropdown = $('#example37').siblings('.multiselect-container');
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
                var dropdown = $('#example37').siblings('.multiselect-container');
                $('#example37 option').each(function()
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