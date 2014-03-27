<div class="page-header">
    <h1><?php echo sprintf(lang('connect_with_x'), lang('connect_openid')); ?></h1>
</div>

<h3><?php echo sprintf(lang('connect_enter_your'), lang('connect_openid_url')); ?>
    <small><?php echo anchor($this->config->item('openid_what_is_url'), lang('connect_start_what_is_openid'), array('target' => '_blank')); ?></small>
</h3>

<?php echo form_open(uri_string()); ?>
<?php echo form_fieldset(); ?>

<?php if (isset($connect_openid_error)) : ?>
    <div class="col-sm-6">
	<div class="alert alert-danger"><?php echo $connect_openid_error; ?></div>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('connect_openid_error')) : ?>
    <div class="col-sm-6">
	<div class="alert alert-danger"><?php echo $this->session->flashdata('connect_openid_error'); ?></div>
    </div>
<?php endif; ?>
<?php if(form_error('connect_openid_url')): ?>
    <div class="col-sm-6">
	<span class="alert alert-danger"><?php echo form_error('connect_openid_url'); ?></span>
    </div>
<?php endif; ?>
<div class="col-sm-6">
    <?php echo form_input(array('name' => 'connect_openid_url', 'id' => 'connect_openid_url', 'class' => 'openid form-control', 'value' => set_value('connect_openid_url'))); ?>
</div>

<div class="col-sm-2">
    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary', 'content' => lang('connect_proceed'))); ?>
</div>
<?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>