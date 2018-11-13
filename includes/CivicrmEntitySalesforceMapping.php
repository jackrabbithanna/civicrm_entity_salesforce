<?php

/**
 * @file
 * Defines CivicrmEntitySalesforceMapping entity object as well as all the associated controller objects
 */

/**
 * Represents a CiviCRM Entity Salesforce Mapping object
 */
class CivicrmEntitySalesforceMapping extends Entity {
  public $id;
  public $title;

  /**
   * CivicrmEntitySalesforceMapping constructor.
   *
   * @param array $values
   */
  public function __construct($values = array()) {
    parent::__construct($values, 'civicrm_entity_salesforce_mapping');
  }

  /**
   * Returns the default label for the entity
   *
   * @return string
   *   Returns the label for the entity
   */
  protected function defaultLabel() {
    return $this->title;
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
    return array('path' => 'admin/structure/civicrm-entity-salesforce/mappings/' . $this->id);
  }


}

/**
 * Provides CivicrmEntitySalesforceMappingController for CivicrmEntitySalesforceMapping entities
 */
class CivicrmEntitySalesforceMappingController extends EntityAPIController {
  /**
   * {@inheritdoc}
   */
  public function __construct($entityType) {
    parent::__construct($entityType);
  }

  /**
   * Creates a CivicrmEntitySalesforceMapping entity
   *
   * @return object CivicrmEntitySalesforceMapping
   *   A CivicrmEntitySalesforceMapping entity object with default fields initialized.
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
 * Provides CivicrmEntitySalesforceMappingMetadataController for CivicrmEntitySalesforceMapping entities
 */
class CivicrmEntitySalesforceMappingMetadataController extends EntityDefaultMetadataController {
  /**
   * Sets property metadata information for CivicrmEntitySalesforceMapping entities
   * @return array $info
   *   Array of CivicrmEntitySalesforceMapping property metadata information
   */
  public function entityPropertyInfo() {
    $info = parent::entityPropertyInfo();
    $info[$this->type]['properties']['id'] = array(
      'label' => t("id"),
      'type' => 'integer',
      'description' => t("Drupal Identifier for a CiviCRM Entity Salesforce Mapping."),
      'schema field' => 'id',
      'widget' => 'hidden',
    );
    $info[$this->type]['properties']['title'] = array(
      'label' => t("Title"),
      'type' => 'text',
      'description' => t("Title of the mapping entity."),
      'schema field' => 'title',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'hidden',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['name'] = array(
      'label' => t("Name"),
      'type' => 'text',
      'description' => t("Name of the style library."),
      'schema field' => 'name',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'textfield',
      'required' => TRUE,
    );
    $info[$this->type]['properties']['enabled'] = array(
      'label' => t("Enabled"),
      'type' => 'integer',
      'description' => t("Check to enable the mapping entity."),
      'schema field' => 'enabled',
      'getter callback' => 'entity_property_verbatim_get',
      'setter callback' => 'entity_property_verbatim_set',
      'widget' => 'checkbox',
      'required' => FALSE,
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
 * Provides CivicrmEntitySalesforceMappingUIController for CivicrmEntitySalesforceMapping entity
 */
class CivicrmEntitySalesforceMappingUIController extends EntityContentUIController {
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

    $items['admin/structure/civicrm-entity-salesforce/mappings/%'] = array(
      'page callback' => 'civicrm_entity_salesforce_mapping_view_page',
      'page arguments' => array(4),
      'access callback' => 'civicrm_entity_salesforce_mapping_access',
      'access arguments' => array(4),
      'file' => 'mappings.admin.inc',
      'file path' => drupal_get_path('module','civicrm_entity_salesforce') . '/forms',
    );

    $items['admin/structure/civicrm-entity-salesforce/mappings/%/view'] = array(
      'title' => 'View',
      'type' => MENU_DEFAULT_LOCAL_TASK,
      'weight' => -10,
    );
    return $items;
  }
}

/**
 * Provides CivicrmEntitySalesforceMappingExtraFieldsController for CivicrmEntitySalesforceMapping entity
 */
class CivicrmEntitySalesforceMappingExtraFieldsController extends EntityDefaultExtraFieldsController {
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
 * Provides CivicrmEntitySalesforceMappingDefaultViewsController for CivicrmEntitySalesforceMapping entities
 */
class CivicrmEntitySalesforceMappingDefaultViewsController extends EntityDefaultViewsController {
  /**
   * {@inheritdoc}
   */
  public function views_data() {
    $data = parent::views_data();
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


