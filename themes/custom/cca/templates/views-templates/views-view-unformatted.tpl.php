<?php
    $col_count = 0;
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
    <?php if ($col_count == 0): ?><div class="row clearfix"><?php endif; ?>
            <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
                <?php print $row; ?>
            </div>
    <?php $col_count++; ?>
    <?php if ($col_count == 3): ?><?php $col_count = 0; ?></div><?php endif; ?>
<?php endforeach; ?>
