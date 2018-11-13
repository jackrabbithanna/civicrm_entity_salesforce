<?php
/**
 * @file
 * Defines CivicrmEntitySalesforceMappingSyncLog entity object as well as all the associated controller objects
 */

/**
 * Represents a CiviCRM Entity Salesforce Mapping Sync Log
 */
class CivicrmEntitySalesforceMappingSyncLog extends Entity {
  public $id;

  /**
   * CivicrmEntitySalesforceMappingSyncLog constructor.
   *
   * @param array $values
   *
   * @throws \Exception
   */
  public function __construct($values = array()) {
    parent::__construct($values, 'civicrm_entity_salesforce_mapping_sync_log');
  }

  /**
   * Returns the default label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  protected function defaultLabel() {
    return $this->id;
  }

  /**
   * Returns the label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  function label() {
    return $this->defaultLabel();
  }
}

/**
 * Provides CivicrmEntitySalesforceMappingSyncLogController for CivicrmEntitySalesforceMappingSyncLog entities
 */
class CivicrmEntitySalesforceMappingSyncLogController extends EntityAPIController {
  /**
   * {@inheritdoc}
   */
  public function __construct($entityType) {
    parent::__construct($entityType);
  }

  /**
   * Creates a CivicrmEntitySalesforceMappingSyncLog entity
   *
   * @param $values
   *
   * @return object CivicrmEntitySalesforceMappingSyncLog
   *   A CivicrmEntitySalesforceMappingSyncLog entity object with default fields initialized.
   */
  public function create(array $values = array()) {
    $values += array(
      'id' => '',
    );
    if (empty($values['is_new'])) {
      $values['is_new'] = TRUE;
    }
    $log = parent::create($values);
    return $log;
  }

  public function save($entity, DatabaseTransaction $transaction = NULL) {
    if (isset($entity->is_new)) {
      $entity->created = REQUEST_TIME;
    }
    return parent::save($entity, $transaction);
  }

}

/**
 * Provides CivicrmEntitySalesforceMappingSyncLogMetadataController for CivicrmEntitySalesforceMappingSyncLog entities
 */
class CivicrmEntitySalesforceMappingSyncLogMetadataController extends EntityDefaultMetadataController {
  /**
   * Sets property metadata information for CivicrmEntitySalesforceMappingSyncLog entities
   * @return array $info
   *   Array of CivicrmEntitySalesforceMappingSyncLog property metadata information
   */
  public function entityPropertyInfo() {
    $info = parent::entityPropertyInfo();
    $info[$this->type]['properties']['id'] = array(
      'label' => t("id"),
      'type' => 'integer',
      'description' => t("Drupal identifier for a CiviCRM Entity Salesforce Mapping sync log entity."),
      'schema field' => 'id',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['mapping_id'] = array(
      'label' => t("Mapping ID"),
      'type' => 'integer',
      'description' => t("ID of civicrm_entity_salesforce_mapping entity this log entry is for."),
      'schema field' => 'mapping_id',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['plugin_name'] = array(
      'label' => t("Plugin Name"),
      'type' => 'text',
      'description' => t("The machine name of the civicrm_entity_salesforce_mapping CTools plugin doing the sync action"),
      'schema field' => 'plugin_name',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['queue_entity_table'] = array(
      'label' => t("Queue Entity Table"),
      'type' => 'text',
      'description' => t("The table storing the queue items that are synced."),
      'schema field' => 'queue_entity_table',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['queue_id'] = array(
      'label' => t("Queue ID"),
      'type' => 'integer',
      'description' => t("ID of the queue entity table item this log entry is for."),
      'schema field' => 'queue_id',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['queue_entity_id'] = array(
      'label' => t("Queue Entity ID"),
      'type' => 'integer',
      'description' => t("ID of the drupal entity being synced that this log entry is for."),
      'schema field' => 'queue_entity_id',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['result'] = array(
      'label' => t("Result"),
      'type' => 'integer',
      'description' => t("The result of the queue item sync attempt. 1 = success, 0 = error"),
      'schema field' => 'result',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => FALSE,
    );
    $info[$this->type]['properties']['api_action'] = array(
      'label' => t("API Action"),
      'type' => 'text',
      'description' => t("The API action taken on sync, e.g create, update, delete"),
      'schema field' => 'api_action',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['api_message'] = array(
      'label' => t("API Message"),
      'type' => 'text',
      'description' => t("The message returned by the Salesforce API for the sync attempt."),
      'schema field' => 'api_message',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['created'] = array(
      'label' => t("Created"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the log item was created."),
      'schema field' => 'created',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );

    return $info;
  }
}


/**
 * Provides CivicrmEntitySalesforceMappingSyncLogDefaultViewsController for CivicrmEntitySalesforceMappingSyncLog entities
 */
class CivicrmEntitySalesforceMappingSyncLogDefaultViewsController extends EntityDefaultViewsController {
  /**
   * {@inheritdoc}
   */
  public function views_data() {
    $data = parent::views_data();
    $data['civicrm_entity_salesforce_mapping_sync_log']['mapping_id']['relationship'] = array(
      'base' => 'civicrm_entity_salesforce_mapping',
      'base field' => 'id',
      'handler' => 'views_handler_relationship',
      'label' => t('Mapping Data Entity'),
    );
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  function schema_fields() {
    $data = parent::schema_fields();
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  function map_from_schema_info($property_name, $schema_field_info, $property_info) {
    $return = parent::map_from_schema_info($property_name, $schema_field_info, $property_info);
    return $return;
  }
}


