<?php $elements = $variables['elements']; ?>
<div class="row section-content hidden-xs" id="<?php print $elements['#dom_variables']['section-container-id']; ?>">
    <div class="container">
        <h1>
            <?php print $elements['#dom_variables']['section-container-heading']; ?>
            <?php if($elements['#dom_variables']['more-content']): ?>
                <a class="btn btn-default" href="<?php print($elements['#dom_variables']['more-content']); ?>">See All ></a>
            <?php endif; ?>
        </h1>
        <?php print $elements['#children']; ?>
    </div>
</div> <!-- #section-what-we-do -->