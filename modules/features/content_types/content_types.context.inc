<?php
/**
 * @file
 * content_types.context.inc
 */

/**
 * Implements hook_context_default_contexts().
 */
function content_types_context_default_contexts() {
  $export = array();

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'undp_home';
  $context->description = '';
  $context->tag = 'undp';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        '<front>' => '<front>',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'undp_map-undp_main_map' => array(
          'module' => 'undp_map',
          'delta' => 'undp_main_map',
          'region' => 'content',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('undp');
  $export['undp_home'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'undp_project';
  $context->description = 'Context for the UNDP project pages';
  $context->tag = 'undp';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'project' => 'project',
      ),
      'options' => array(
        'node_form' => '0',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'undp_map-undp_project_map' => array(
          'module' => 'undp_map',
          'delta' => 'undp_project_map',
          'region' => 'sidebar_first',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('Context for the UNDP project pages');
  t('undp');
  $export['undp_project'] = $context;

  return $export;
}
