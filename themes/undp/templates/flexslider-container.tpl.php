<?php
/**
 * @file
 * Default output for a Flex Slider node.
*/
?>
<div class="flex-nav-container">
  <div class="flexslider-content flexslider clearfix" id="flexslider-<?php print $id; ?>">
    <ul class="slides">
    <?php foreach($items as $item) : ?>
      <li>
        <?php
          if (isset($item['#item']['image'])) {
            print $item['#item']['image'];
          }
          else {
            print render($item);
          }
        ?>
        <?php if(isset($item['#item']['title']) || isset($item['#item']['alt'])) : ?>
          <div class="flex-caption">
            <?php if(!empty($item['#item']['title'])) : ?>
              <h3 class="slide-title"><?php print $item['#item']['title']; ?></h3>
            <?php endif; ?>
            <?php if(!empty($item['#item']['alt'])) : ?>
              <div class="slide-description"><?php print $item['#item']['alt']; ?></div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>
</div>
