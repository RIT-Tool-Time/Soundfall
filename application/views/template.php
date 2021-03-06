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
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="resource/js/jquery.min.js"><\/script>')</script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/css/style.css"/>
    <script src="<?php echo base_url().RES_DIR; ?>/bootstrap/js/bootstrap.min.js"></script>
    <?php
    if($this->load->is_loaded('form_validation'))
    {
        //load bootstrapValidator
        echo '<link type="text/css" rel="stylesheet" href="'.  base_url(RES_DIR.'/css/bootstrapValidator.min.css') .'" />';
        echo '<script src="'. base_url(RES_DIR.'/js/bootstrapValidator.min.js') .'"></script>';
    }
    ?>
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
                    	<li class="dropdown">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="account-name"><?php echo $account->username; ?></span><img class="img-circle" src="<?php echo get_avatar($account->id, 40, 40);?>" width="40" height="40" alt="profile image" /></a>
			    <ul class="dropdown-menu">
				    <li><?php echo anchor('account/profile', lang('website_profile')); ?></li>
				    <li class="divider"></li>
				    <li><?php echo anchor('account/settings', lang('website_account')); ?></li>
				    <?php if ($account->password) : ?>
				    <li class="divider"></li>
				    <li><?php echo anchor('account/password', lang('website_password')); ?></li>
				    <?php endif; ?>
				    <li class="divider"></li>
				    <li><?php echo anchor('account/linked_accounts', lang('website_linked')); ?></li>
				    <?php if ($this->authorization->is_permitted( array('retrieve_users', 'retrieve_roles', 'retrieve_permissions') )) : ?>
					<li class="divider"></li>
					<li class="dropdown-header"><strong><?php echo lang('website_admin_panel'); ?></strong></li>
					<?php if ($this->authorization->is_permitted('retrieve_users')) : ?>
					    <li class="divider"></li>
					    <li><?php echo anchor('admin/manage_users', lang('website_manage_users')); ?></li>
					<?php endif; ?>
					<?php if ($this->authorization->is_permitted('retrieve_roles')) : ?>
					    <li class="divider"></li>
					    <li><?php echo anchor('admin/manage_roles', lang('website_manage_roles')); ?></li>
					<?php endif; ?>
					<?php if ($this->authorization->is_permitted('retrieve_permissions')) : ?>
					    <li class="divider"></li>
					    <li><?php echo anchor('admin/manage_permissions', lang('website_manage_permissions')); ?></li>
					<?php endif; ?>
					<?php if ($this->authorization->is_permitted('manage_tags')) : ?>
					    <li class="divider"></li>
					    <li><?php echo anchor('admin/tags', lang('website_manage_tags')); ?></li>
					<?php endif; ?>
				    <?php endif; ?>
				    <li class="divider"></li>
				    <li><?php echo anchor('account/sign_out', lang('website_sign_out')); ?></li>
			    </ul>
			</li>
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
    <div class="modal-dialog modal-xl">
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
		<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-submit', 'content' => lang('sign_in_sign_in'))); ?>
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
    <div class="modal-dialog modal-xl">
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
			    <?php echo form_error('sign_up_username'); ?>
			    <?php if (isset($sign_up_username_error)) : ?>
				<span class="alert alert-danger"><?php echo $sign_up_username_error; ?></span>
			    <?php endif; ?>
			<?php endif; ?>
		    </div>
		</div>
	
		<div id="email" class="form-group <?php echo (form_error('sign_up_email') || isset($sign_up_email_error)) ? 'error' : ''; ?>">
		    <div id="email_controls">
			<?php echo form_input(array('name' => 'sign_up_email', 'id' => 'sign_up_email_modal', 'value' => set_value('sign_up_email'), 'maxlength' => '160', 'class' => 'form-control', 'placeholder'=> lang('sign_up_email'))); ?>
			<?php if (form_error('sign_up_email') || isset($sign_up_email_error)) : ?>
			    <?php echo form_error('sign_up_email'); ?>
			    <?php if (isset($sign_up_email_error)) : ?>
				<span class="alert alert-danger"><?php echo $sign_up_email_error; ?></span>
			    <?php endif; ?>
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
		
		<div id="password_confirm" class="form-group <?php echo (form_error('sign_up_password_confirm')) ? 'error' : ''; ?>">
			<div id="password_confirm_controls">
				<?php echo form_password(array('name' => 'sign_up_password_confirm', 'id' => 'sign_up_password_confirm_modal', 'value' => set_value('sign_up_password_confirm'), 'class' => 'form-control', 'placeholder' => lang('sign_up_password_confirm'))); ?>
				<?php if (form_error('sign_up_password_confirm')) : ?>
				    <span class="alert alert-danger">
					<?php echo form_error('sign_up_password_confirm'); ?>
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
			    <?php echo form_error('sign_up_terms'); ?>
			    <?php if (isset($sign_up_terms_error)) : ?>
				<span class="alert alert-danger"><?php echo $sign_up_terms_error; ?></span>
			    <?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="col-md-6">
			<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-submit', 'content' => '<i class="glyphicon glyphicon-pencil"></i> '.lang('sign_up_create_my_account'))); ?>
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
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://stats.freedombase.net/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 3]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://stats.freedombase.net/piwik.php?idsite=3" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>
