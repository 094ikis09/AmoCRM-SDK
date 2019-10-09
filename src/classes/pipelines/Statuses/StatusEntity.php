<?php

namespace AmoCRM\Pipelines\Statuses;

use AmoCRM\AmoCRMEntity;


/**
 * @property  Int $elem_id
 * @property  String $name
 * @property  String $color
 * @property  Int $sort
 * @property  Bool $is_editable
 */
class StatusEntity extends AmoCRMEntity
{

   private
      $name,
      $color,
      $sort,
      $is_editable;


   public function __construct(array $status)
   {
      $this->name = $status['name'] ?? '';
      $this->color = $status['color'] ?? '';
      $this->sort = $status['sort'] ?? '';
      $this->is_editable = $status['is_editable'] ?? '';
      parent::__construct($status['id']);
   }

   public function __get($name)
   {
      if (property_exists($this, $name))  return $this->$name;
      throw new AmoCRMException('Нет такого параметра');
   }
}
