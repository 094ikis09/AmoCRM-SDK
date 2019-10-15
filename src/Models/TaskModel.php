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

   public function getTaskById($id)
   {

      return new TaskEntity($this->client->call('/api/v2/tasks', array('id' => $id))['_embedded']['items'][0]);
   }

   public function updateTasks($tasks)
   {
      $temp['update'] = array();
      if (is_array($tasks)) {
         foreach ($tasks as $item) {
            if ($item instanceof TaskEntity) {
               $temp['update'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['update'][] = $tasks->generateQuery();
      }
      debug($temp);
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

   public function getTasksFromElement($id)
   {
      $temp = array();
      $tasks = $this->client->call('/api/v2/tasks', array('element_id' => $id));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }
}
