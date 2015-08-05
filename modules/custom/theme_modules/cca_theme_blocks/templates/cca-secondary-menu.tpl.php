<nav class="secondary-menu">
  <ul role="navigation" class="nav nav-pills">
    <?php foreach($elements['items'] as $key=>$item): ?>
      <?php print(render($item)); ?>
    <?php endforeach; ?>
  </ul>
</nav>