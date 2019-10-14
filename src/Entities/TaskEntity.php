<?php

namespace AmoCRM\Entities;

class TaskEntity extends BaseEntity
{

   const TASK_TYPE_CALL = 1;
   const TASK_TYPE_MEET = 2;
   const TASK_TYPE_MAIL = 3;

   protected $task_type;
   protected $complete_till;
   private $complete_till_at;
   protected $text;
   protected $responsible_user_id;

   public function __construct($entity = null)
   {
      if (is_array($entity)) {
         $this->task_type = $entity['task_type'];
         $this->complete_till_at = $entity['complete_till_at'];
         $this->text = $entity['text'];
         $this->responsible_user_id = $entity['responsible_user_id'];
      }
   }

   /**
    * Set the value of task_type
    *
    * @return  self
    */
   public function setTaskType($task_type)
   {
      $this->task_type = $task_type;

      return $this;
   }

   /**
    * Set the value of complete_till
    *
    * @return  self
    */
   public function setCompleteTill($complete_till)
   {
      $this->complete_till = strtotime($complete_till);

      return $this;
   }

   /**
    * Set the value of text
    *
    * @return  self
    */
   public function setText($text)
   {
      $this->text = $text;

      return $this;
   }

   /**
    * Set the value of responsible_user_id
    *
    * @return  self
    */
   public function setResponsibleUserId($responsible_user_id)
   {
      $this->responsible_user_id = $responsible_user_id;

      return $this;
   }
}
