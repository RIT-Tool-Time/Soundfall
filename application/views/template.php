<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <title><?php echo isset($title) ? $title.' - '.lang('website_title') : lang('website_title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <div class="container">
    <nav class="navbar navbar-soundfall" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo anchor(base_url(), lang('website_title'), 'class="navbar-brand"'); ?>
            </div>
            <div class="collapse navbar-collapse" id="navigation">
                <ul class="nav navbar-nav navbar-right">
                    <?php if(!isset($account)): ?>
                    <li><?php echo anchor('about', lang('website_about')); ?></li>
                    <?php endif; ?>
                    <li><?php echo anchor('blog', lang('website_blog')); ?></li>
                    <?php if (!$this->authentication->is_signed_in()) : ?>
                    <li><?php echo anchor('#sign-in-modal', lang('website_sign_in'), array('data-toggle' =>"modal", 'data-target'=> "#sign-in-modal")); ?></li>
                    <?php else: ?>
                    <li></li>
                    <?php endif; ?>
                </ul>

            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <strong>
                    <small>Copyright &copy; <?php echo date('Y'); ?> Rochester Institute of Technology</small>
                </strong>
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
            <h2><?php echo sprintf(lang('sign_in_heading'), lang('website_title')); ?></h2>
        </div>
        <p class="text-center"><?php echo lang('sign_in_dont_have_account') . " " . anchor('account/sign_up', lang('sign_in_sign_up_now')); ?></p>
    </div>
    <div class="modal-body">
    <div class="col-lg-6">
	<?php if ($third_party_auth = $this->config->item('third_party_auth')) : ?>
		<ul>
			<?php foreach($third_party_auth['providers'] as $provider_name => $provider_values) : ?>
				<?php if($provider_values['enabled']) : ?>
				<li class="third_party"><?php echo anchor('account/connect/'.$provider_name, '<img id="'.strtolower($provider_name).'" src="'.base_url(RES_DIR.'/img/auth_icons/'.strtolower($provider_name).'_inactive.png').'" alt="'.sprintf(lang('sign_up_with'), lang('connect_'.strtolower($provider_name))).'" height="64" width="64">' ); ?></li>
				<script type="text/javascript">
						$("#<?php echo strtolower($provider_name); ?>").hover(
						function(){
							$("#<?php echo strtolower($provider_name); ?>").attr('src', '<?php echo base_url(RES_DIR.'/img/auth_icons/'.strtolower($provider_name).'_active.png'); ?>');
							},
						function(){
							$("#<?php echo strtolower($provider_name); ?>").attr('src', '<?php echo base_url(RES_DIR.'/img/auth_icons/'.strtolower($provider_name).'_inactive.png'); ?>');
							});
					</script>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
    </div><!-- /span6 -->
    <div class="col-lg-6">
	<?php echo form_open(uri_string('account/sign_in').($this->input->get('continue') ? '/?continue='.urlencode($this->input->get('continue')) : ''), 'class="form-horizontal"'); ?>
	<?php echo form_fieldset(); ?>
	
		<?php if (isset($sign_in_error)) : ?>
	<div class="alert alert-danger"><?php echo $sign_in_error; ?></div>
		<?php endif; ?>

	<div class="input-group <?php echo (form_error('sign_in_username_email') || isset($sign_in_username_email_error)) ? 'error' : ''; ?>">
		<span class="glyphicon glyphicon-user input-group-addon"></span>
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
		<span class="glyphicon glyphicon-lock input-group-addon"></span>
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
		<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-submit btn-large btn-block', 'content' => lang('sign_in_sign_in'))); ?>
	</div>
	
	<div>
		<label class="checkbox">
			<?php echo form_checkbox(array('name' => 'sign_in_remember', 'id' => 'sign_in_remember', 'value' => 'checked', 'checked' => $this->input->post('sign_in_remember'))); ?>
			<?php echo lang('sign_in_remember_me'); ?>
		</label>
	</div>
	
	<p><?php echo anchor('account/forgot_password', lang('sign_in_forgot_your_password')); ?></p>
	<?php echo form_fieldset_close(); ?>
	<?php echo form_close(); ?> 
    </div>
    <div class="clearfix"></div>
    </div>
</div>
</div>
</div>
    <!-- sign up -->

</body>
</html>
