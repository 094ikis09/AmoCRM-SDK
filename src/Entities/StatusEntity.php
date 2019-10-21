<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность этапа
 */
class StatusEntity extends BaseEntity
{

   protected
      $pipeline_id,
      $name,
      $color,
      $sort = 0,
      $is_editable;

   public function __construct($entity = null, $pipeline_id, $sort = null)
   {
      if (!is_numeric($pipeline_id)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->pipeline_id = $pipeline_id;

      if (is_array($entity)) {
         $this->id = $entity['id'];
         $this->name = $entity['name'];
         $this->color = $entity['color'];
         $this->sort = $entity['sort'];
         $this->is_editable = $entity['is_editable'];
      } else {
         if ($sort !== null) {
            $this->sort = ($sort) * 10;
         }
      }
   }

   /**
    * Получить уникальный индетификатор родительской воронки
    * @return int
    */
   public function getPipelineId()
   {
      return $this->pipeline_id;
   }

   /**
    * Получить название этапа
    * @return string
    */
   public function getName()
   {
      return $this->name;
   }

   /**
    * Задать название этапа
    * @param string $name
    * @return  self
    */
   public function setName($name)
   {
      if (!is_string($name)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->name = $name;

      return $this;
   }

   /**
    * Получить цвет этапа
    * @return string
    */
   public function getColor()
   {
      return $this->color;
   }

   /**
    * Задать цвет этапа
    * @param string $color
    * @return  self
    */
   public function setColor($color)
   {
      if (!is_string($color)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->color = $color;

      return $this;
   }

   /**
    * Получить порядковый номер этапа
    * @return int
    */
   public function getSort()
   {
      return $this->sort;
   }

   /**
    * Задать порядковый номер этапа
    * @param int $sort
    * @return  self
    */
   public function setSort($sort)
   {
      if (!is_numeric($sort)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }

      $this->sort = $sort;

      return $this;
   }

   /**
    * Возвращает можно ли редактировать этап
    * @return bool
    */
   public function getIsEditable()
   {
      return $this->is_editable;
   }

   /**
    * Задает можно ли редактировать этап
    * @param bool $is_editable
    * @return  self
    */
   public function setIsEditable($is_editable)
   {
      if (!is_bool($is_editable)) {
         throw new AmoCRMException('Передаваемая переменная не является булевой');
      }

      $this->is_editable = $is_editable;

      return $this;
   }
}
