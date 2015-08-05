<div id="page">

  <div id="header">
    <div class="page-width">
      <h1 id="branding">
        <?php if ($logo): ?>
          <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
          </a>
        <?php endif; ?>
        <?php if ($site_name): ?>
          <a  id="site-name" href="<?php print $base_path; ?>"><?php print $site_name; ?></a>
        <?php endif; ?>
      </h1>

      <?php if ($page['utility']) { ?>
        <div id="utility">
          <?php print render($page['utility']); ?>
        </div>
      <?php } // end utility ?>

      <?php if ($page['header']) { ?>
          <?php print render($page['header']); ?>
      <?php } // end header ?>

      <?php if ($page['navigation']) { ?>
        <div id="navigation" class="clearfix">
          <?php print render($page['navigation']); ?>
        </div>
      <?php } // end navigation?>

      <?php if ($page['above_content']) { ?>
        <div id="above-content">
          <div class="container">
            <?php print render($page['above_content']); ?>
          </div>
        </div>
      <?php } // end Above Content ?>
    </div>
  </div>

  <div id="main">
    <div class="page-width clearfix">

      <?php if ($messages) { ?>
        <div id="messages">
            <?php print $messages; ?>
        </div>
      <?php } // end messages ?>

      <div id="main-content" class="clearfix">

        <?php if (!$is_front) { ?>
          <?php if (render($tabs)) { ?>
            <div id="tabs">
              <?php print render($tabs); ?>
            </div>
          <?php } // end tabs ?>

          <?php if (strlen($title) > 0) { ?>
            <?php print render($title_prefix); ?>
            <h1 class="page-title"><?php print $title; ?></h1>
            <?php print render($title_suffix); ?>
          <?php } ?>
        <?php } ?>

        <div id="content">
          <?php if ($page['highlighted']) { ?>
            <div id="highlighted">
              <div class="container">
                <?php print render($page['highlighted']); ?>
              </div>
            </div>
          <?php } // end highlighted ?>

          <?php if ($page['help']) { ?>
            <div id="help">
              <?php print render($page['help']); ?>
            </div>
          <?php } // end help ?>

          <?php print render($page['content']); ?>

        </div>

        <?php if ($page['sidebar_second']) { ?>
          <div id="sidebar-second" class="aside">
            <?php print render($page['sidebar_second']); ?>
          </div>
        <?php } // end sidebar_second ?>
      </div>

      <?php if ($page['sidebar_first']) { ?>
        <div id="sidebar-first" class="aside">
          <?php print render($page['sidebar_first']); ?>
        </div>
      <?php } // end sidebar_first ?>

      <?php if ($page['below_content']) { ?>
        <div id="below-content">
          <div class="container">
            <?php print render($page['below_content']); ?>
          </div>
        </div>
      <?php } // end Below Content ?>

    </div>
  </div>

  <div id="footer">
    <div class="page-width">
      <?php print render($page['footer']); ?>
    </div>
  </div>

  <?php if ($page['admin_footer']) { ?>
    <div id="admin-footer">
      <div class="page-width">
        <?php print render($page['admin_footer']); ?>
      </div>
    </div>
  <?php } // end admin_footer ?>

</div>
