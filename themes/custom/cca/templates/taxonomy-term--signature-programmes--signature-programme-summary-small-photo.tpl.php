<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?> view-mode-signature-programme-summary-small-photo">
    <div class="content<?php if ($content['field_program_preview_img']): ?> <?php print('left-sidebar'); ?><?php endif; ?><?php if ($content['projects_of_sub_programme_project_display']): ?> <?php print('right-sidebar'); ?><?php endif; ?>">
        <?php if (!$page): ?>
            <h2><a href="<?php print $term_url; ?>"><?php print $term_name; ?></a></h2>
        <?php endif; ?>
        <?php
            hide($content['field_program_preview_img']);
            hide($content['description']);

        ?>
        <div class="signature-programme-photo">
            <?php if ($content['field_program_preview_img']): ?>
                <?php print render($content['field_program_preview_img']); ?>
            <?php endif; ?>
        </div>
        <div class="signature-programme-description">
            <?php if ($content['description']): ?>
                <?php print render($content['description']); ?>
            <?php endif; ?>
        </div>
        <div class="signature-programme-projects">
            <?php if ($content['projects_of_sub_programme_project_display']): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Related Projects</h3>
                    </div>
                    <div class="panel-body">
                        <?php print render($content['projects_of_sub_programme_project_display']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>