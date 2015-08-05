<?php

function cca_page_alter(&$page) {
    $theme_path = drupal_get_path('theme','cca');
    /* Add global JS files */
    drupal_add_js($theme_path.'/js/plugins/jquery.matchHeight-min.js', array('type'=>'file','scope'=>'footer','every_page'=>TRUE));
    drupal_add_js($theme_path.'/js/main.js', array('type'=>'file','scope'=>'footer','every_page'=>TRUE));
    
    /* Make search form and menu blocks available to header template and unset from page array */
    $page['header']['cca_theme_blocks_header']['variables']['search'] =  $page['header']['search_form'];
    
    $page['header']['cca_theme_blocks_header']['variables']['menus'][] = $page['menu_1'];
    $page['header']['cca_theme_blocks_header']['variables']['menus'][] = $page['menu_2'];
    $page['header']['cca_theme_blocks_header']['variables']['menus'][] = $page['menu_3'];
    
    unset($page['header']['search_form'], $page['menu_1'], $page['menu_2'], $page['menu_3']);
}

/* Move scripts to bottom (best practice) and update jquery to later version for better plugin support */
function cca_js_alter(&$javascript) {
    if ($javascript['misc/jquery.js']) {
        $javascript['misc/jquery.js']['version'] = '1.10.2';
        $javascript['misc/jquery.js']['data'] = drupal_get_path('theme','cca').'/js/vendor/jquery-1.10.2.min.js';
    }
    foreach($javascript as &$script) {
        $script['scope'] = 'footer';
    }
}

function cca_css_alter(&$css) {
    // Remove default system CSS on custom theme
    if ($css['modules/system/system.theme.css']) {
        unset($css['modules/system/system.theme.css']);
        unset($css['modules/system/system.menus.css']);
    }
}

function cca_process_node(&$variables) {
    // Load jQuery UI tabs on project page
    if($variables['type'] == 'project') {
        drupal_add_library('system','ui.tabs');
        drupal_add_js(drupal_get_path('theme','cca').'/js/tabs.js');
    }
}

function cca_preprocess_node(&$variables) {
    if ($variables['type'] == 'project' || $variables['type'] == 'news' || $variables['type'] == 'resource' || $variables['type'] == 'event') {
        $function = 'cca_preprocess_node__'.$variables['type'];
        if (function_exists($function)) {
            $function($variables);
        }
    }
}

function cca_preprocess_node__event(&$variables) {
    if ($startdate = $variables['field_event_date'][0]['value']) {
        $timestamp = strtotime($startdate);
        $date['unix_timestamp'] = $timestamp;
        $date['day'] = date('j', $timestamp);
        $date['month'] = date('M', $timestamp);
        $date['year'] = date('Y', $timestamp);
        $variables['date_parts'] = $date;
    }
}

function cca_preprocess_node__project(&$variables) {
    $variables['active_groups'] = array();
    $display_groups = $variables['elements']['#groups'];
    foreach ($display_groups as $key=>$group) { // Iterate through all the available field groups
        if ($key == 'group_overview' || $key == 'group_overview_right') {
            $variables['active_groups']['group_summary'] = TRUE;
            break;
        }
        $active_group = FALSE;
        foreach($group->children as $field) { // Iterate through the field names which are assigned to the group
            if (count($variables['content'][$field]) > 0) {
                $variables['active_groups'][$key] = TRUE; // After checking all the fields in the group, if any have content mark this group as active so a tab will appear in the rendered page.
            }
        }
    }
}

function cca_preprocess_node__news(&$variables) {
    if ($variables['field_contact_details'][0]['safe_value'] == '') {
        unset($variables['content']['field_contact_details']);
    }
}

function cca_preprocess_node__resource(&$variables) {
    if ($variables['content']['field_download']) {
        $variables['content']['field_download']['#theme'] = 'download_button';
    }
}

function cca_preprocess_page(&$variables) {
    $variables['title_prefix'] = '<h1>';
    $variables['title_suffix'] = '</h1>';
    
    if ($variables['is_front']) {
        $variables['title_prefix'] = '<h1 class="hidden">';
    };

    if ($variables['node']) {
        if (!node_access('update',$variables['node'])) {
            unset($variables['tabs']);
        }
    }
}

function cca_preprocess_taxonomy_term(&$variables) {
    $variables['tree_top'] = false;
    if ($term = $variables['elements']['#term']) {
        $parent = taxonomy_get_parents($term->tid);
        if (empty($parent)) {
            $variables['tree_top'] = true;
        }
    }
    $terms = taxonomy_get_tree(11, 0, 1);
    $i = 0;
    foreach ($terms as $term=>$array) {
        if ($variables['tid'] == $array->tid) {
            $variables['pos'] = $i + 1;
            break;
        } else {
            $i++;
        }
    }
}

function cca_date_nav_title($params) {
    $granularity = $params['granularity'];
    $view = $params['view'];
    $date_info = $view->date_info;
    $link = !empty($params['link']) ? $params['link'] : FALSE;
    $format = !empty($params['format']) ? $params['format'] : NULL;
    switch ($granularity) {
        case 'year':
            $title = $date_info->year;
            $date_arg = $date_info->year;
            break;
        case 'month':
            $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F Y' : 'F');
            $title = date_format_date($date_info->min_date, 'custom', $format);
            $date_arg = $date_info->year . '-' . date_pad($date_info->month);
            break;
        case 'day':
            $format = !empty($format) ? $format : (empty($date_info->mini) ? 'l, F j, Y' : 'l, F j');
            $title = date_format_date($date_info->min_date, 'custom', $format);
            $date_arg = $date_info->year . '-' . date_pad($date_info->month) . '-' . date_pad($date_info->day);
            break;
        case 'week':
            $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F j, Y' : 'F j');
            $title = t('Week of @date', array('@date' => date_format_date($date_info->min_date, 'custom', $format)));
            $date_arg = $date_info->year . '-W' . date_pad($date_info->week);
            break;
    }
    if (!empty($date_info->mini) || $link) {
        // Month navigation titles are used as links in the mini view.
        $attributes = array('title' => t('View full page month'));
        $url = date_pager_url($view, $granularity, $date_arg, TRUE);
        return l($title, $url, array('attributes' => $attributes));
    }
    else {
        return $title;
    }
}

/* Theme function overrides */
/* ************************ */

function cca_select($variables) {
    $element = $variables['element'];
    element_set_attributes($element, array('id', 'name', 'size'));
    _form_set_class($element, array('form-select', 'form-control'));

    return '<select' . drupal_attributes($element['#attributes']) . '>' . form_select_options($element) . '</select>';
}

function cca_pager($variables) {
    $tags = $variables['tags'];
    $element = $variables['element'];
    $parameters = $variables['parameters'];
    $quantity = $variables['quantity'];
    global $pager_page_array, $pager_total;

    // Calculate various markers within this pager piece:
    // Middle is used to "center" pages around the current page.
    $pager_middle = ceil($quantity / 2);
    // current is the page we are currently paged to
    $pager_current = $pager_page_array[$element] + 1;
    // first is the first page listed by this pager piece (re quantity)
    $pager_first = $pager_current - $pager_middle + 1;
    // last is the last page listed by this pager piece (re quantity)
    $pager_last = $pager_current + $quantity - $pager_middle;
    // max is the maximum page number
    $pager_max = $pager_total[$element];
    // End of marker calculations.

    // Prepare for generation loop.
    $i = $pager_first;
    if ($pager_last > $pager_max) {
        // Adjust "center" if at end of query.
        $i = $i + ($pager_max - $pager_last);
        $pager_last = $pager_max;
    }
    if ($i <= 0) {
        // Adjust "center" if at start of query.
        $pager_last = $pager_last + (1 - $i);
        $i = 1;
    }
    // End of generation loop preparation.

    $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
    $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
    $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
    $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

    if ($pager_total[$element] > 1) {
        if ($li_first) {
            $items[] = array(
                'class' => array('pager-first'),
                'data' => $li_first,
            );
        }
        if ($li_previous) {
            $items[] = array(
                'class' => array('pager-previous'),
                'data' => $li_previous,
            );
        }

        // When there is more than one page, create the pager list.
        if ($i != $pager_max) {
            if ($i > 1) {
                $items[] = array(
                    'class' => array('pager-ellipsis'),
                    'data' => '…',
                );
            }
            // Now generate the actual pager piece.
            for (; $i <= $pager_last && $i <= $pager_max; $i++) {
                if ($i < $pager_current) {
                    $items[] = array(
                        'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
                    );
                }
                if ($i == $pager_current) {
                    $items[] = array(
                        'class' => array('active'),
                        'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($pager_current), 'parameters' => $parameters)),
                    );
                }
                if ($i > $pager_current) {
                    $items[] = array(
                        'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
                    );
                }
            }
            if ($i < $pager_max) {
                $items[] = array(
                    'class' => array('pager-ellipsis'),
                    'data' => '…',
                );
            }
        }
        // End generation.
        if ($li_next) {
            $items[] = array(
                'class' => array('pager-next'),
                'data' => $li_next,
            );
        }
        if ($li_last) {
            $items[] = array(
                'class' => array('pager-last'),
                'data' => $li_last,
            );
        }
        return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
            'items' => $items,
            'attributes' => array('class' => array('pagination')),
        ));
    }
}

function cca_menu_local_task($variables) {
    $link = $variables['element']['#link'];
    $link_text = $link['title'];

    if (!empty($variables['element']['#active'])) {
        // Add text to indicate active tab for non-visual users.
        $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

        // If the link does not contain HTML already, check_plain() it now.
        // After we set 'html'=TRUE the link will not be sanitized by l().
        if (empty($link['localized_options']['html'])) {
            $link['title'] = check_plain($link['title']);
        }
        $link['localized_options']['html'] = TRUE;
        $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
    }

    return '<li' . (!empty($variables['element']['#active']) ? ' class="active"' : '') . '>' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
}

function cca_menu_local_tasks(&$variables) {
    $output = '';

      if (!empty($variables['primary'])) {
        $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
        $variables['primary']['#prefix'] .= '<nav class="menu-local-tasks">';
        $variables['primary']['#prefix'] .= '<ul class="nav nav-pills" role="navigation">';
        $variables['primary']['#suffix'] = '</ul>';
        $variables['primary']['#suffix'] .= '</nav>';
        $output .= drupal_render($variables['primary']);
      }
      if (!empty($variables['secondary'])) {
        $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
        $variables['primary']['#prefix'] .= '<nav class="menu-local-tasks">';
        $variables['secondary']['#prefix'] .= '<ul class="nav nav-pills" role="navigation">';
        $variables['secondary']['#suffix'] = '</ul>';
        $variables['primary']['#suffix'] .= '</nav>';
        $output .= drupal_render($variables['secondary']);
      }

      return $output;
}
// Define custom theme function for image style to prevent inclusion of height/width attributes in HTML
/* theme_image_style() */
function cca_image_style($variables) {
  // Determine the dimensions of the styled image.
  $dimensions = array(
    'width' => $variables['width'],
    'height' => $variables['height'],
  );

  image_style_transform_dimensions($variables['style_name'], $dimensions);

  // Determine the URL for the styled image.
  $variables['path'] = image_style_url($variables['style_name'], $variables['path']);
  return theme('image', $variables);
}

/* theme_image() */
function cca_image($variables) {
    $attributes = $variables['attributes'];
      $attributes['src'] = file_create_url($variables['path']);

      foreach (array('alt', 'title') as $key) {

        if (isset($variables[$key])) {
          $attributes[$key] = $variables[$key];
        }
      }

      return '<img' . drupal_attributes($attributes) . ' />';
}
function cca_preprocess_button(&$variables) {
  if ($variables['element']['#value'] == 'Search') {
    $variables['theme_hook_suggestions'][] = 'button__search_form';
  }
}

function cca_button__search_form(&$variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/* theme_button() */
function cca_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  $element['#attributes']['class'][] = 'btn btn-primary';
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

function cca_form($variables) {
  $element = $variables['element'];
  if (isset($element['#action'])) {
    $element['#attributes']['action'] = drupal_strip_dangerous_protocols($element['#action']);
  }
  element_set_attributes($element, array('method', 'id'));
  if (empty($element['#attributes']['accept-charset'])) {
    $element['#attributes']['accept-charset'] = "UTF-8";
  }
  // Anonymous DIV to satisfy XHTML compliance.
  return '<form' . drupal_attributes($element['#attributes']) . '><div class="form-group"><div>' . $element['#children'] . '</div></div></form>';
}

function cca_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));
  _form_set_class($element, array('form-text','form-control'));

  $extra = '';
  if ($element['#autocomplete_path'] && drupal_valid_path($element['#autocomplete_path'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
    $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';

  return $output . $extra;
}

function cca_password($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'password';
  element_set_attributes($element, array('id', 'name', 'size', 'maxlength'));
  _form_set_class($element, array('form-text','form-control'));

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

function cca_textarea($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'cols', 'rows'));
  _form_set_class($element, array('form-textarea','form-control'));

  $wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );

  $output = '<div' . drupal_attributes($wrapper_attributes) . '>';
  $output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  $output .= '</div>';
  return $output;
}

function cca_preprocess_panels_pane(&$variables) {
    if (in_array('panels_pane__views__projects_of_sub_programme', $variables['theme_hook_suggestions'])) {

    }
}

function cca_preprocess_views_view(&$variables) {
    //$count = count($variables['view']->result);
    $count = 17;

    switch ($count) {
        case $count % 3 == 0 :
            // All rows divided into 3 cols
            $variables['classes_array'][] = 'cols-3';
            break;
        case $count % 2 == 0 :
            // All rows divided into 2 cols
            $variables['classes_array'][] = 'cols-2';
            break;
        default :
            $variables['classes_array'][] = 'cols-3';
    }
}
?>