<?php

/**
 * MENUS
 */

/**
 * Overrides theme_menu_tree() for the main menu.
 */

function undp_menu_tree__main_menu($variables) {
  return '<ul class="nav nav-inline">' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_tree() for the utility menu.
 */

function undp_menu_tree__menu_utility_navigation($variables) {
  return '<ul id="utility-nav" class="nav nav-inline">' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_tree() for the local menu.
 */

function undp_menu_tree__menu_block__4($variables) {
  return '<ul class="nav nav-stacked">' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_tree() for the footer menu.
 */

function undp_menu_tree__menu_footer_navigation($variables) {
  return '<ul id="footer-nav" class="nav nav-inline">' . $variables['tree'] . '</ul>';
}

/**
 * Implements hook_preprocess_menu_link()
 */

function undp_preprocess_menu_link(&$vars) {
  /* Set shortcut variables. Hooray for less typing! */
  $menu = $vars['element']['#original_link']['menu_name'];
  $mlid = $vars['element']['#original_link']['mlid'];
  $item_classes = &$vars['element']['#attributes']['class'];
  $link_classes = &$vars['element']['#localized_options']['attributes']['class'];

  /* Add global classes to all menu links */
  $item_classes[] = 'nav-item';
  $link_classes[] = 'nav-link';
}

/**
 * FIELDS
 */

/**
 * Implements hook_preprocess_field()
 */

function undp_preprocess_field(&$vars) {
  /* Set shortcut variables. Hooray for less typing! */
  $field = $vars['element']['#field_name'];
  $bundle = $vars['element']['#bundle'];
  $mode = $vars['element']['#view_mode'];
  $classes = &$vars['classes_array'];
  $title_classes = &$vars['title_attributes_array']['class'];
  $content_classes = &$vars['content_attributes_array']['class'];
  $item_classes = array();

  /* Global field styles */
  $classes[] = 'field-wrapper';
  $title_classes[] = 'field-label';
  $content_classes[] = 'field-items';
  $item_classes[] = 'field-item';

  /* Uncomment the lines below to see variables you can use to target a field */
  // print '<strong>Field:</strong> ' . $field . '<br/>';
  // print '<strong>Bundle:</strong> ' . $bundle  . '<br/>';
  // print '<strong>Mode:</strong> ' . $mode .'<br/>';

  switch ($field) {
    case 'field_contact_name':
      $vars['theme_hook_suggestions'][] = 'field__custom_h3';
      $item_classes[] = 'collapse';
      break;
    case 'field_contact_title':
    case 'field_contact_affiliation':
    case 'field_contact_email':
    case 'field_contact_url':
      $item_classes[] = 'collapse';
      break;
    case 'field_download':
      $vars['theme_hook_suggestions'][] = 'field__custom_download';
      break;
  }

  // Apply odd or even classes along with our custom classes to each item */
  foreach ($vars['items'] as $delta => $item) {
    $item_classes[] = $delta % 2 ? 'odd' : 'even';
    $vars['item_attributes_array'][$delta]['class'] = $item_classes;
  }
}

/**
 * NODES
 */

/**
 * Implements hook_preprocess_node()
 */

function undp_preprocess_node(&$vars) {
  
  /* Set shortcut variables. Hooray for less typing! */
  $type = $vars['type'];
  $mode = $vars['view_mode'];
  $classes = &$vars['classes_array'];
  $title_classes = &$vars['title_attributes_array']['class'];
  $content_classes = &$vars['content_attributes_array']['class'];

  /* If Project Image Teasers have a video, hide the photo. */
  if( $type == 'project' && $mode == 'image_teaser' && isset($vars['content']['field_featured_video'])) {
    unset($vars['content']['field_project_photos']);
  }

  if ($type = 'project' && $mode == 'image_teaser_simple') {
	$vars['theme_hook_suggestions'][] = 'node__project__image_teaser_simple'; //Create theme hook suggestion for image teaser simple view mode
	
	// Only want to display 1 photo per simple image teaser
	foreach($vars['content']['field_project_photos'] as $key=>$array) {
		if (is_integer($key)) {
			if ($key > 0) {
				hide($vars['content']['field_project_photos'][$key]);
			}
		}
	}
  } 
}

/**
 * Custom function
 * Checks to see if this page is a country and returns the region.
 */

function _undp_is_country_page() {
  if(arg(0) == "taxonomy" && arg(1) == "term") {
    // Check if this is a Region term.
    $term = taxonomy_term_load(arg(2));
    $vid = $term->vid;
    if ($vid == 5 && $parents = taxonomy_get_parents($term->tid)) {
      return $parents;
    }
  }
}

/**
 * Custom function
 * Checks to see if this page is a region.
 */

function _undp_is_region_page() {
  if(arg(0) == "taxonomy" && arg(1) == "term") {
    // Check if this is a Region term.
    $term = taxonomy_term_load(arg(2));
    $vid = $term->vid;
    if ($vid == 5) {
      return TRUE;
    }
    return FALSE;
  }
}



/**
 * PAGE
 */

function undp_page_alter(&$page) {
  // Check to see if we're on a country page
  if(_undp_is_region_page()) {
    // Move fields to the sidebar
    $term_content = &$page['content']['system_main']['content']['term_heading']['term'];
    if(!isset($page['sidebar_second'])) {
      $page['sidebar_second'] = array();
    }
    if (isset($term_content['field_development_programming_li'])) {
      array_unshift($page['sidebar_second'], $term_content['field_development_programming_li']);
      unset($term_content['field_development_programming_li']);
    }
    if (isset($term_content['field_country_region_websites'])) {
      array_unshift($page['sidebar_second'], $term_content['field_country_region_websites']);
      unset($term_content['field_country_region_websites']);
    }
    if (isset($term_content['description'])) {
      array_unshift($page['sidebar_second'], $term_content['description']);
      unset($term_content['description']);
    }
  }
}

function undp_preprocess_page(&$vars) {
	drupal_add_library('system', 'ui.accordion');
    drupal_add_library('system', 'ui.tabs');
  // Remove the main node from the front page.
  if($vars['is_front']) {
    unset($vars['page']['content']['system_main']);
  }

  // Check to see if we're on a country page.
  if($parents = _undp_is_country_page()) {
    $term = taxonomy_term_load(arg(2));
    $vars['title_prefix'][]['#markup'] = '<div class="country-header">';

    // Move the flag to the header
    $term_content = &$vars['page']['content']['system_main']['content']['term_heading']['term'];
    $flag = &$term_content['field_flag'];
    $flag[0]['#item']['attributes']['class'][] = 'country-flag';
    $flag[0]['#item']['alt'] = $term->name . ' flag';
    $vars['title_prefix'][] = $flag[0];
    $flag = null;

    // Add the region to the header
    $parent = array_pop($parents);
    $region_name = $parent->name;
    $region_path = drupal_get_path_alias('taxonomy/term/' . $parent->tid);
    $vars['title_suffix']['link'] = array(
      '#theme' => 'link',
      '#text' => $region_name,
      '#path' => $region_path,
      '#options' => array(
        'attributes' => array('class' => array('country-region')),
        //REQUIRED:
        'html' => FALSE,
       ),
    );

    $vars['title_suffix'][]['#markup'] = '</div>';
  }

    if ($vars['node']->type == 'group_spaces') {
        $vars['theme_hook_suggestions'][] = 'page__group_spaces';
    }
}

/**
 * BLOCKS
 */

/**
 * Implements hook_block_view_alter()
 */

function undp_block_view_alter(&$data, $block) {
  $block_id = $block->module . '-' . $block->delta;
  $content = &$data['content'];
  // print $block_id . '<br/>';

  switch ($block_id) {
    case 'undp_blocks-project_menu_block':
      $content['#attributes']['class'][] = 'nav';
      $content['#attributes']['class'][] = 'nav-stacked';
      break;
  }
}

/**
 * Implements hook_preprocess_block()
 */

function undp_preprocess_block(&$vars) {
  /* Set shortcut variables. Hooray for less typing! */
  $block_id = $vars['block']->module . '-' . $vars['block']->delta;
  $classes = &$vars['classes_array'];
  $title_classes = &$vars['title_attributes_array']['class'];
  $content_classes = &$vars['content_attributes_array']['class'];

  /* Add global classes to all blocks */
  $title_classes[] = 'block-title';
  $content_classes[] = 'block-content';

  /* Uncomment the line below to see variables you can use to target a block */
  // print $block_id . '<br/>';

  /* Add classes based on the block delta. */
  switch ($block_id) {
    /* System Navigation block */
    case 'menu_block-1':
    case 'menu_block-2':
    case 'menu_block-3':
    case 'menu_block-4':
    case 'search_form':
      $title_classes[] = 'element-invisible';
      break;
    case 'views-featured_documents-block':
    case 'views-featured_videos-block':
      $classes[] = 'featured-resources';
      break;
    case 'views-list_of_sub_programmes-block':
        $title_classes[] = 'sub-title';
        break;
    /* Where we Work block */
    case 'undp_map-undp_main_map':
        $title_classes[] = 'block-title-collapsed';
        break;
  }
}

/**
 * FORMS
 */

/**
 * Implements hook_form_alter
 */

function undp_form_alter(&$form, &$form_state, $form_id) {
  /* Add placeholder text to a form */
  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#attributes']['placeholder'] = "Enter a search term…";
  }
}

function undp_preprocess_eva_display_entity_view(&$variables)
{
    $variables['attributes']['id'][] = 'Hello';
}