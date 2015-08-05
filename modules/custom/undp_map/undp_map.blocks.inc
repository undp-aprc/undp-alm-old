<?php
module_load_include('inc', 'custom_blocks_base', 'custom_blocks_base.custom_block');

/**
 * Main Map block class
 *
 * This class is used as the parent for most other map types
 */
class UndpMap_Undp_Main_Map extends CustomBlocksBlock {
	public $delta = 'undp_main_map';
	public $description = 'Main Map';
	public $intro = 'Click on icon to view project';

	/**
	 * Default settings for the map
	 */
	public $defaults = array(
		'zoom' => 10,
		'lat' => '39.739167',
		'lon' => '-104.984722',
		'iconDefaults' => array(
		  'default' => array(
		    'iconSize' => array('x' => 20, 'y' => 20),
		    'shadowUrl' => '/sites/all/modules/custom/undp_map/images/icon-shadow.png',
        'shadowSize' => array('x' => 20, 'y' => 20),
		  ),
		  'selected' => array(
		    'iconSize' => array('x' => 52, 'y' => 68),
		    'shadowUrl' => NULL
		  )
		),
	);

  /**
   * Cache the features in case it calls multiple times
   */
  protected $featuresCache = NULL;

	/**
	 * Configure screen for this block
	 *
	 * @return array
	 */
	public function configure() {
	  $form = array();

	  $form['map_settings'] = array(
	    '#type' => 'fieldset',
	    '#title' => t('Map Settings'),
	    '#description' => 'Where should we center the map?'
	  );

	  $form['map_settings']['lat'] = array(
	    '#type' => 'textfield',
	    '#title' => 'Latitude',
	    '#default_value' => $this->getCenterLat(),
	  );

	  $form['map_settings']['lon'] = array(
	    '#type' => 'textfield',
	    '#title' => 'Longitude',
	    '#default_value' => $this->getCenterLon(),
	  );

	  $form['map_settings']['zoom'] = array(
	    '#type' => 'textfield',
	    '#title' => 'Zoom',
	    '#default_value' => $this->getZoom(),
	  );

	  return $form;
	}

	/**
	 * Generate the block content/map
	 *
	 * @param array $options Options for the leaflet map
	 */
	public function content($options = array()) {
	  // if we cannot get the center lat/lon we shouldn't show the map
	  if (!$this->getCenterLat() || !$this->getCenterLon()) {
	    return;
	  }
	  
	  /** Added by Matt Clark 24/3/2014 as per request from project team
	  /** Check if new field 'field_map_caption' is populated in project content type. If so, then assign text to $this->intro. If not, leave $this->intro as existing/default value **/
	  $this->intro = isset($this->project->field_map_caption['und'][0]['value']) ? $this->project->field_map_caption['und'][0]['value'] : $this->intro;

	  // get the basic map from leaflet and change around a few of the items with it
	  $map = leaflet_leaflet_map_info();
	  $map['OSM Mapnik']['center'] = array('lat' => $this->getCenterLat(), 'lon' => $this->getCenterLon());
	  $map['OSM Mapnik']['settings']['zoom'] = $this->getZoom();
    $map['OSM Mapnik']['settings']['scrollWheelZoom'] = FALSE;
    $map['OSM Mapnik']['label'] = 'Mapbox';
    $map['OSM Mapnik']['layers']['earth']['urlTemplate'] = "http://{s}.tiles.mapbox.com/v3/mapbox.world-glass/{z}/{x}/{y}.png";
    $map['OSM Mapnik']['layers']['earth']['attributes']['attribution'] = 'Mapbox';
	  $features = $this->getMapFeatures($options);
    drupal_add_js(array('undpmap' => array('icon' => $this->defaults['iconDefaults'])), 'setting');

    $content = array();
    $content[] = leaflet_render_map($map['OSM Mapnik'], $features);
	
    if ($this->intro) {
      $content[] = '<p class="intro">'. t($this->intro) .'</p>';
    }
	  return implode("\n", $content);
	}

	/**
	 * Return the center lat for this map
	 *
	 * @return string
	 */
	public function getCenterLat() { return $this->get($this->delta .'_center_lat', $this->defaults['lat']); }

	/**
	 * Return the center lon for this map
	 *
	 * @return string
	 */
	public function getCenterLon() { return $this->get($this->delta .'_center_lon', $this->defaults['lon']); }

  /**
   * Select
   */
  public function setFundingSourceMarker(&$point, $funding_source, $language, $options = array()) {
		$funding_source_id = $funding_source[$language][0]['tid'];
		$source = taxonomy_term_load($funding_source_id);

    // add the marker for this project based on the following:
    //  1. The funding source has a marker and the project is not selected
    //  2. The funding source has a selected marker and the project is selected
    //  3. OR if the project is selected, but doesn't have a selected project ... fall back (if possible)
    $has_marker = (bool) count($source->field_marker);
    $has_selected_marker = (bool) count($source->field_selected_marker);
    $is_selected_project = isset($options['icon']) && $options['icon'] == 'selected';

    // rule #2
    if ($has_selected_marker && $is_selected_project) {
      // use selected marker
      $point['icon'] = $this->defaults['iconDefaults']['selected'];
			$point['icon']['iconUrl'] = file_create_url($source->field_selected_marker[$language][0]['uri']);
    }
    // rules #1 and #3
		else if ($has_marker) {
			// use marker
			$point['icon'] = $this->defaults['iconDefaults']['default'];
			$point['icon']['iconUrl'] = file_create_url($source->field_marker[$language][0]['uri']);
		}
  }

	/**
	 * Return the array that defines the point for the given project
	 *
	 * Current options include:
	 *
	 *  - icon: Specify the icon for this point. This can either be a string which references
	 *    a key in the $this->icons array OR an icon array itself. See the leaflet API for
	 *    more about custom markers: http://leaflet.cloudmade.com/examples/custom-icons.html
	 *
	 * @param object $project
	 * @param array $options
	 * @return array
	 */
	public function getProjectPoint($project, $options = array()) {
    // basic point configuration
    if (!isset($project->field_coordinates[$project->language])) {
      return false;
    }

		$point = array(
      'type' => 'point',
      'popup' => l($project->title, 'node/'. $project->nid),
    );

    if (!isset($project->field_coordinates[$project->language])) {
      return false;
    }
    $point['lat'] = $project->field_coordinates[$project->language][0]['lat'];
    $point['lon'] = $project->field_coordinates[$project->language][0]['lon'];

    // now we need to figure out what marker to use for this point
		// use the funding source marker
		if (count($project->field_funding_source)) {
      $this->setFundingSourceMarker($point, $project->field_funding_source, $project->language, $options);
		}

		if (isset($options['icon']) && is_array($options['icon'])) {
			$point['icon'] = $options['icon'];
		}

    if ($this->debug) { dpm($point, 'Point definition'); }

		return $point;
	}

  /**
   * Get the features for the map
   */
  public function getMapFeatures($options = array()) {
    if ($this->featuresCache && !isset($options['doNotCache'])) {
      return $this->featuresCache;
    }

    $features = array();

    // get the top-level regions
    $regions_taxonomy = taxonomy_vocabulary_machine_name_load('region_country');

    $query = db_select('taxonomy_term_data', 't');
    $query
      ->fields('t')
      ->join('taxonomy_term_hierarchy', 'h', 't.tid = h.tid');
    $query->join('field_data_field_coordinates', 'c', "t.tid = c.entity_id AND c.entity_type = 'taxonomy_term'");
    $query->fields('c');
    $region_results = $query
      ->condition('vid', $regions_taxonomy->vid, '=')
      ->condition('h.parent', 0, '=')
      ->orderBy('weight')
      ->execute();

    foreach($region_results as $region){
      $point = $this->getRegionPoint($region);
      if (!$point) {
        continue;
      }
      $features[] = $point;
    }

	  // get the projects
	  $query = new EntityFieldQuery;
	  $project_ids = $query
	    ->entityCondition('entity_type', 'node')
	    ->entityCondition('bundle', 'project')
	    ->propertyCondition('status', 1)
	    ->execute();
	  $project_ids = array_keys($project_ids['node']);
	  $projects = entity_load('node', $project_ids);

	  foreach ($projects as $project) {
			$point_options = array();

      // if this is the selected project, change it to the selected icon
			if (isset($options['project']) && isset($project->nid) && isset($options['project']->nid) && $project->nid == $options['project']->nid) {
				// set the "selected" marker
				$point_options['icon'] = 'selected';
			}

      $point = $this->getProjectPoint($project, $point_options);
      if ($point) {
  	    $features[] = $point;
      }
	  }

    $this->featuresCache = $features;
    return $features;
  }

  /**
   * Return the point for this region/country for adding to the features
   */
  public function getRegionPoint($region, $options = array()) {
    // basic point configuration
		$point = array(
      'type' => 'popup',
      'content' => l($region->name, 'taxonomy/term/'. $region->tid),
      // 'lat' => $region->field_coordinates_lat,
      // 'lon' => $region->field_coordinates_lon,
    );

    if (isset($region->field_coordinates_lat)) {
      $point['lat'] = $region->field_coordinates_lat;
      $point['lon'] = $region->field_coordinates_lon;
    }
    elseif (isset($region->field_coordinates) && isset($region->field_coordinates[LANGUAGE_NONE])) {
      $point['lat'] = $region->field_coordinates[LANGUAGE_NONE][0]['lat'];
      $point['lon'] = $region->field_coordinates[LANGUAGE_NONE][0]['lon'];
    }
    else {
      return false;
    }

    return $point;

  }

	/**
	 * Return the zoom for this map
	 *
	 * @return int
	 */
	public function getZoom() { return $this->get($this->delta .'_zoom', $this->defaults['zoom']); }

	/**
	 * save configuration for this map
	 *
	 * @param array $edit
	 */
	public function save($edit) {
	  if (isset($edit['lat'])) {
  	  $this->set($this->delta .'_center_lat', $edit['lat']);
	  }
	  if (isset($edit['lon'])) {
  	  $this->set($this->delta .'_center_lon', $edit['lon']);
	  }
	  $this->set($this->delta .'_zoom', $edit['zoom']);
	}
}

class UndpMap_Undp_Explore_Map extends UndpMap_Undp_Main_Map {
  public $delta = 'undp_explore_map';
  public $description = 'Explore Map';
  public $intro = FALSE;

  public function view() {
    drupal_add_js(drupal_get_path('module', 'undp_map') .'/undp_map_explore.js');
    return parent::view();
  }
}

/**
 * Project map
 *
 * This is the same as the main map, but centers on the project in question
 */
class UndpMap_Undp_Project_Map extends UndpMap_Undp_Main_Map {
	public $delta = 'undp_project_map';
	public $description = 'Project Map';
	public $project = NULL;
	public $intro = FALSE;

	public function __construct($options = array()) {
		parent::__construct($options);

		// change the main map defaults
		$this->defaults['zoom'] = 8;
	}

	public function configure() {
	  $form = parent::configure();
	  unset($form['map_settings']['lat'], $form['map_settings']['lon']);
	  return $form;
	}

  /**
   * Set the project before getting the content for this map
   */
	public function content() {
		// set the project
		$this->setProject();
		return parent::content(array('project' => $this->project));
	}

  /**
   * Map centers on the project
   */
	public function getCenterLat() {
	  if (!$this->project) {
	    return FALSE;
	  }

    $language = $this->getLanguage();

	  if (!isset($this->project->field_coordinates[$language])) {
	    return FALSE;
	  }
		return $this->project->field_coordinates[$language][0]['lat'];
	}

  /**
   * Map centers on the project
   */
	public function getCenterLon() {
	  if (!$this->project) {
	    return FALSE;
	  }

    $language = $this->getLanguage();

	  if (!isset($this->project->field_coordinates[$language])) {
	    return FALSE;
	  }
		return $this->project->field_coordinates[$language][0]['lon'];
	}

	/**
	 * Get the language based on the project
	 */
	protected function getLanguage() {
	  $language = LANGUAGE_NONE;
    if (isset($this->project->language)) {
      $language = $this->project->language;
    }
	  return $language;
	}

	public function save($edit) {
	 $this->set($this->delta .'_zoom', $edit['zoom']);
	}

	public function setProject() {
		if (arg(0) == 'node' && is_numeric(arg(1))) {
			$this->project = node_load(arg(1));
		}
	}
}

/** Added by Matt Clark 10/9/2014 at request of NAP-LDC team **/
/** NAP-LDC Project Map **/
/** This is the same as the main map, but filters the results to display only NAP-LDC projects **/
class UndpMap_Undp_Project_Map_NAP_LDC extends UndpMap_Undp_Main_Map {
	public $delta = 'undp_project_map_nap_ldc';
	public $description = 'Project Map (NAP-LDCs)';
	public $project = NULL;
	public $intro = FALSE;
	
    public function getMapFeatures($options = array()) {
      if ($this->featuresCache && !isset($options['doNotCache'])) {
        return $this->featuresCache;
      }

      $features = array();

      // get the top-level regions
      $regions_taxonomy = taxonomy_vocabulary_machine_name_load('region_country');

      $query = db_select('taxonomy_term_data', 't');
      $query
        ->fields('t')
        ->join('taxonomy_term_hierarchy', 'h', 't.tid = h.tid');
      $query->join('field_data_field_coordinates', 'c', "t.tid = c.entity_id AND c.entity_type = 'taxonomy_term'");
      $query->fields('c');
      $region_results = $query
        ->condition('vid', $regions_taxonomy->vid, '=')
        ->condition('h.parent', 0, '=')
        ->orderBy('weight')
        ->execute();

      foreach($region_results as $region){
        $point = $this->getRegionPoint($region);
        if (!$point) {
          continue;
        }
        $features[] = $point;
      }

  	  // get the projects
  	  $query = new EntityFieldQuery;
  	  $project_ids = $query
  	    ->entityCondition('entity_type', 'node')
  	    ->entityCondition('bundle', 'project')
  	    ->propertyCondition('status', 1)
		->fieldCondition('field_funding_source','tid', array(29,28))
  	    ->execute();
  	  $project_ids = array_keys($project_ids['node']);
  	  $projects = entity_load('node', $project_ids);

  	  foreach ($projects as $project) {
  			$point_options = array();

        // if this is the selected project, change it to the selected icon
  			if (isset($options['project']) && isset($project->nid) && isset($options['project']->nid) && $project->nid == $options['project']->nid) {
  				// set the "selected" marker
  				$point_options['icon'] = 'selected';
  			}

        $point = $this->getProjectPoint($project, $point_options);
        if ($point) {
    	    $features[] = $point;
        }
  	  }

      $this->featuresCache = $features;
      return $features;
    }
}

/**
 * Country map
 *
 * Centers on country/region instead of project
 */
class UndpMap_Undp_Country_Map extends UndpMap_Undp_Project_Map {
  public $delta = 'undp_country_map';
  public $description = 'Country Map';
  public $intro = FALSE;

  /**
   * Instead of a project, we are really setting project to a taxonomy term
   */
  public function setProject() {
    if (arg(0) == 0 && arg(1) == 'term' && is_numeric(arg(2))) {
      $this->project = taxonomy_term_load(arg(2));
    }
  }

  /**
   * Append the country to the map features if this is a country term
   */
  public function getMapFeatures($options = array()) {
    $features = parent::getMapFeatures($options);

    // if this is a country, we need to add the popup for the country
    $parent_terms = taxonomy_get_parents($this->project->tid);
    if ($parent_terms) {
      $point = $this->getRegionPoint($this->project);
      if ($point) {
        $features[] = $point;
      }
    }
    return $features;
  }
}