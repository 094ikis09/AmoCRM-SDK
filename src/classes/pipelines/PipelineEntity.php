<?php

namespace AmoCRM\Pipelines;

use AmoCRM\AmoCRMEntity;
use AmoCRM\Pipelines\Statuses\StatusEntity;

/**
 * @property String $elem_id
 * @property String $name
 * @property String $sort
 * @property String $is_main
 * @property StatusEntity[] $statuses
 */
class PipelineEntity extends AmoCRMEntity
{
   private $name;
   private $sort;
   private $is_main;
   private $statuses;

   public function __construct(array $pipeline)
   {
      $this->name = $pipeline['name'] ?? '';
      $this->sort = $pipeline['sort'] ?? '';
      $this->is_main = $pipeline['is_main'] ?? '';
      foreach ($pipeline['statuses'] as $key => $value) {
         $this->statuses[$key] = new StatusEntity($value);
      }
      parent::__construct($pipeline['id']);
   }

   public function __get($name)
   {
      if (property_exists($this, $name))  return $this->$name;
      throw new AmoCRMException('Нет такого параметра');
   }
}
