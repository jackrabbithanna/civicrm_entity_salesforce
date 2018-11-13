<?php

/**
 * Form callback for settings form
 *
 * @param $form
 * @param $form_state
 *
 * @return mixed
 */
function civicrm_entity_salesforce_settings_form($form, $form_state) {
  $form['heading'] = [
    '#type' => 'markup',
    '#markup' => '<p>Global settings for CiviCRM Entity Salesforce Sync</p>',
  ];

  $settings = variable_get('civicrm_entity_salesforce_settings', []);

  $form['enable_logging'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable Logging'),
    '#return' => 1,
    '#description' => t('Check to enable logging of sync attempts.'),
    '#default_value' => !empty($settings['enable_logging']) ? 1 : 0
  ];

  $form['submit'] = [
    '#type' => 'submit',
    '#value' => t('Save Settings'),
    '#submit' => ['civicrm_entity_salesforce_settings_form_submit'],
  ];
  return $form;
}

/**
 * Submit callback for settings form
 *
 * @param $form
 * @param $form_state
 */
function civicrm_entity_salesforce_settings_form_submit($form, $form_state) {
  $settings = [];
  $settings['enable_logging'] = !empty($form_state['values']['enable_logging']) ? 1 : 0;
  variable_set('civicrm_entity_salesforce_settings', $settings);
}