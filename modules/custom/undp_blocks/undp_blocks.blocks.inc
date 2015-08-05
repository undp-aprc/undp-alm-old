<?php
module_load_include('inc', 'custom_blocks_base', 'custom_blocks_base.custom_block');

class UndpBlocks_Project_Menu_Block extends CustomBlocksListBlock {
  public $delta = 'project_menu_block';
  public $description = 'Project menu block';
  protected $cachedNID = NULL;

  /*
    HTML attributes for this list
  */
  public $attributes = array();

  /*
    Links for this menu
  */
  public $links = array(
    'overview' => array(
      'title' => 'Overview',
      'href' => '%node',
    ),
	'about' => array(
      'title' => 'About',
      'href' => '%node/about',
    ),
    'updates' => array(
      'title' => 'News and Updates',
      'href' => '%node/news-updates',
    ),
    'countries' => array(
 	   'title' => 'Country Initiatives',
 	   'href' => '%node/country-initiatives',
    ),
    'expected' => array(
      'title' => 'Key Results & Outputs',
      'href' => '%node/expected-key-results',
    ),
	'meetings' => array(
		'title' => 'Programme Meetings and Workshops',
		'href' => '%node/meetings-and-workshops',
	),
    'reports' => array(
      'title' => 'Reports/Publications',
      'href' => '%node/reports-and-publications',
    ),
    'videos' => array(
 	   'title' => 'Videos and Multimedia',
 	   'href' => '%node/videos',
    ),
    'monitoring' => array(
      'title' => 'Monitoring & Evaluation',
      'href' => '%node/monitoring-and-evaluation',
    ),
    'french' => array(
 	   'title' => 'Information in French / Informations en français',
 	   'href' => '%node/information-in-french',
    ),
    'links' => array(
      'title' => 'Links',
      'href' => '%node/links',
    ),
    'contacts' => array(
      'title' => 'Contacts',
      'href' => '%node/contacts',
    ),
    'internal_documentation' => array(
      'title' => 'Internal Documentation',
      'href' => '%node/internal-documentation',
   ),
 );

  /**
   * Determines if the reports link should show or not for a given project.
   */
  public function showLink($link_key) {
    // Figure out the NID for this page.
    $nid = $this->cachedNID;

    if ($nid === NULL) {
      if (arg(0) == 'node' && is_numeric(arg(1))) {
        $nid = arg(1);
      }
      else {
        $node_path = $this->getNodePath();
        if ($node_path) {
          $source_path = drupal_lookup_path('source', $node_path);
          $source = explode('/', $source_path);
          $nid = intval($source[1]);
        }
      }
      if (!$nid) {
        $nid = FALSE;
      }

      // save this in memory for this page request
      $this->cachedNID = $nid;
    }
	switch ($link_key) {
		
		//Show or hide the 'About' link
		case 'about':
		if ($nid) {
          if(!$this->populatedFieldQuery($nid, 'field_project_about')) {
			  return FALSE;
          };
		}
		break;
		
		//Show or hide the 'Programme Meetings and Workshops' link
		case 'meetings':
		if ($nid) {
          if(!$this->populatedFieldQuery($nid, 'field_upcoming_events')) {
			  return FALSE;
          };
		}
		break;
		
		//Show or hide the 'Key Results and Outputs' link
		case 'expected':
		if ($nid) {
          if(!$this->populatedFieldQuery($nid, 'field_project_results_outputs')) {
			  return FALSE;
          };
		}
		break;
		
		//Show or hide the 'News and Updates' link
		case 'updates':
		if ($nid) {
          if(!$this->populatedFieldQuery($nid, 'field_project_updates')) {
			  return FALSE;
          };
		}
		break;
		
		//Show or hide the 'Reports/Publications' link
		case 'reports':
	        if ($nid) {
	          $query = new EntityFieldQuery;
	          $query
	            ->entityCondition('entity_type', 'node')
	            ->entityCondition('bundle', 'resource')
	            ->fieldCondition('field_resource_project', 'nid', $nid, '=');
	          $resources = $query->execute();
	          if (count($resources) == 0) {
	            return FALSE;
	          }
	        }
		break;
		
		//Show or hide the 'Videos' link
		case 'videos':
	        if ($nid) {
				
	          $query = new EntityFieldQuery;
	          $query
	            ->entityCondition('entity_type', 'node')
	            ->entityCondition('bundle', 'video')
	            ->fieldCondition('field_project', 'nid', $nid, '=');
	          $resources = $query->execute();
	          if (count($resources) == 0) {
	            return FALSE;
	          }
	        }
		break;
		
		//Show or hide the 'Monitoring & Evaluation' link
		case 'monitoring':
			if ($nid) {
  	          if(!$this->populatedFieldQuery($nid, 'field_project_monitoring')) {
				  return FALSE;
  	          };
			}
		break;
		
		//Show or hide the 'links' link
		case 'links':
			if ($nid) {
	          if(!$this->populatedFieldQuery($nid, 'field_links')) {
				  return FALSE;
	          };
			}
		break;
		
		//Show or hide the 'contacts' link
		case 'contacts':
			if ($nid) {
	          if(!$this->populatedFieldQuery($nid, 'field_project_contacts')) {
				  return FALSE;
	          };
			}
		break;
		
		//Show or hide the 'Internal Documentation' link
		case 'internal_documentation':
	        if ($nid) {
	          $query = new EntityFieldQuery;
	          $query
	            ->entityCondition('entity_type', 'node')
	            ->entityCondition('bundle', 'internal_documentation')
	            ->fieldCondition('field_related_project', 'nid', $nid, '=');
	          $resources = $query->execute();
	          if (count($resources) == 0) {
	            return FALSE;
	          }
	        }
		break;
		
		case 'countries':
			if ($nid) {
	          if(!$this->populatedFieldQuery($nid, 'field_project_countries')) {
				  return FALSE;
	          };
			}
		break;
		
		case 'countries':
			if ($nid) {
	          if(!$this->populatedFieldQuery($nid, 'field_project_countries')) {
				  return FALSE;
	          };
			}
		break;
		
		case 'french':
			if ($nid) {
	          if(!$this->populatedFieldQuery($nid, 'field_project_french')) {
				  return FALSE;
	          };
			}
		break;
	}	
    return TRUE;
  }
  
  /* Database query had to be used to check if fields in project node are populated or not because EFQ API doesn't work on blank fields (https://api.drupal.org/comment/47303#comment-47303) */
  public function populatedFieldQuery($nid, $field) {
	  $table = 'field_data_'.$field;
	  
	  $result = db_query("SELECT COUNT(*) AS `count` FROM $table WHERE entity_id = :nid", array(':nid'=>$nid));
	  $record = $result->fetchAssoc();

	  if ($record['count'] >= 1) {
		  return TRUE;
	  }
	  
	  return FALSE;
  }

  public function getNodePath() {
    if ($this->pathCache) {
      return $this->pathCache;
    }

    // try to lookup the path
    $path_components = arg(NULL, drupal_get_path_alias());
    $path = NULL;
    $match_path = array();

    while (count($path_components) > 0) {
      $match_path[] = array_shift($path_components);
      $path = drupal_lookup_path('source', implode('/', $match_path));

      if ($path) {
        $this->pathCache = implode('/', $match_path);
        return $this->pathCache;
      }

    }

    return false;
  }

}
