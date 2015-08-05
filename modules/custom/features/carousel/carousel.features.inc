<?php
/**
 * @file
 * carousel.features.inc
 */

/**
 * Implements hook_field_default_field_bases().
 */
function carousel_field_default_field_bases() {
  $field_bases = array();

  // Exported field_base: 'body'
  $field_bases['body'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(
      0 => 'node',
    ),
    'field_name' => 'body',
    'foreign keys' => array(
      'format' => array(
        'columns' => array(
          'format' => 'format',
        ),
        'table' => 'filter_format',
      ),
    ),
    'indexes' => array(
      'format' => array(
        0 => 'format',
      ),
    ),
    'locked' => 0,
    'module' => 'text',
    'settings' => array(),
    'translatable' => 1,
    'type' => 'text_with_summary',
  );

  // Exported field_base: 'field_carousel_photo'
  $field_bases['field_carousel_photo'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(),
    'field_name' => 'field_carousel_photo',
    'foreign keys' => array(
      'fid' => array(
        'columns' => array(
          'fid' => 'fid',
        ),
        'table' => 'file_managed',
      ),
    ),
    'indexes' => array(
      'fid' => array(
        0 => 'fid',
      ),
    ),
    'locked' => 0,
    'module' => 'image',
    'settings' => array(
      'default_image' => 0,
      'uri_scheme' => 'public',
    ),
    'translatable' => 0,
    'type' => 'image',
  );

  // Exported field_base: 'field_internal_url'
  $field_bases['field_internal_url'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(),
    'field_name' => 'field_internal_url',
    'foreign keys' => array(),
    'indexes' => array(),
    'locked' => 0,
    'module' => 'link',
    'settings' => array(
      'attributes' => array(
        'class' => '',
        'rel' => '',
        'target' => 'default',
      ),
      'display' => array(
        'url_cutoff' => 80,
      ),
      'enable_tokens' => 1,
      'title' => 'optional',
      'title_maxlength' => 128,
      'title_value' => '',
      'url' => 0,
    ),
    'translatable' => 0,
    'type' => 'link_field',
  );

  // Exported field_base: 'field_project'
  $field_bases['field_project'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(),
    'field_name' => 'field_project',
    'foreign keys' => array(
      'nid' => array(
        'columns' => array(
          'nid' => 'nid',
        ),
        'table' => 'node',
      ),
    ),
    'indexes' => array(
      'nid' => array(
        0 => 'nid',
      ),
    ),
    'locked' => 0,
    'module' => 'node_reference',
    'settings' => array(
      'referenceable_types' => array(
        'carousel' => 0,
        'internal_documentation' => 0,
        'page' => 0,
        'partner' => 0,
        'project' => 'project',
        'resource' => 0,
        'rotating_feature' => 0,
        'video' => 0,
        'webform' => 0,
      ),
      'view' => array(
        'args' => array(),
        'display_name' => '',
        'view_name' => '',
      ),
    ),
    'translatable' => 1,
    'type' => 'node_reference',
  );

  return $field_bases;
}

/**
 * Implements hook_field_default_field_instances().
 */
function carousel_field_default_field_instances() {
  $field_instances = array();

  // Exported field_instance: 'node-carousel-body'
  $field_instances['node-carousel-body'] = array(
    'bundle' => 'carousel',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => 'Please enter a short description (less than 30 words) for this carousel item. It will be displayed as an overlay on the photo.',
    'display' => array(
      'default' => array(
        'label' => 'hidden',
        'module' => 'text',
        'settings' => array(),
        'type' => 'text_default',
        'weight' => 0,
      ),
      'teaser' => array(
        'label' => 'hidden',
        'module' => 'text',
        'settings' => array(
          'trim_length' => 600,
        ),
        'type' => 'text_summary_or_trimmed',
        'weight' => 0,
      ),
    ),
    'ds_extras_field_template' => '',
    'entity_type' => 'node',
    'field_name' => 'body',
    'label' => 'Caption',
    'required' => 1,
    'settings' => array(
      'display_summary' => 1,
      'text_processing' => 1,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'rows' => 20,
        'summary_rows' => 5,
      ),
      'type' => 'text_textarea_with_summary',
      'weight' => 3,
    ),
  );

  // Exported field_instance: 'node-carousel-field_carousel_photo'
  $field_instances['node-carousel-field_carousel_photo'] = array(
    'bundle' => 'carousel',
    'deleted' => 0,
    'description' => 'Please upload a photo to display in the carousel. It is best if this photo is \'landscape\' aspect ratio of approximately 4:3 (Eg. 640 x 480 pixels). You may use photos with a different aspect ratio, but they may be cropped in ways that are unpredictable.',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'image',
        'settings' => array(
          'image_link' => '',
          'image_style' => 'landscape_photo_640_x_480',
        ),
        'type' => 'image',
        'weight' => 1,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'ds_extras_field_template' => '',
    'entity_type' => 'node',
    'field_name' => 'field_carousel_photo',
    'label' => 'Carousel Photo',
    'required' => 1,
    'settings' => array(
      'alt_field' => 0,
      'default_image' => 0,
      'file_directory' => 'projects/carousel-images',
      'file_extensions' => 'png gif jpg jpeg',
      'max_filesize' => '',
      'max_resolution' => '',
      'min_resolution' => '',
      'title_field' => 0,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'image',
      'settings' => array(
        'preview_image_style' => 'landscape_photo_640_x_480',
        'progress_indicator' => 'throbber',
      ),
      'type' => 'image_image',
      'weight' => 2,
    ),
  );

  // Exported field_instance: 'node-carousel-field_internal_url'
  $field_instances['node-carousel-field_internal_url'] = array(
    'bundle' => 'carousel',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => 'Please specify a node or path in the ALM that this carousel item will navigate to when clicked. Note: the difference between the node reference field and this field is that the node reference field determines where the carousel item will be displayed. This link field determines the destination when a user clicks an item in the carousel.',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'link',
        'settings' => array(),
        'type' => 'link_url',
        'weight' => 3,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'ds_extras_field_template' => '',
    'entity_type' => 'node',
    'field_name' => 'field_internal_url',
    'label' => 'Internal URL',
    'required' => 1,
    'settings' => array(
      'attributes' => array(
        'class' => '',
        'configurable_title' => 0,
        'rel' => '',
        'target' => 'default',
        'title' => '',
      ),
      'display' => array(
        'url_cutoff' => 80,
      ),
      'enable_tokens' => 1,
      'rel_remove' => 'default',
      'title' => 'none',
      'title_maxlength' => 128,
      'title_value' => '',
      'url' => 0,
      'user_register_form' => FALSE,
      'validate_url' => 1,
    ),
    'widget' => array(
      'active' => 0,
      'module' => 'link',
      'settings' => array(),
      'type' => 'link_field',
      'weight' => 5,
    ),
  );

  // Exported field_instance: 'node-carousel-field_project'
  $field_instances['node-carousel-field_project'] = array(
    'bundle' => 'carousel',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => 'You must link this item to an existing project that has been created in the UNDP-ALM. ',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'node_reference',
        'settings' => array(),
        'type' => 'node_reference_default',
        'weight' => 2,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'ds_extras_field_template' => '',
    'entity_type' => 'node',
    'field_name' => 'field_project',
    'label' => 'Project',
    'required' => 1,
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'node_reference',
      'settings' => array(
        'autocomplete_match' => 'contains',
        'autocomplete_path' => 'node_reference/autocomplete',
        'references_dialog_add' => 0,
        'references_dialog_edit' => 0,
        'references_dialog_search' => 0,
        'references_dialog_search_view' => '',
        'size' => 60,
      ),
      'type' => 'node_reference_autocomplete',
      'weight' => 1,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Caption');
  t('Carousel Photo');
  t('Internal URL');
  t('Please enter a short description (less than 30 words) for this carousel item. It will be displayed as an overlay on the photo.');
  t('Please specify a node or path in the ALM that this carousel item will navigate to when clicked. Note: the difference between the node reference field and this field is that the node reference field determines where the carousel item will be displayed. This link field determines the destination when a user clicks an item in the carousel.');
  t('Please upload a photo to display in the carousel. It is best if this photo is \'landscape\' aspect ratio of approximately 4:3 (Eg. 640 x 480 pixels). You may use photos with a different aspect ratio, but they may be cropped in ways that are unpredictable.');
  t('Project');
  t('You must link this item to an existing project that has been created in the UNDP-ALM. ');

  return $field_instances;
}

/**
 * Implements hook_image_default_styles().
 */
function carousel_image_default_styles() {
  $styles = array();

  // Exported image style: landscape_photo_640_x_480.
  $styles['landscape_photo_640_x_480'] = array(
    'name' => 'landscape_photo_640_x_480',
    'label' => 'Landscape Photo (640 x 480)',
    'effects' => array(
      10 => array(
        'label' => 'Scale and crop',
        'help' => 'Scale and crop will maintain the aspect-ratio of the original image, then crop the larger dimension. This is most useful for creating perfectly square thumbnails without stretching the image.',
        'effect callback' => 'image_scale_and_crop_effect',
        'dimensions callback' => 'image_resize_dimensions',
        'form callback' => 'image_resize_form',
        'summary theme' => 'image_resize_summary',
        'module' => 'image',
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 640,
          'height' => 480,
        ),
        'weight' => 1,
      ),
    ),
  );

  return $styles;
}

/**
 * Implements hook_node_info().
 */
function carousel_node_info() {
  $items = array(
    'carousel' => array(
      'name' => t('Carousel'),
      'base' => 'node_content',
      'description' => t('Create carousels to place in blocks at top of project portal pages (Eg. NAP-LDC project portal page).'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
