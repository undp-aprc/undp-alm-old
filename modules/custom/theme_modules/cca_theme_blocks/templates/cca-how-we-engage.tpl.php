<div class="row">
    <div class="row-same-height">
        <?php foreach($nodes as $node): ?>
            <?php print(render($node)); ?>
        <?php endforeach; ?>
    </div>
</div>