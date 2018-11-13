<?php

/**
 * Implements hook_views_default_views().
 */
function civicrm_entity_salesforce_views_default_views() {
  $views = [];
  $view = new view();
  $view->name = 'civicrm_entity_salesforce_mapping_sync_log';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'civicrm_entity_salesforce_mapping_sync_log';
  $view->human_name = 'Sync Log';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Sync Log';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['access']['perm'] = 'administer civicrm entity salesforce mapping queue items';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '50';
  $handler->display->display_options['style_plugin'] = 'table';
  /* Relationship: CiviCRM Entity Salesforce Mapping Sync Log: Mapping ID */
  $handler->display->display_options['relationships']['mapping_id']['id'] = 'mapping_id';
  $handler->display->display_options['relationships']['mapping_id']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['relationships']['mapping_id']['field'] = 'mapping_id';
  /* Relationship: CiviCRM Entity Salesforce Mapping Sync Log: Queue ID */
  $handler->display->display_options['relationships']['queue_id']['id'] = 'queue_id';
  $handler->display->display_options['relationships']['queue_id']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['relationships']['queue_id']['field'] = 'queue_id';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: Mapping ID */
  $handler->display->display_options['fields']['mapping_id']['id'] = 'mapping_id';
  $handler->display->display_options['fields']['mapping_id']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['mapping_id']['field'] = 'mapping_id';
  $handler->display->display_options['fields']['mapping_id']['label'] = 'Mapping Data Entity ID';
  $handler->display->display_options['fields']['mapping_id']['separator'] = '';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: Created */
  $handler->display->display_options['fields']['created']['id'] = 'created';
  $handler->display->display_options['fields']['created']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['created']['field'] = 'created';
  $handler->display->display_options['fields']['created']['date_format'] = 'short';
  $handler->display->display_options['fields']['created']['second_date_format'] = 'long';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: Plugin Name */
  $handler->display->display_options['fields']['plugin_name']['id'] = 'plugin_name';
  $handler->display->display_options['fields']['plugin_name']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['plugin_name']['field'] = 'plugin_name';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: Queue Entity Table */
  $handler->display->display_options['fields']['queue_entity_table']['id'] = 'queue_entity_table';
  $handler->display->display_options['fields']['queue_entity_table']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['queue_entity_table']['field'] = 'queue_entity_table';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: Queue Entity ID */
  $handler->display->display_options['fields']['queue_entity_id']['id'] = 'queue_entity_id';
  $handler->display->display_options['fields']['queue_entity_id']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['queue_entity_id']['field'] = 'queue_entity_id';
  $handler->display->display_options['fields']['queue_entity_id']['label'] = 'Contact ID';
  $handler->display->display_options['fields']['queue_entity_id']['separator'] = '';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: Result */
  $handler->display->display_options['fields']['result']['id'] = 'result';
  $handler->display->display_options['fields']['result']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['result']['field'] = 'result';
  $handler->display->display_options['fields']['result']['separator'] = '';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: API Action */
  $handler->display->display_options['fields']['api_action']['id'] = 'api_action';
  $handler->display->display_options['fields']['api_action']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['api_action']['field'] = 'api_action';
  /* Field: CiviCRM Entity Salesforce Mapping Sync Log: API Message */
  $handler->display->display_options['fields']['api_message']['id'] = 'api_message';
  $handler->display->display_options['fields']['api_message']['table'] = 'civicrm_entity_salesforce_mapping_sync_log';
  $handler->display->display_options['fields']['api_message']['field'] = 'api_message';
  $handler->display->display_options['fields']['api_message']['label'] = 'Api Message';
  /* Contextual filter: CiviCRM Entity Salesforce Mapping Queue Hospital: Entity ID */
  $handler->display->display_options['arguments']['entity_id']['id'] = 'entity_id';
  $handler->display->display_options['arguments']['entity_id']['table'] = 'civicrm_entity_salesforce_mapping_hospital';
  $handler->display->display_options['arguments']['entity_id']['field'] = 'entity_id';
  $handler->display->display_options['arguments']['entity_id']['relationship'] = 'queue_id';
  $handler->display->display_options['arguments']['entity_id']['title_enable'] = TRUE;
  $handler->display->display_options['arguments']['entity_id']['title'] = 'Sync Log - Contact ID %1';
  $handler->display->display_options['arguments']['entity_id']['default_argument_type'] = 'fixed';
  $handler->display->display_options['arguments']['entity_id']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['entity_id']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['entity_id']['summary_options']['items_per_page'] = '25';

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['path'] = 'admin/structure/civicrm-entity-salesforce/sync-log';
  $handler->display->display_options['menu']['type'] = 'normal';
  $handler->display->display_options['menu']['title'] = 'Sync Log';
  $handler->display->display_options['menu']['name'] = 'management';

  $views[$view->name] = $view;

  return $views;
}