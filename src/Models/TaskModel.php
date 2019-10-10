<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\TaskEntity;

class TaskModel extends BaseModel
{
   public function createTasks($tasks)
   {
      $temp['add'] = array();
      if (is_array($tasks)) {
         foreach ($tasks as $item) {
            if ($item instanceof TaskEntity) {
               $temp['add'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['add'][] = $tasks->generateQuery();
      }
      return $this->client->call('/api/v2/tasks', array(), $temp);
   }

   public function getTaskTypes()
   {
      $types = $this->client->call('/ajax/tasks/types', array(), array(), null, true);
      $temp = array();
      foreach ($types as $item) {
         $temp[] = array('id' => $item['id'], 'name' => $item['option']);
      }
      return $temp;
   }

   public function getTaskTypeByName($name)
   {
      $types = $this->client->call('/ajax/tasks/types', array(), array(), null, true);
      $temp = array();
      foreach ($types as $item) {
         if ($name == $item['option'])
            $temp[] = array('id' => $item['id'], 'name' => $item['option']);
      }
      return $temp;
   }
}
