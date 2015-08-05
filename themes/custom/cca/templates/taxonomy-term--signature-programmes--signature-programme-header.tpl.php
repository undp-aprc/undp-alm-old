<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?> view-mode-signature-programme-header">
    <div class="term-page-header">
        <h2>Signature Programme <span class="badge">#<?php print($pos); ?></span></h2>
        <?php if ($content['field_program_preview_img']): ?>
            <?php print render($content['field_program_preview_img']); ?>
        <?php endif; ?>
        <h1><?php print ($term_name); ?></h1>
    </div>
</div>