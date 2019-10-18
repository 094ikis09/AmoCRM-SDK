<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность примечания
 */
class NoteEntity extends BaseEntity
{
   protected
      $element_id,
      $element_type,
      $text,
      $note_type,
      $created_at,
      $updated_at,
      $responsible_user_id,
      $params,
      $created_by;

   private
      $account_id,
      $group_id,
      $is_editable;

   public function __construct($entity = null)
   {
      if (is_array($entity)) {
         if (!is_numeric($entity['id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->id = $entity['id'];

         if (!is_numeric($entity['element_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->element_id = $entity['element_id'];

         if (!is_numeric($entity['element_type'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->element_type = $entity['element_type'];

         if (!is_string($entity['text'])) {
            throw new AmoCRMException('Передаваемая переменная не является строкой');
         }
         $this->text = $entity['text'];

         if (!is_numeric($entity['note_type'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->note_type = $entity['note_type'];

         if (!is_numeric($entity['created_at'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->created_at = $entity['created_at'];

         if (!is_numeric($entity['updated_at'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->updated_at = $entity['updated_at'];

         if (!is_numeric($entity['$responsible_user_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->responsible_user_id = $entity['responsible_user_id'];

         if (!is_array($entity['params'])) {
            throw new AmoCRMException('Передаваемая переменная не является массивом');
         }
         $this->params = $entity['params'];

         if (!is_numeric($entity['created_by'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->created_by = $entity['created_by'];

         if (!is_numeric($entity['account_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->account_id = $entity['account_id'];

         if (!is_numeric($entity['group_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->group_id = $entity['group_id'];

         if (!is_bool($entity['is_editable'])) {
            throw new AmoCRMException('Передаваемая переменная не является булевой');
         }
         $this->is_editable = $entity['is_editable'];
      }
   }

   /**
    * Получить id элемента, в карточке которого создано событие
    * @return int
    */
   public function getElementId()
   {
      return $this->element_id;
   }

   /**
    * Задать id элемента, в карточку которого будет добавлено событие
    * @param int $element_id
    * @return  self
    */
   public function setElementId($element_id)
   {
      if (!is_numeric($element_id)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->element_id = $element_id;

      return $this;
   }

   /**
    * Получить тип сущности элемента, в карточке которого создано событие
    * @return int
    */
   public function getElementType()
   {
      return $this->element_type;
   }

   /**
    * Задать тип сущности элемента, в карточку которого будет добавлено событие.
    * @param int $element_type
    * @return  self
    */
   public function setElementType($element_type)
   {
      if (!is_numeric($element_type)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->element_type = $element_type;

      return $this;
   }

   /**
    * Получить текст события
    * @return string
    */
   public function getText()
   {
      return $this->text;
   }

   /**
    * Задать текст события
    * @param string $text
    * @return  self
    */
   public function setText($text)
   {
      if (!is_string($text)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }
      $this->text = $text;

      return $this;
   }

   /**
    * Получить тип события
    * @return int
    */
   public function getNoteType()
   {
      return $this->note_type;
   }

   /**
    * Залать тип события
    * @param int $note_type
    * @return  self
    */
   public function setNoteType($note_type)
   {
      if (!is_numeric($note_type)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->note_type = $note_type;

      return $this;
   }

   /**
    * Получить дату и время создания события (UNIX)
    * @return int
    */
   public function getCreatedAt()
   {
      return $this->created_at;
   }

   /**
    * Задать дату и время создания события
    * @param string $created_at
    * @return  self
    */
   public function setCreatedAt($created_at)
   {
      $date = strtotime($created_at);
      if ($date === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }
      $this->created_at = $date;

      return $this;
   }

   /**
    * Получить дату и время изменения события (UNIX)
    * @return int
    */
   public function getUpdatedAt()
   {
      return $this->updated_at;
   }

   /**
    * Задать дату и время изменения события
    * @param string $updated_at
    * @return  self
    */
   public function setUpdatedAt($updated_at)
   {
      $updated_at = strtotime($updated_at);
      if ($updated_at === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }
      $this->updated_at = $updated_at;

      return $this;
   }

   /**
    * Получить id пользователя ответственного за событие.
    * @return int
    */
   public function getResponsibleUserId()
   {
      return $this->responsible_user_id;
   }

   /**
    * Задать id пользователя ответственного за событие.
    * @param int $responsible_user_id
    * @return  self
    */
   public function setResponsibleUserId($responsible_user_id)
   {
      if (!is_numeric($responsible_user_id)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->responsible_user_id = $responsible_user_id;

      return $this;
   }
}
