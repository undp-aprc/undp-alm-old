<div class="project-listing-image-teaser-simple-wrapper">
<?php if ($content['field_project_photos']): ?>
	<div class="photo-container float-left">
		<div class="inner">
			<?php print render($content['field_project_photos']); ?>
		</div>
	</div>
<?php endif; ?>
	<div class="content-wrapper">
		<?php print render($content); ?>
	</div>
	<div class="clearfix"></div>
</div>