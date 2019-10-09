<?php

namespace AmoCRM\Pipelines\Statuses;


class EditableStatusEntity
{
   private
      $id,
      $name,
      $color,
      $sort,
      $is_editable;

   public function __construct(StatusEntity $status)
   {
      $this->name = $status->name;
      $this->color = $status->color;
      $this->sort = $status->sort;
      $this->is_editable = $status->is_editable;
      $this->id = $status->elem_id;
   }

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
      $temp = [];
      $class_vars = get_object_vars($this);
      foreach ($class_vars as $name => $value) {
         if (null !== $value) {
            $temp[$name] = $value;
         }
      }
      return $temp;
   }
}
