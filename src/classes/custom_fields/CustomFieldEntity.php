<?php

namespace AmoCRM\CustomField;

use AmoCRM\AmoCRMEntity;
use AmoCRM\Contracts\iAmoCRM;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * @property  String $elem_id
 * @property  String $type
 * @property  String $name
 * @property  String $field_type
 * @property  String $sort
 * @property  String $code
 * @property  String $is_multiple
 * @property  String $is_system
 * @property  String $is_editable
 * @property  String $is_required
 * @property  String $is_deletable
 * @property  String $is_visible
 * @property  String $params
 *
 */
class CustomFieldEntity extends AmoCRMEntity
{

   private
      $type,
      $name,
      $field_type,
      $sort,
      $code,
      $is_multiple,
      $is_system,
      $is_editable,
      $is_required,
      $is_deletable,
      $is_visible,
      $params;

   public function __construct(String $type, array $customField)
   {
      $this->type = $type;
      $this->name = $customField['name'] ?? '';
      $this->field_type = $customField['field_type'] ?? '';
      $this->sort = $customField['sort'] ?? '';
      $this->code = $customField['code'] ?? '';
      $this->is_multiple = $customField['grouis_multiplep_id'] ?? '';
      $this->is_system = $customField['is_system'] ?? '';
      $this->is_editable = $customField['is_editable'] ?? '';
      $this->is_required = $customField['is_required'] ?? '';
      $this->is_deletable = $customField['is_deletable'] ?? '';
      $this->is_visible = $customField['is_visible'] ?? '';
      $this->params = $customField['params'] ?? '';
      parent::__construct($customField['id']);
   }

   public function __get($name)
   {
      if (property_exists($this, $name))  return $this->$name;
      throw new AmoCRMException('Нет такого параметра');
   }
}
