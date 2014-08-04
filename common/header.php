<!DOCTYPE html>
<html class="<?php echo get_theme_option('Style Sheet'); ?>" lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"  />
    <?php if ($description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php endif; ?>

    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Le styles -->

    <?php queue_css_file('bootstrap.min','all',false,'bootstrap-dist/3.2.0/css'); ?>
    <?php queue_css_file(array('docs','style')); ?>
    <style type="text/css">
      body {
        xpadding-top: 60px;
        xpadding-bottom: 40px;
      }
      .sidebar-nav {
        xpadding: 9px 0;
      }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head',array('view'=>$this)); ?>

    <!-- Stylesheets -->
    <?php echo head_css(); ?>

    <!-- JavaScripts -->
    <?php queue_js_file('vendor/modernizr'); ?>
    <?php queue_js_file('vendor/selectivizr', 'javascripts', array('conditional' => '(gte IE 6)&(lte IE 8)')); ?>
    <?php queue_js_file('vendor/respond'); ?>
    <?php queue_js_file('globals'); ?>
    <?php echo head_js(); ?>


<!-- Google Analytics Code -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7574964-3']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- End of Google Analytics Code -->

</head>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass, 'data-spy' => 'scroll', 'data-target' => '.subnav', 'data-offset' => '50')); ?>
    <?php fire_plugin_hook('public_header', array('view'=>$this)); ?>

  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!--
        <?php echo link_to_home_page(theme_header_image(),array('class'=>'navbar-brand')); ?>
        -->
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">CSHL&nbsp;<b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="http://cshl.edu/">Cold Spring Harbor Laboratory</a></li>
              <li><a href="http://library.cshl.edu/">CSHL Library</a></li>
              <li><a href="http://library.cshl.edu/archives">CSHL Archives</a></li>
            </ul>
          </li>
          <?php echo bootstrap_nav_item('Repository','/'); ?>
          <?php echo bootstrap_nav_item('Collections','/collections'); ?>
          <?php echo bootstrap_nav_item('People and Subjects','/items/tags'); ?>
          <?php echo bootstrap_nav_item('Items','/items'); ?>
          <?php echo bootstrap_nav_item('Exhibits','/exhibits'); ?>
          <!-- Test Area -->
          <?php echo substr(public_nav_main(),23,-5); ?>
          <!--
          <li><?php echo link_to_item_search(); ?></li>
          -->
          <?php if($user = current_user()) {
echo '<li class="dropdown">';
echo ' <a href="#" class="dropdown-toggle" data-toggle="dropdown">';
echo html_escape($user->name );
echo '&nbsp;<b class="caret"></b></a>';
echo '<ul class="dropdown-menu">';
            echo '<li><a href="' . url('myomeka') . '">My Selections (Cart)</a></li>';
            echo '<li><a href="' . url('users/logout') . '">Logout</a></li>';
echo '</ul>';
echo '</li>';
            } else {
            echo '<li class="dropdown">';
echo ' <a href="#" class="dropdown-toggle" data-toggle="dropdown">';
echo 'Login';
echo '&nbsp;<b class="caret"></b></a>';
echo '<ul class="dropdown-menu">';
            echo '<li><a href="' . url('users/login') . '">Login</a></li>';
            echo '<li><a href="' . url('myomeka/register') . '">Register</a></li>';
echo '</ul>';
echo '</li>';
              }
            ?> 
          </ul>
          <!-- For non-Solr search
          <form class="navbar-search pull-right" action="<?php echo url('items/browse'); ?>" method="get">
              <input type="text" name="search" class="search-query col-md-2" placeholder="Search">
          </form>
          -->
          <form class="navbar-form navbar-right" role="search" action="<?php echo url('/solr-search/results/interceptor'); ?>" method="get">
            <div class="form-group">

              <input type="text" name="query" class="form-control col-md-2" placeholder="Search">
            </div>
          </form>

        </div><!-- nav-collapse -->
      </div>
    </div>
  </div>


    <div id="wrap">

        <div id="header">
            <?php fire_plugin_hook('public_header_top', array('view'=>$this)); ?>
        </div><!-- end header -->

        <?php echo theme_logo(); ?>
    </div>

<!-- Masthead ===================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1><?php echo option('site_title'); ?></h1>
    <?php if ($description = option('description')): ?>
    <p class="lead"><?php echo $description; ?></p>
    <?php endif; ?>
  </div>
</header>


<div class="container-fluid main-area">
  <div class="row">
    <!-- <div id="content">   -->
<?php fire_plugin_hook('public_content_top', array('view'=>$this)); ?>

<!-- end common/header.php -->
