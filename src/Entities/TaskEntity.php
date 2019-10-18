<?php

namespace AmoCRM\Entities;

use AmoCRM\Constats\ElementType;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность задачи
 */
class TaskEntity extends BaseEntity
{

   protected
      $element_id,
      $element_type,
      $complete_till,
      $task_type,
      $text,
      $created_at,
      $updated_at,
      $responsible_user_id,
      $is_completed,
      $created_by;

   private
      $complete_till_at,
      $account_id,
      $group_id;

   public function __construct($entity = null)
   {
      if (is_array($entity)) {
         if (!is_numeric($entity['id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->id = $entity['id'];

         if (!is_numeric($entity['responsible_user_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->responsible_user_id = $entity['responsible_user_id'];

         if (!is_numeric($entity['created_by'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->created_by = $entity['created_by'];

         if (!is_numeric($entity['created_at'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->created_at = $entity['created_at'];

         if (!is_numeric($entity['updated_at'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->updated_at = $entity['updated_at'];

         if (!is_numeric($entity['account_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->account_id = $entity['account_id'];

         if (!is_numeric($entity['group_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->group_id = $entity['group_id'];

         if (!is_numeric($entity['element_type'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->element_type = $entity['element_type'];

         if (!is_numeric($entity['element_id'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->element_id = $entity['element_id'];

         if (!is_bool($entity['is_completed'])) {
            throw new AmoCRMException('Передаваемая переменная не является булевой');
         }
         $this->is_completed = $entity['is_completed'];

         if (!is_numeric($entity['task_type'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->task_type = $entity['task_type'];

         if (!is_numeric($entity['complete_till_at'])) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $this->complete_till_at = $entity['complete_till_at'];

         if (!is_string($entity['text'])) {
            throw new AmoCRMException('Передаваемая переменная не является строкой');
         }
         $this->text                   = $entity['text'];
      }
   }

   /**
    * Получить уникальный идентификатор привязываемого элемента
    * @return int
    */
   public function getElementId()
   {
      return $this->element_id;
   }

   /**
    * Задать уникальный идентификатор привязываемого элемента
    *
    * @param int $element_id id элемента
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
    * Получить тип привязываемого элемента
    * @return int
    */
   public function getElementType()
   {
      return $this->element_type;
   }

   /**
    * Задать тип привязываемого элемента
    * - ElementType::CONTACT
    * - ElementType::LEAD
    * - ElementType::COMPANY
    * - ElementType::CUSTOMER
    * - ElementType::NONE
    *
    * @param int $element_type тип привязываемого элемента
    * @return  self
    */
   public function setElementType($element_type)
   {
      if (!is_numeric($element_type)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      } elseif (
         $element_type != ElementType::CONTACT     &&
         $element_type != ElementType::LEAD        &&
         $element_type != ElementType::COMPANY     &&
         $element_type != ElementType::CUSTOMER    &&
         $element_type != ElementType::NONE
      ) {
         throw new AmoCRMException('Передаваемый тип не найден');
      }
      $this->element_type = $element_type;

      return $this;
   }

   /**
    * Получить дату, до которой необходимо завершить задачу (Unix)
    * @return int
    */
   public function getCompleteTill()
   {
      return $this->complete_till;
   }

   /**
    * Получить дату, до которой необходимо завершить задачу
    *
    * @param string $complete_till Дата, до которой необходимо завершить задачу - '10.06.1997' или '+10 minutes'
    * @return  self
    */
   public function setCompleteTill($complete_till)
   {
      $date = strtotime($complete_till);
      if ($date === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }
      $this->complete_till = $date;

      return $this;
   }

   /**
    * Получить тип задачи
    * @return int
    */
   public function getTaskType()
   {
      return $this->task_type;
   }

   /**
    * Задать тип задачи
    * - TaskType::CALL
    * - TaskType::MEET
    * - TaskType::MAIL
    * @param int $task_type
    * @return  self
    */
   public function setTaskType($task_type)
   {
      if (!is_numeric($task_type)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->task_type = $task_type;

      return $this;
   }

   /**
    * Получить текст задачи
    * @return string
    */
   public function getText()
   {
      return $this->text;
   }

   /**
    * Задать текст задачи
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
    * Получить дату создания данной задачи (Unix)
    * @return int
    */
   public function getCreatedAt()
   {
      return $this->created_at;
   }

   /**
    * Задать дату создания данной задачи
    * @param string $created_at Дата создания данной задачи - '10.06.1997' или '+10 minutes'
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
    * Получить дату последнего изменения данной задачи (Unix)
    * @return int
    */
   public function getUpdatedAt()
   {
      return $this->updated_at;
   }

   /**
    * Задать дату последнего изменения данной задачи (Unix)
    * @param string $updated_at Дата последнего изменения данной задачи - '10.06.1997' или '+10 minutes'
    * @return  self
    */
   public function setUpdatedAt($updated_at)
   {
      $date = strtotime($updated_at);
      if ($date === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }
      $this->updated_at = $date;

      return $this;
   }

   /**
    * Получить уникальный идентификатор ответственного пользователя
    * @return int
    */
   public function getResponsibleUserId()
   {
      return $this->responsible_user_id;
   }

   /**
    * Задать уникальный идентификатор ответственного пользователя
    * @param int $responsible_user_id уникальный идентификатор ответственного пользователя
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

   /**
    * Получить завершена задача или нет
    * @return bool
    */
   public function getIsCompleted()
   {
      return $this->is_completed;
   }

   /**
    * Задать завершена задача или нет
    * @param bool $is_completed завершена задача или нет
    * @return  self
    */
   public function setIsCompleted($is_completed)
   {
      if (!is_bool($is_completed)) {
         throw new AmoCRMException('Передаваемая переменная не является булевой');
      }
      $this->is_completed = $is_completed;

      return $this;
   }

   /**
    * Получить уникальный идентификатор создателя задачи
    * @return int
    */
   public function getCreatedBy()
   {
      return $this->created_by;
   }

   /**
    * Задать уникальный идентификатор создателя задачи
    * @param int $created_by уникальный идентификатор создателя задачи
    * @return  self
    */
   public function setCreatedBy($created_by)
   {
      if (!is_numeric($created_by)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->created_by = $created_by;

      return $this;
   }

   /**
    * Получить дату до которой необходимо завершить задачу (UNIX / Только для созданных задач)
    * @return int
    */
   public function getCompleteTillAt()
   {
      return $this->complete_till_at;
   }

   /**
    * Получить уникальный идентификатор аккаунта
    * @return int
    */
   public function getAccountId()
   {
      return $this->account_id;
   }

   /**
    * Получить id группы в которой состоит пользователь имеющей отношение к задаче
    * @return int
    */
   public function getGroupId()
   {
      return $this->group_id;
   }

   protected function checkFields($type)
   {
      parent::checkFields($type);
      switch ($type) {
         case 'update':
            if ($this->updated_at == null) {
               throw new AmoCRMException('Дата последнего изменения данной задачи не указана');
            }
            if ($this->text == null) {
               throw new AmoCRMException('Текст задачи не указан');
            }
            break;
      }
   }
}
