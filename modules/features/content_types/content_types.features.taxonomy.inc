<?php
/**
 * @file
 * content_types.features.taxonomy.inc
 */

/**
 * Implements hook_taxonomy_default_vocabularies().
 */
function content_types_taxonomy_default_vocabularies() {
  return array(
    'climate_hazards' => array(
      'name' => 'Climate-related Hazards Addressed',
      'machine_name' => 'climate_hazards',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'funding_source' => array(
      'name' => 'Funding Source',
      'machine_name' => 'funding_source',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'implementing_agency' => array(
      'name' => 'Implementing Agency & Partnering Organizations',
      'machine_name' => 'implementing_agency',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'key_collaborators' => array(
      'name' => 'Key Collaborators',
      'machine_name' => 'key_collaborators',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'level_of_intervention' => array(
      'name' => 'Level of Intervention',
      'machine_name' => 'level_of_intervention',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'region_country' => array(
      'name' => 'Region/Country',
      'machine_name' => 'region_country',
      'description' => '',
      'hierarchy' => '1',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'resource_type' => array(
      'name' => 'Resource Type',
      'machine_name' => 'resource_type',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
    'thematic_areas' => array(
      'name' => 'Thematic Areas',
      'machine_name' => 'thematic_areas',
      'description' => '',
      'hierarchy' => '0',
      'module' => 'taxonomy',
      'weight' => '0',
    ),
  );
}
