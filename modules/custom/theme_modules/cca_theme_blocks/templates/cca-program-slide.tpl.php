<?php $elements = $variables['elements']; ?>
<?php foreach($elements['#items'] as $item): ?>
<div class="slide">
    <?php print(render($item['img'])); ?>
    <div class="slide-caption">
        <h2><?php print $item['title']; ?></h2>
        <p><?php print $item['description_summary']; ?></p>
        <a href="/taxonomy/term/<?php print $item['tid'] ?>"><button class="btn btn-lg button-primary">Learn More</button></a>                  </div>
</div>
<?php endforeach; ?>