<?php

/**
 * Page callback for 'admin/structure/civicrm-entity-salesforce/mappings/%'
 *
 * @param $id
 *
 * @return string
 */
function civicrm_entity_salesforce_mapping_view_page($id) {
  $mapping = entity_load_single('civicrm_entity_salesforce_mapping', $id);

  $content = '';
  if (!empty($mapping)) {
    $content = theme('civicrm_entity_salesforce_mapping_data_view', [
      'mapping' => $mapping,
    ]);

    drupal_set_title('CiviCRM Entity Salesforce Mapping ' . $mapping->label());
  }
  else {
    $content .= 'No mapping with ID: ' . $id;
  }

  return $content;
}

/**
 * Form callback for 'admin/structure/civicrm-entity-salesforce/mappings'
 *
 * @param $form
 * @param $form_state
 *
 * @return mixed
 */
function civicrm_entity_salesforce_mappings_list_form($form, &$form_state) {
  $heading_markup = '<h2>Mappings List</h2>';
  $heading_markup .= '<p>All detected sync plugins will be listed on this page. Each plugin can be installed and managed independently.</p>';
  $heading_markup .= '<ul>';
  $heading_markup .= '<li>Click Install to create the mapping entity, create the queue DB table, and other actions the plugins need to activate.</li>';
  $heading_markup .= '<li>Click Uninstall to delete the mapping entity, drop the queue DB table, and other actions the plugins need to de-activate.</li>';
  $heading_markup .= '<li>Click Enable to allow syncing of CiviCRM contacts to Salesforce.</li>';
  $heading_markup .= '<li>Click Disable to disallow syncing of CiviCRM contacts to Salesforce.</li>';
  $heading_markup .= '<li>Click Flush Mapping Table to remove all queue items of contacts to be synced.</li>';
  $heading_markup .= '<li>Click Populate Mapping Table create queue items of all contacts to be synced by the plugin.</li>';
  $heading_markup .= '<li>Click Sync All to Salesforce to immediately sync all CiviCRM contacts to Salesforce.</li>';
  $heading_markup .= '</ul>';
  $heading_markup .= '<p>For day to day syncing, contacts will sync on cron runs and will require no user interaction.</p>';
  $form['heading'] = [
    '#type' => 'markup',
    '#markup' => $heading_markup,
  ];
  $plugins = civicrm_entity_salesforce_get_all_plugins();
  $form_state['plugins'] = [];
  if (!empty($plugins)) {
    foreach ($plugins as $plugin_name => $plugin) {
      $handler = civicrm_entity_salesforce_get_mapping_class($plugin);
      $form_state['plugins'][$plugin_name]['handler'] = $handler;
    }
  }

  $form['mappings'] = [
    '#type' => 'container',
    '#tree' => TRUE,
    '#attributes' => array(
      'class' => array(
        'mappings-container',
      ),
    ),
  ];

  if (!empty($form_state['plugins'])) {
    foreach($form_state['plugins'] as $plugin_name => $plugin) {
      $plugin_info = $plugin['handler']->getPlugin();
      $mapping_entity = civicrm_entity_salesforce_load_mapping_entity_by_name($plugin_name);
      if (!empty($mapping_entity)) {
        $form_state['plugins'][$plugin_name]['entity'] = $mapping_entity;
      }
      $form['mappings'][$plugin_name] = [
        '#type' => 'fieldset',
        '#title' => $plugin_info['name'],
        '#description' => $plugin_info['description'],
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
      ];
      if (!empty($form_state['plugins'][$plugin_name]['entity']->id)) {
        $form['mappings'][$plugin_name]['status'] = [
          '#type'   => 'markup',
          '#markup' => '<a href="/admin/structure/civicrm-entity-salesforce/mappings/' . $form_state['plugins'][$plugin_name]['entity']->id . '" >Status Page</a>',
          '#prefix' => '<div class="status-link">',
          '#suffix' => '</div>'
        ];
        // total count
        $total_count = civicrm_entity_salesforce_mapping_queue_count($plugin['handler']->getQueueEntityType());
        $form['mappings'][$plugin_name]['total_count'] = [
          '#type'   => 'markup',
          '#markup' => '<span class="label">Total Count: </span><span class="value">' . $total_count . '</span>',
          '#prefix' => '<div class="total-count">',
          '#suffix' => '</div>'
        ];
        // ready to sync count
        $sync_count = civicrm_entity_salesforce_mapping_queue_count($plugin['handler']->getQueueEntityType(), 1);
        $form['mappings'][$plugin_name]['ready_to_sync'] = [
          '#type'   => 'markup',
          '#markup' => '<span class="label">Items to be synced: </span><span class="value">' . $sync_count . '</span>',
          '#prefix' => '<div class="to-sync-count">',
          '#suffix' => '</div>'
        ];
        // already synced
        $form['mappings'][$plugin_name]['synced'] = [
          '#type'   => 'markup',
          '#markup' => '<span class="label">Synced items: </span><span class="value">' . ($total_count - $sync_count) . '</span>',
          '#prefix' => '<div class="sync-count">',
          '#suffix' => '</div><br/>'
        ];

      }
      $form['mappings'][$plugin_name]['install'] = [
        '#type' => 'submit',
        '#value' => 'Install',
        '#submit' => ['civicrm_entity_salesforce_mapping_install_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => empty($form_state['plugins'][$plugin_name]['entity']) ? 0 : 1
      ];
      $form['mappings'][$plugin_name]['uninstall'] = [
        '#type' => 'submit',
        '#value' => 'Uninstall',
        '#submit' => ['civicrm_entity_salesforce_mapping_uninstall_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => empty($form_state['plugins'][$plugin_name]['entity']) ? 1 : 0
      ];
      $form['mappings'][$plugin_name]['enable'] = [
        '#type' => 'submit',
        '#value' => 'Enable',
        '#submit' => ['civicrm_entity_salesforce_mapping_enable_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => (!empty($form_state['plugins'][$plugin_name]['entity']) && empty($form_state['plugins'][$plugin_name]['entity']->enabled)) ? 0 : 1
      ];
      $form['mappings'][$plugin_name]['disable'] = [
        '#type' => 'submit',
        '#value' => 'Disable',
        '#submit' => ['civicrm_entity_salesforce_mapping_disable_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => (!empty($form_state['plugins'][$plugin_name]['entity']) && !empty($form_state['plugins'][$plugin_name]['entity']->enabled)) ? 0 : 1
      ];
      $form['mappings'][$plugin_name]['flush'] = [
        '#type' => 'submit',
        '#value' => 'Flush Mapping Table',
        '#submit' => ['civicrm_entity_salesforce_mapping_flush_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => (!empty($form_state['plugins'][$plugin_name]['entity']) && db_table_exists($plugin['handler']->getQueueEntityType())) ? 0 : 1,
      ];
      $form['mappings'][$plugin_name]['populate'] = [
        '#type' => 'submit',
        '#value' => 'Populate Mapping Table',
        '#submit' => ['civicrm_entity_salesforce_mapping_populate_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => (!empty($form_state['plugins'][$plugin_name]['entity']) && db_table_exists($plugin['handler']->getQueueEntityType())) ? 0 : 1,
      ];
      $form['mappings'][$plugin_name]['sync'] = [
        '#type' => 'submit',
        '#value' => 'Sync All to Salesforce',
        '#submit' => ['civicrm_entity_salesforce_mapping_sync_mapping_submit'],
        '#plugin_name' => $plugin_name,
        '#disabled' => (!empty($form_state['plugins'][$plugin_name]['entity']) && !empty($form_state['plugins'][$plugin_name]['entity']->enabled) && db_table_exists($plugin['handler']->getQueueEntityType())) ? 0 : 1,
      ];
    }
  }


  return $form;
}

/**
 * Mapping install submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_install_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (empty($form_state['plugins'][$plugin_name]['entity'])) {
    $plugin_info = $plugin_handler->getPlugin();
    if (db_table_exists($plugin_handler->getQueueEntityType())) {
      drupal_set_message('DB already exists! Install aborted!', 'warning');
      return;
    }
    else {
      if ($plugin_handler->install()) {
        // create mapping entity
        $entity_values = [
          'name'    => $plugin_name,
          'title'   => $plugin_info['title'],
          'enabled' => 0,
        ];
        $mapping = civicrm_entity_salesforce_mapping_create($entity_values);
        $mapping->save();
        $form_state['plugins'][$plugin_name]['entity'] = $mapping;
        $installed_plugin_queues = variable_get('civicrm_entity_salesforce_installed_queues', []);
        $installed_plugin_queues[$plugin_handler->getQueueEntityType()] = $plugin_handler->getQueueEntityType();
        variable_set('civicrm_entity_salesforce_installed_queues', $installed_plugin_queues);
        //need to clear entity caches
        entity_info_cache_clear();
        cache_clear_all();
      }
      else {
        drupal_set_message('Error installing mapping queue', 'error');
      }
    }
  }
}

/**
 * Mapping uninstall submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_uninstall_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (!empty($form_state['plugins'][$plugin_name]['entity'])) {
    if ($plugin_handler->uninstall()) {
      civicrm_entity_salesforce_mapping_delete($form_state['plugins'][$plugin_name]['entity']);
      unset($form_state['plugins'][$plugin_name]['entity']);
      $installed_plugin_queues = variable_get('civicrm_entity_salesforce_installed_queues', []);
      if (!empty($installed_plugin_queues[$plugin_handler->getQueueEntityType()])) {
        unset($installed_plugin_queues[$plugin_handler->getQueueEntityType()]);
      }
      variable_set('civicrm_entity_salesforce_installed_queues', $installed_plugin_queues);
      //need to clear entity caches
      entity_info_cache_clear();
      cache_clear_all();
    }
  }
}

/**
 * Mapping enable submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_enable_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (!empty($form_state['plugins'][$plugin_name]['entity'])) {
    $plugin_info = $plugin_handler->getPlugin();
    $form_state['plugins'][$plugin_name]['entity']->enabled = 1;
    $form_state['plugins'][$plugin_name]['entity']->save();
    $plugin_handler->enable();
  }
}

/**
 * Mapping disable submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_disable_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (!empty($form_state['plugins'][$plugin_name]['entity'])) {
    $plugin_info = $plugin_handler->getPlugin();
    $form_state['plugins'][$plugin_name]['entity']->enabled = 0;
    $form_state['plugins'][$plugin_name]['entity']->save();
    $plugin_handler->disable();
  }
}

/**
 * Mapping disable submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_flush_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (!empty($form_state['plugins'][$plugin_name]['entity'])) {
    $plugin_info = $plugin_handler->getPlugin();
    $plugin_handler->flushMappingTable();
  }
}

/**
 * Mapping disable submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_populate_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (!empty($form_state['plugins'][$plugin_name]['entity'])) {
    $plugin_info = $plugin_handler->getPlugin();
    $plugin_handler->populateMappingTable();
  }
}

/**
 * Mapping disable submit handler
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_mapping_sync_mapping_submit(&$form, &$form_state) {
  $plugin_name = $form_state['triggering_element']['#plugin_name'];
  $plugin_handler = $form_state['plugins'][$plugin_name]['handler'];
  if (!empty($form_state['plugins'][$plugin_name]['entity'])) {
    $plugin_info = $plugin_handler->getPlugin();
    $plugin_handler->syncAll();
  }
}