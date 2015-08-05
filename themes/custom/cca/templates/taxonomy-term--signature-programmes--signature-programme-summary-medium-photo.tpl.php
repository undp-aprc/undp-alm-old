<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?> view-mode-signature-programme-summary-medium-photo">
    <div class="content<?php if ($content['field_program_preview_img']): ?> <?php print('left-sidebar'); ?><?php endif; ?><?php if ($content['projects_of_sub_programme_project_display']): ?> <?php print('right-sidebar'); ?><?php endif; ?>">
        <?php if ($content['field_program_preview_img']): ?>
        <div class="signature-programme-photo">
            <?php print render($content['field_program_preview_img']); ?>
        </div>
        <?php endif; ?>
        <div class="signature-programme-description">
            <?php if ($content['description']): ?>
                <?php print render($content['description']); ?>
            <?php endif; ?>
        </div>
        <div class="signature-programme-projects">
            <?php if ($content['projects_of_sub_programme_project_display']): ?>
                <?php print render($content['projects_of_sub_programme_project_display']); ?>
            <?php endif; ?>
        </div>
    </div>
</div>