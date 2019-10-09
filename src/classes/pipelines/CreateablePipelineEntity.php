<?php

namespace AmoCRM\Pipelines;

use AmoCRM\Exceptions\AmoCRMException;
use AmoCRM\Pipelines\Statuses\CreateableStatusEntity;

class CreateablePipelineEntity
{
   private
      $name,
      $sort,
      $is_main = false,
      $statuses;

   public function setName(String $name)
   {
      $this->name = $name;
   }

   public function setSort(Int $sort)
   {
      $this->sort = $sort;
   }

   public function setIsMain(Bool $isMain)
   {
      $this->is_main = $isMain;
   }

   public function addStatuses()
   {
      return $this->statuses[] = new CreateableStatusEntity();
   }

   public function generateQuery()
   {
      if (null === $this->name && empty(trim($this->name))) {
         throw new AmoCRMException('Заполните имя методом setName');
      }
      $temp = [];
      $class_vars = get_object_vars($this);
      foreach ($class_vars as $name => $value) {
         if (null !== $value) {
            if ($name !== 'statuses') {
               $temp[$name] = $value;
            } else {
               foreach ($value as $key => $val) {
                  $temp[$name][$key] = $val->generateQuery();
               }
            }
         }
      }
      return $temp;
   }
}
