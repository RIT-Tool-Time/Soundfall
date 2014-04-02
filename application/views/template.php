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
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($this->authentication->is_signed_in()) : ?>
                            <i class="glyphicon glyphicon-user"></i> <?php echo $account->username; ?> <b class="caret"></b></a>
                        <?php else : ?>
                            <i class="glyphicon glyphicon-user"></i> <b class="caret"></b></a>
                        <?php endif; ?>
                        <ul class="dropdown-menu">
                                <?php if ($this->authentication->is_signed_in()) : ?>
                            <li class="dropdown-header"><?php echo lang('website_account_info'); ?></li>
                                <li><?php echo anchor('account/profile', lang('website_profile')); ?></li>
                                <li><?php echo anchor('account/settings', lang('website_account')); ?></li>
                                <?php if ($account->password) : ?>
                                        <li><?php echo anchor('account/password', lang('website_password')); ?></li>
                                <?php endif; ?>
                                <li><?php echo anchor('account/linked_accounts', lang('website_linked')); ?></li>    
                            <?php if ($this->authorization->is_permitted( array('retrieve_users', 'retrieve_roles', 'retrieve_permissions') )) : ?>
                                <li class="divider"></li>
                                <li class="dropdown-header"><?php echo lang('website_admin_panel'); ?></li>
                                <?php if ($this->authorization->is_permitted('retrieve_users')) : ?>
                                    <li><?php echo anchor('admin/manage_users', lang('website_manage_users')); ?></li>
                                <?php endif; ?>
                                <?php if ($this->authorization->is_permitted('retrieve_roles')) : ?>
                                    <li><?php echo anchor('admin/manage_roles', lang('website_manage_roles')); ?></li>
                                <?php endif; ?>
                                <?php if ($this->authorization->is_permitted('retrieve_permissions')) : ?>
                                    <li><?php echo anchor('admin/manage_permissions', lang('website_manage_permissions')); ?></li>
                                <?php endif; ?>
                            <?php endif; ?>
                                    <li class="divider"></li>
                                    <li><?php echo anchor('account/sign_out', lang('website_sign_out')); ?></li>
                            <?php else : ?>
                                    <li><?php echo anchor('account/sign_in', lang('website_sign_in')); ?></li>
                            <?php endif; ?>
                        </ul>
                    </li>
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

</body>
</html>
