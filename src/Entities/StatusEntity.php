<?php

namespace AmoCRM\Entities;

class StatusEntity extends BaseEntity
{

   protected $pipeline_id;
   protected $name;
   protected $color;
   protected $sort = 0;
   protected $is_editable;

   public function __construct($entity = null, $pipeline_id, $sort = null)
   {
      $this->pipeline_id = $pipeline_id;
      if (is_array($entity)) {
         $this->id = $entity['id'];
         $this->name = $entity['name'];
         $this->color = $entity['color'];
         $this->sort = $entity['sort'];
         $this->is_editable = $entity['is_editable'];
      } else {
         if ($sort !== null)
            $this->sort = ($sort) * 10;
      }
   }

   public function getName()
   {
      return $this->name;
   }

   public function setName($name)
   {
      $this->name = $name;
      return $this;
   }

   public function setSort($sort)
   {
      $this->sort = $sort;
      return $this;
   }

   public function setColor($color)
   {
      $this->color = $color;
      return $this;
   }
}
