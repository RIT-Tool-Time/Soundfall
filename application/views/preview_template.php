<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Waterfall sharing platform" />
    <meta name="author" content="Jan Dvorak, Chris Blackman, Megan Kusher, Matthew Kinbaum, Tyler Stegall, Andrew Gucwa, Tyler Sposato, Katharine Read" />
    <base href="<?php echo base_url(); ?>"/>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico"/>

    <title><?php echo isset($title) ? $title.' - '.lang('website_title') : lang('website_title'); ?></title>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/bootstrap/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR; ?>/css/cover.css"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"><?php echo anchor('', lang('website_title'), 'class="navbar-brand"'); ?></h3>
              <ul class="nav masthead-nav">
                <li <?php if($page === "home"){ echo 'class="active"';} ?>><a href="<?php echo base_url() ?>">Home</a></li>
                <li <?php if($page === "about"){ echo 'class="active"';} ?>><a href="<?php echo base_url('/about') ?>">About</a></li>
                <li><a href="<?php echo base_url('account/landing') ?>">Account</a></li>
              </ul>
            </div>
          </div>

          <div class="inner cover">
            <?php echo $content; ?>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
  </body>
</html>
