<div class="page-header text-center">
            <h1><?php echo sprintf(lang('sign_in_heading'), lang('website_title')); ?></h1>
        </div>
        <p class="text-center"><?php echo lang('sign_in_dont_have_account') . " " . anchor('#sign-up-modal', lang('sign_in_sign_up_now'), array("role"=>"button", "data-toggle"=>"modal", "data-dismiss"=>"modal")); ?></p>
    </div>
    <div class="modal-body">
    <div class="col-lg-6">
	<?php if ($third_party_auth = $this->config->item('third_party_auth')) : ?>
		<ul class="social-links">
			<?php foreach($third_party_auth['providers'] as $provider_name => $provider_values) : ?>
				<?php if($provider_values['enabled']) : ?>
				<li class="third_party"><?php echo anchor('account/connect/'.$provider_name, '<img id="'.strtolower($provider_name).'" class="'.strtolower($provider_name).'" src="'.base_url(RES_DIR.'/img/auth_icons/'.strtolower($provider_name).'.png').'" alt="'.sprintf(lang('sign_up_with'), lang('connect_'.strtolower($provider_name))).'" height="64" width="64">' ); ?></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
    </div><!-- /span6 -->
    <div class="col-lg-6">
	<?php echo form_open("account/sign_in".($this->input->get('continue') ? '/?continue='.urlencode($this->input->get('continue')) : '')); ?>
	<?php echo form_fieldset(); ?>
	
		<?php if (isset($sign_in_error)) : ?>
	<div class="alert alert-danger"><?php echo $sign_in_error; ?></div>
		<?php endif; ?>

	<div class="input-group <?php echo (form_error('sign_in_username_email') || isset($sign_in_username_email_error)) ? 'error' : ''; ?>">
		<?php echo form_input(array('name' => 'sign_in_username_email', 'id' => 'sign_in_username_email', 'value' => set_value('sign_in_username_email'), 'maxlength' => '24', 'class' => 'form-control', 'placeholder' => lang('sign_in_username_email'))); ?>
		<?php if (form_error('sign_in_username_email') || isset($sign_in_username_email_error)) :?>
<span class="help-inline">
		<?php echo form_error('sign_in_username_email'); ?>
			<?php if (isset($sign_in_username_email_error)) : ?>
				<span class="alert alert-danger"><?php echo $sign_in_username_email_error; ?></span>
			<?php endif; ?>
		</span>
		<?php endif; ?>
	</div>

	<div class="input-group <?php echo form_error('sign_in_password') ? 'error' : ''; ?>">
		<?php echo form_password(array('name' => 'sign_in_password', 'id' => 'sign_in_password', 'value' => set_value('sign_in_password'), 'class' => 'form-control', 'placeholder' => lang('sign_in_password'))); ?>
		<?php if (form_error('sign_in_password')) : ?>
			<span class="help-inline"><?php echo form_error('sign_in_password'); ?></span>
		<?php endif; ?>

		<?php if (isset($recaptcha)) : ?>
			<?php echo $recaptcha; ?>
			<?php if (isset($sign_in_recaptcha_error)) : ?>
				<span class="alert alert-danger"><?php echo $sign_in_recaptcha_error; ?></span>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<div>
		<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-submit pull-right', 'content' => lang('sign_in_sign_in'))); ?>
	</div>
	
	<div>
		<label class="checkbox">
			<?php echo form_checkbox(array('name' => 'sign_in_remember', 'id' => 'sign_in_remember', 'value' => 'checked', 'checked' => $this->input->post('sign_in_remember'))); ?>
			<?php echo lang('sign_in_remember_me'); ?>
		</label>
	</div>
	
	<p class="forgot-msg"><?php echo anchor('account/forgot_password', lang('sign_in_forgot_your_password')); ?></p>
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?> 
    </div>