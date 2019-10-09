<?php

namespace AmoCRM\Pipelines\Statuses;

use AmoCRM\Exceptions\AmoCRMException;

class CreateableStatusEntity
{
   private
      $name,
      $color,
      $sort;

   public function setName(String $name)
   {
      $this->name = $name;
   }

   public function setColor(String $color)
   {
      $this->color = $color;
   }

   public function setSort(Int $sort)
   {
      $this->sort = $sort;
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
            $temp[$name] = $value;
         }
      }
      $temp['id'] = 0;
      return $temp;
   }
}
