<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?> view-mode-signature-programme-teaser">
    <div class="row">
        <div class="col-sm-6">
            <?php print(render($content['field_program_preview_img']))?>
        </div>
        <div class="col-sm-6">
            <h2><?php print($term_name); ?></h2>
            <p><?php print(render($content['field_summary'])); ?></p>
            <a class="btn btn-warning btn-lg" href="<?php print($term_url); ?>">Learn More</a>
        </div>
    </div>
</div>