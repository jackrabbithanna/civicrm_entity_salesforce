<?php
/**
 * @file
 * Defines CivicrmEntitySalesforceMappingQueue entity object as well as all the associated controller objects
 */

/**
 * Represents a CiviCRM Entity Salesforce Mapping Queue
 */
class CivicrmEntitySalesforceMappingQueue extends Entity {
  public $id;
  public $entity_label;

  /**
   * CivicrmEntitySalesforceMappingQueue constructor.
   *
   * @param array $values
   * @param null $entity_type
   *
   * @throws \Exception
   */
  public function __construct($values = array(), $entity_type) {
    parent::__construct($values, $entity_type);
  }

  /**
   * Returns the default label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  protected function defaultLabel() {
    return $this->entity_label;
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

  /**
   * Returns the default URI for the entity
   *
   * @return array
   *   Returns the URI for the entity
   */
  protected function defaultUri() {
    return array('path' => 'admin/structure/civicrm-entity-salesforce/entity-mapping/' . $this->id);
  }


}

/**
 * Provides CivicrmEntitySalesforceMappingQueueController for CivicrmEntitySalesforceMappingQueue entities
 */
class CivicrmEntitySalesforceMappingQueueController extends EntityAPIController {
  /**
   * {@inheritdoc}
   */
  public function __construct($entityType) {
    parent::__construct($entityType);
  }

  /**
   * Creates a CivicrmEntitySalesforceMappingQueue entity
   *
   * @param $values
   *
   * @return object CivicrmEntitySalesforceMappingQueue
   *   A CivicrmEntitySalesforceMappingQueue entity object with default fields initialized.
   */
  public function create(array $values = array()) {
    $values += array(
      'id' => '',
    );
    if (empty($values['is_new'])) {
      $values['is_new'] = TRUE;
    }

    $mapping = parent::create($values);
    return $mapping;
  }

  public function save($entity, DatabaseTransaction $transaction = NULL) {
    if (isset($entity->is_new)) {
      $entity->created = REQUEST_TIME;
    }
    $entity->updated = REQUEST_TIME;

    return parent::save($entity, $transaction);
  }

}

/**
 * Provides CivicrmEntitySalesforceMappingQueueMetadataController for CivicrmEntitySalesforceMappingQueue entities
 */
class CivicrmEntitySalesforceMappingQueueMetadataController extends EntityDefaultMetadataController {
  /**
   * Sets property metadata information for CivicrmEntitySalesforceMappingQueue entities
   * @return array $info
   *   Array of CivicrmEntitySalesforceMappingQueue property metadata information
   */
  public function entityPropertyInfo() {
    $info = parent::entityPropertyInfo();
    $info[$this->type]['properties']['id'] = array(
      'label' => t("id"),
      'type' => 'integer',
      'description' => t("Drupal Identifier for a CiviCRM Entity Salesforce Mapping Queue item."),
      'schema field' => 'id',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['mapping_id'] = array(
      'label' => t("Mapping ID"),
      'type' => 'integer',
      'description' => t("Drupal ID of the civicrm_entity_salesforce_mapping entity linked to this queue table."),
      'schema field' => 'mapping_id',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['entity_type'] = array(
      'label' => t("Entity type"),
      'type' => 'text',
      'description' => t("Drupal entity type being synced"),
      'schema field' => 'entity_type',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['salesforce_object'] = array(
      'label' => t("Salesforce object"),
      'type' => 'text',
      'description' => t("Name of salesforce object being synced to."),
      'schema field' => 'salesforce_object',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['entity_id'] = array(
      'label' => t("Entity ID"),
      'type' => 'integer',
      'description' => t("ID of the entity that will sync to Salesforce."),
      'schema field' => 'entity_id',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => FALSE,
    );
    $info[$this->type]['properties']['entity_label'] = array(
      'label' => t("Entity label"),
      'type' => 'text',
      'description' => t("Label of the entity being synced"),
      'schema field' => 'entity_label',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['salesforce_id'] = array(
      'label' => t("Salesforce ID"),
      'type' => 'text',
      'description' => t("Salesforce internal id that the entity is synced to."),
      'schema field' => 'salesforce_id',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['sync_status'] = array(
      'label' => t("Sync status"),
      'type' => 'integer',
      'description' => t("Sync status, checked = needs to sync, unchecked = doesn't need to sync."),
      'schema field' => 'sync_status',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'checkbox',
      'required' => FALSE,
    );
    $info[$this->type]['properties']['delete'] = array(
      'label' => t("Delete on sync"),
      'type' => 'integer',
      'description' => t("Flag to delete on next sync, 0 = do not delete, 1 = delete"),
      'schema field' => 'delete',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'checkbox',
      'required' => FALSE,
    );
    $info[$this->type]['properties']['last_queued_to_sync_date'] = array(
      'label' => t("Last queued to sync date"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the entity was last queued to be synced."),
      'schema field' => 'last_queued_to_sync_date',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['last_sync_date'] = array(
      'label' => t("Last sync date"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the entity was last synced."),
      'schema field' => 'last_sync_date',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['created'] = array(
      'label' => t("Created"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the entity was created."),
      'schema field' => 'created',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['updated'] = array(
      'label' => t("Updated"),
      'type' => 'date',
      'description' => t("The Unix timestamp when the entity was most recently saved."),
      'schema field' => 'updated',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
    );

    return $info;
  }
}

/**
 * Provides CivicrmEntitySalesforceMappingQueueUIController for CivicrmEntitySalesforceMappingQueue entity
 */
class CivicrmEntitySalesforceMappingQueueUIController extends EntityContentUIController {
  /**
   * Implements hook_forms().
   */
  public function hook_forms() {
    $forms = parent::hook_forms();
    return $forms;
  }

  /**
   * Implements hook_menu()
   */
  public function hook_menu() {
    $wildcard = isset($this->entityInfo['admin ui']['menu wildcard']) ? $this->entityInfo['admin ui']['menu wildcard'] : '%' . $this->entityType;
    /*
    $items['admin/structure/civicrm-entity-salesforce/entity-mapping/%'] = array(
      'page callback' => 'civicrm_entity_salesforce_mapping_entry_view_page',
      'page arguments' => array(4),
      'access callback' => 'civicrm_entity_salesforce_mapping_entry_access',
      'access arguments' => array(4),
      'file' => 'mappings-entry.admin.inc',
      'file path' => drupal_get_path('module','civicrm_entity_salesforce') . '/forms',
    );

    $items['admin/structure/civicrm-entity-salesforce/entity-mapping/%/view'] = array(
      'title' => 'View',
      'type' => MENU_DEFAULT_LOCAL_TASK,
      'weight' => -10,
    );

    return $items;
    */
  }
}

/**
 * Provides CivicrmEntitySalesforceMappingQueueExtraFieldsController for CivicrmEntitySalesforceMappingQueue entity
 */
class CivicrmEntitySalesforceMappingQueueExtraFieldsController extends EntityDefaultExtraFieldsController {
  protected $propertyInfo;

  /**
   * Implements EntityExtraFieldsControllerInterface::fieldExtraFields().
   */
  public function fieldExtraFields() {
    $extra = array();
    $this->propertyInfo = entity_get_property_info($this->entityType);
    if (isset($this->propertyInfo['properties'])) {
      foreach ($this->propertyInfo['properties'] as $name => $property_info) {
        // Skip adding the ID or bundle.
        if ($this->entityInfo['entity keys']['id'] == $name || $this->entityInfo['entity keys']['bundle'] == $name) {
          continue;
        }
        $extra[$this->entityType][$this->entityType]['display'][$name] = $this->generateExtraFieldInfo($name, $property_info);
      }
    }
    // Handle bundle properties.
    $this->propertyInfo += array('bundles' => array());
    if (isset($this->propertyInfo['bundles'])) {
      foreach ($this->propertyInfo['bundles'] as $bundle_name => $info) {
        foreach ($info['properties'] as $name => $property_info) {
          if (empty($property_info['field'])) {
            $extra[$this->entityType][$bundle_name]['display'][$name] = $this->generateExtraFieldInfo($name, $property_info);
          }
        }
      }
    }
    return $extra;
  }
}

/**
 * Provides CivicrmEntitySalesforceMappingQueueDefaultViewsController for CivicrmEntitySalesforceMappingQueue entities
 */
class CivicrmEntitySalesforceMappingQueueDefaultViewsController extends EntityDefaultViewsController {
  /**
   * {@inheritdoc}
   */
  public function views_data() {
    $data = parent::views_data();
    $entity_type = array_keys($data)[0];
    $data[$entity_type]['mapping_id']['relationship'] = array(
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


