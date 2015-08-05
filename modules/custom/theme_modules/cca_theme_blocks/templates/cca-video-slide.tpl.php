<?php foreach($nodes as $index=>$node): ?>
    <?php $new_slide = (($index) % 3 == 0) ? true : false; ?>
    <?php $end_slide = (($index + 1) % 3 == 0) ? true : false; ?>
    <?php if ($new_slide): ?>
        <div class="slide">
    <?php endif; ?>
        <?php print(render($node)); ?>
    <?php if ($end_slide): ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
</div>