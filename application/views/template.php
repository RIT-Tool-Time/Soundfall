<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo isset($title) ? $title.' - '.lang('website_title') : lang('website_title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui" /> 
    <meta name="description" content="Waterfall sharing platform" />
    <meta name="author" content="Jan Dvorak, Chris Blackman, Megan Kusher, Matthew Kinbaum, Tyler Stegall, Andrew Gucwa, Tyler Sposato, Katharine Read" />
    
    <base href="<?php echo base_url(); ?>"/>
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico"/>
    <link rel="author" href="humans.txt" />
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/css/style.css"/>
    <script src="<?php echo base_url().RES_DIR; ?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
</head>
<body>
    <div class="navbar navbar-default navbar-soundfall navbar-fixed-top" role="navigation">
		<div class="container">
            <div class="navbar-header">
            	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a href="http://tooltime.cias.rit.edu/music/listing"><img src="resource/img/logo.png" alt="logo" /></a>
            </div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
		        	<li><?php echo anchor('about', lang('website_about')); ?></li>
					<li><?php echo anchor('blog', lang('website_blog')); ?></li>
					<li><?php echo anchor('music/listing', lang('website_soundfall')); ?></li>
				</ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (!isset($account)) : ?>
                    
                    <li><?php echo anchor('#sign-in-modal', lang('website_sign_in'), array('data-toggle' =>"modal", 'data-target'=> "#sign-in-modal")); ?></li>
                    <li><?php echo anchor('#sign-up-modal', lang('website_sign_up'), array('data-toggle' =>"modal", 'data-target'=> "#sign-up-modal")); ?></li>
                    
                    <?php else: ?>
                    <li><?php echo anchor('account/sign_out', lang('website_sign_out')); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
		</div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
        
    <!-- MODALS -->
    <!-- sign in -->
    <div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="sign-in-modal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="page-header text-center">
            <h1><?php echo sprintf(lang('sign_in_heading'), lang('website_title')); ?></h1>
        </div>
        <p class="text-center"><?php echo lang('sign_in_dont_have_account') . " " . anchor('#sign-up-modal', lang('sign_in_sign_up_now'), array("role"=>"button", "data-toggle"=>"modal", "data-dismiss"=>"modal")); ?></p>
    </div>
    <div class="modal-body">
    <div class="col-lg-6" style="padding:0;">
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
		<!--label class="checkbox">
			<?php echo form_checkbox(array('name' => 'sign_in_remember', 'id' => 'sign_in_remember', 'value' => 'checked', 'checked' => $this->input->post('sign_in_remember'))); ?>
			<?php echo lang('sign_in_remember_me'); ?>
		</label-->
		<p class="forgot-msg"><?php echo anchor('account/forgot_password', lang('sign_in_forgot_your_password')); ?></p>
	</div>
	
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?> 
    </div>
    <div class="clearfix"></div>
    </div>
    </div>
    </div>
    </div>
    <!-- sign up -->
    <div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="sign-up-modal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="page-header text-center">
            <h1><?php echo sprintf(lang('sign_up_heading'), lang('website_title')); ?></h1>
        </div>
        <p class="text-center"><?php echo lang('sign_up_already_have_account'); ?> <?php echo anchor('#sign-in-modal', lang('sign_up_sign_in_now'), array("role"=>"button", "data-toggle"=>"modal", "data-dismiss"=>"modal")); ?></p>
    </div>
    <div class="modal-body">
        <div class="col-lg-6" style="padding:0;">
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
		<?php echo form_open("account/sign_up"); ?>
		<?php echo form_fieldset(); ?>
		<div id="username" class="form-group <?php echo (form_error('sign_up_username') || isset($sign_up_username_error)) ? 'error' : ''; ?>">
			<div id="username_controls">
				<?php echo form_input(array('name' => 'sign_up_username', 'id' => 'sign_up_username_modal', 'value' => set_value('sign_up_username'), 'maxlength' => '24', 'class' => 'form-control', 'placeholder' => lang('sign_up_username'))); ?>
				<?php if (form_error('sign_up_username') || isset($sign_up_username_error)) : ?>
					<span class="help-inline">
					<?php echo form_error('sign_up_username'); ?>
					<?php if (isset($sign_up_username_error)) : ?>
						<span class="alert alert-danger"><?php echo $sign_up_username_error; ?></span>
					<?php endif; ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
	
		<div id="email" class="form-group <?php echo (form_error('sign_up_email') || isset($sign_up_email_error)) ? 'error' : ''; ?>">
			<div id="email_controls">
				<?php echo form_input(array('name' => 'sign_up_email', 'id' => 'sign_up_email_modal', 'value' => set_value('sign_up_email'), 'maxlength' => '160', 'class' => 'form-control', 'placeholder'=> lang('sign_up_email'))); ?>
				<?php if (form_error('sign_up_email') || isset($sign_up_email_error)) : ?>
					<span class="help-inline">
					<?php echo form_error('sign_up_email'); ?>
					<?php if (isset($sign_up_email_error)) : ?>
						<span class="alert alert-danger"><?php echo $sign_up_email_error; ?></span>
					<?php endif; ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="password" class="form-group <?php echo (form_error('sign_up_password')) ? 'error' : ''; ?>">
			<div id="password_controls">
				<?php echo form_password(array('name' => 'sign_up_password', 'id' => 'sign_up_password_modal', 'value' => set_value('sign_up_password'), 'class' => 'form-control', 'placeholder' => lang('sign_up_password'))); ?>
				<?php if (form_error('sign_up_password')) : ?>
					<span class="help-inline">
					<?php echo form_error('sign_up_password'); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>
		
		<div id="confirm_password" class="form-group <?php echo (form_error('sign_up_confirm_password')) ? 'error' : ''; ?>">
			<div id="confirm_password_controls">
				<?php echo form_password(array('name' => 'sign_up_confirm_password', 'id' => 'sign_up_confirm_password_modal', 'value' => set_value('sign_up_confirm_password'), 'class' => 'form-control', 'placeholder' => lang('sign_up_confirm_password'))); ?>
				<?php if (form_error('sign_up_confirm_password')) : ?>
					<span class="alert alert-danger">
					<?php echo form_error('sign_up_confirm_password'); ?>
					</span>
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
				<span class="help-inline">
				<?php echo form_error('sign_up_terms'); ?>
				<?php if (isset($sign_up_terms_error)) : ?>
					<span class="alert alert-danger"><?php echo $sign_up_terms_error; ?></span>
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
        </div>
    </div>
    <div class="clearfix"></div>
    </div>
    </div>
    </div>
    </div>
<?php
	    if(!isset($account))
	    {
		    echo '<script src="'.base_url('/resource/js/sign_up_validation.js').'"></script>';
		    echo '<script>
		    <!-- START : Instant Verification Check -->
		    var _u_noUsername = "'.lang('_u_noUsername').'";
		    var _u_tooShort = "'.lang('_u_tooShort').'";
		    var _u_tooLong = "'.lang('_u_tooLong').'";
		    var _u_inVaildChars = "'.lang('_u_inVaildChars').'";
		    var _u_alreadyExists = "'.lang('_u_alreadyExists').'";
		    var _u_avail = "'.lang('_u_avail').'";
		    
		    var _e_invaild = "'.lang('_e_invaild').'";
		    var _e_vaild = "'.lang('_e_vaild').'";
		    
		    var _p_no = "'.lang('_p_no').'";
		    var _p_tooShort = "'.lang('_p_tooShort').'";
		    var _p_tooLong = "'.lang('_p_tooLong').'";
		    var _p_good = "'.lang('_p_good').'";
		    
		    var _cp_dot = "'.lang('_cp_dot').'";
		    var _cp_noMatch = "'.lang('_cp_noMatch').'";
		    var _cp_match = "'.lang('_cp_match').'";
		    
		    
		    $(document).ready(function(){
			    setUpMessages("_modal");
		    
			    //Notes for Nick
			    //FLOW OF DATA
			    // div id usernameError
			    // div class controls
			    // span class help-inline
			    // span class field error -> This username is already taken
		    });
		    <!-- END : Instant Verification Check -->
	    </script>';
	    }
    ?>
</body>
</html>