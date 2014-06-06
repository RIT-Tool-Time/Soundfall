<?php if (! ($this->config->item("sign_up_enabled"))): ?>
	<div class="col-lg-12">
		<div class="page-header">
			<h2><?php echo sprintf(lang('sign_up_heading'), lang('website_title')); ?></h2>
		</div>
		<div class="alert alert-danger">
			<strong><?php echo lang('sign_up_notice');?> </strong> <?php echo lang('sign_up_registration_disabled'); ?>
		</div>
	</div>
<?php endif;?>

<?php if ($this->config->item("sign_up_enabled")): ?>
	<div class="page-header text-center">
		<h1><?php echo sprintf(lang('sign_up_heading'), lang('website_title')); ?></h1>
	</div>
	<p class="text-center"><?php echo lang('sign_up_already_have_account'); ?> <?php echo anchor('account/sign_in', lang('sign_up_sign_in_now')); ?></p>
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
		<?php echo form_open(uri_string(), 'class="form-horizontal"'); ?>
		<?php echo form_fieldset(); ?>
		<div id="username" class="form-group <?php echo (form_error('sign_up_username') || isset($sign_up_username_error)) ? 'alert alert-danger' : ''; ?>">
			<div id="username_controls">
				<?php echo form_input(array('name' => 'sign_up_username', 'id' => 'sign_up_username', 'value' => set_value('sign_up_username'), 'maxlength' => '24', 'class' => 'form-control', 'placeholder' => lang('sign_up_username'))); ?>
				<?php if (form_error('sign_up_username') || isset($sign_up_username_error)) : ?>
					<?php echo form_error('sign_up_username'); ?>
					<?php if (isset($sign_up_username_error)) : ?>
						<?php echo $sign_up_username_error; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	
		<div id="email" class="form-group <?php echo (form_error('sign_up_email') || isset($sign_up_email_error)) ? 'alert alert-danger' : ''; ?>">
			<div id="email_controls">
				<?php echo form_input(array('name' => 'sign_up_email', 'id' => 'sign_up_email', 'value' => set_value('sign_up_email'), 'maxlength' => '160', 'class' => 'form-control', 'placeholder'=> lang('sign_up_email'))); ?>
				<?php if (form_error('sign_up_email') || isset($sign_up_email_error)) : ?>
					<?php echo form_error('sign_up_email'); ?>
					<?php if (isset($sign_up_email_error)) : ?>
						<?php echo $sign_up_email_error; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="password" class="form-group <?php echo (form_error('sign_up_password')) ? 'alert alert-danger' : ''; ?>">
			<div id="password_controls">
				<?php echo form_password(array('name' => 'sign_up_password', 'id' => 'sign_up_password', 'value' => set_value('sign_up_password'), 'class' => 'form-control', 'placeholder' => lang('sign_up_password'))); ?>
				<?php if (form_error('sign_up_password')) : ?>
					<?php echo form_error('sign_up_password'); ?>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="confirm_password" class="form-group <?php echo (form_error('sign_up_confirm_password')) ? 'alert alert-danger' : ''; ?>">
			<div id="confirm_password_controls">
				<?php echo form_password(array('name' => 'sign_up_password_confirm', 'id' => 'sign_up_password_confirm', 'value' => set_value('sign_up_password_confirm'), 'class' => 'form-control', 'placeholder' => lang('sign_up_password_confirm'))); ?>
				<?php if (form_error('sign_up_password_confirm')) : ?>
					<?php echo form_error('sign_up_password_confirm'); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php if (isset($recaptcha)) :
			echo $recaptcha;
			if (isset($sign_up_recaptcha_error)) : ?>
				<span class="alert alert-danger"><?php echo $sign_up_recaptcha_error; ?></span>
			<?php endif; ?>
		<?php endif; ?>
		<div class="checkbox col-md-6">
			<label>
				<input type="checkbox" name="sign_up_terms" value="agree"><?php echo lang('sign_up_terms');?>
			</label>
			<?php if (form_error('sign_up_terms') || isset($sign_up_terms_error)) : ?>
				<span class="alert alert-danger">
				<?php echo form_error('sign_up_terms'); ?>
				<?php if (isset($sign_up_terms_error)) : ?>
					<?php echo $sign_up_terms_error; ?>
				<?php endif; ?>
				</span>
			<?php endif; ?>
		</div>
		<div class="col-md-6">
			<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-submit pull-right', 'content' => '<i class="glyphicon glyphicon-pencil"></i> '.lang('sign_up_create_my_account'))); ?>
		</div>
	</div>
	
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?>
	<?php
	    if(!isset($account))
	    {
		    echo '<script src="'.base_url('resource/js/sign_up_validation.js').'"></script>';
		    echo '<script>
		    <!-- START : Instant Verification Check -->
		    var _u_noUsername = "'.lang('sign_up_js_validation_no_username').'";
		    var _u_tooShort = "'.lang('sign_up_js_validation_short').'";
		    var _u_inVaildChars = "'.lang('sign_up_js_validation_invalid_chars').'";
		    var _u_alreadyExists = "'.lang('sign_up_username_taken').'";
		    var _u_avail = "'.lang('sign_up_js_validation_username_available').'";
		    
		    var _e_invaild = "'.lang('sign_up_js_validation_email_invaild').'";
		    var _e_vaild = "'.lang('sign_up_js_validation_email_vaild').'";
		    
		    var _p_no = "'.lang('sign_up_js_validation_password_no').'";
		    var _p_tooShort = "'.lang('sign_up_js_validation_password_short').'";
		    var _p_good = "'.lang('sign_up_js_validation_password_good').'";
		    
		    var _cp_dot = "'.lang('sign_up_js_validation_password_confirm_dot').'";
		    var _cp_noMatch = "'.lang('sign_up_js_validation_password_cofirm_nomatch').'";
		    var _cp_match = "'.lang('sign_up_js_validation_password_cofirm_match').'";
		    
		    var _s_checking = "'.lang('sign_up_js_validation_checking').'";
		    
		    $(document).ready(function(){
			    setUpMessages("");
		    });
		    <!-- END : Instant Verification Check -->
	    </script>';
	    }
    ?>
<?php endif;?>