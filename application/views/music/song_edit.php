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
$form .= form_submit(array('class' => 'btn btn-primary btn-lg'), 'submit');
$form .= form_close();
echo $form;
?>