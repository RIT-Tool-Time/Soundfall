<?php
$form = form_open('', array('role' => 'form'));
$form .= form_input(array('name' => 'email', 'placeholder' => 'E-mail', 'id' => 'email', 'class' => 'form-control', 'type' => 'email'));
$form .= form_submit(array('type' => 'submit', 'name' => 'submit', 'value' => "Send!", 'class' => "btn btn-success"));
$form .= form_close();
echo $form;