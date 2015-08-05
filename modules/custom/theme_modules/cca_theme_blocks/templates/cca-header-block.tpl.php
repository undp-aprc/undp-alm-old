<?php $vars = $variables['elements']['variables']; ?>
<header>
    <div class="container">
        <div class="logo-section">
            <div class="row">
                <div class="col-xs-2 hidden-xs">
                    <a href="/"><img src="/<?php echo $vars['theme_path']; ?>/img/logo.svg" /></a>
                </div>
                <div class="col-xs-9 hidden-xs">
                    <?php print(render(theme('cca_secondary_menu', array('elements' => array('search'=>$variables['elements']['variables']['search']))))); ?>
                </div>
                <div class="col-xs-1 undp-logo hidden-xs">
                    <a href="http://www.undp.org" target="_blank"><img src="/<?php echo $vars['theme_path']; ?>/img/undp-logo.svg" /></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Menu -->
    <nav class="navbar yamm navbar-default primary-menu">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs-block" href="/">
                <img alt="Brand" src="/sites/all/themes/custom/cca/img/logo.svg">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="visible-xs-block"><a href="/">Home</a></li>
                <li class="visible-xs-block"><a href="/about">About Us</a></li>
                <li class="visible-xs-block"></li>
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Signature Programmes <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><div class="yamm-content"><?php print render($vars['menus'][0]); ?></div></li>
                    </ul>
                </li>
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Resources <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="yamm-content"><?php print render($vars['menus'][1]); ?></li>
                    </ul>
                </li>
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Media Centre <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="yamm-content"><?php print render($vars['menus'][2]); ?></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <!-- End Menu -->
</header>