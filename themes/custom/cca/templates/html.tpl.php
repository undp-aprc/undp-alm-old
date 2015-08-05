<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge, chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php print $head_title; ?></title>
<?php

if (theme_get_setting('toggle_favicon')) {
  $favicon = theme_get_setting('favicon');
} else {
  $favicon = path_to_theme()."/img/favicon.ico";
  kpr($favicon);
} ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php print $favicon; ?>" />
<?php print $styles; ?>
<?php print $scripts; ?>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php
    print $page_top;
    print $page;
    print $page_bottom;
  ?>
  <script src="//use.typekit.net/azx2jrq.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>
</body>
</html>