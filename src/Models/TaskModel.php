<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\BaseEntity;
use AmoCRM\Entities\TaskEntity;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Модель для работы с задачами
 */
class TaskModel extends BaseModel
{

   /**
    * Создание задач (по одной или пакетно)
    *
    * @param TaskEntity|TaskEntity[] $tasks
    * @return array ответ от AmoCRM
    */
   public function createTasks($tasks)
   {
      $temp['add'] = array();
      if (is_array($tasks)) {
         foreach ($tasks as $item) {
            if (!($item instanceof TaskEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является TaskEntity');
            }
            $temp['add'][] = $item->generateQuery();
         }
      } else {
         if (!($tasks instanceof TaskEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является TaskEntity');
         }
         $temp['add'][] = $tasks->generateQuery();
      }
      return $this->client->call(
         '/api/v2/tasks',
         'GET',
         true,
         false,
         false,
         array(),
         $temp
      );
   }

   /**
    * Обновление задач (по одной или пакетно)
    *
    * @param TaskEntity|TaskEntity[] $tasks
    * @return array ответ от AmoCRM
    */
   public function updateTasks($tasks)
   {
      $temp['update'] = array();
      if (is_array($tasks)) {
         foreach ($tasks as $item) {
            if (!($item instanceof TaskEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является TaskEntity');
            }
            $temp['update'][] = $item->generateQuery('update');
         }
      } else {
         if (!($tasks instanceof TaskEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является TaskEntity');
         }
         $temp['update'][] = $tasks->generateQuery('update');
      }
      return $this->client->call(
         '/api/v2/tasks',
         'POST',
         true,
         false,
         array(),
         $temp
      );
   }

   /**
    * Удалить задачи (по одной или пакетно)
    *
    * @param TaskEntity|TaskEntity[] $tasks
    * @return array ответ от AmoCRM
    */
   public function deleteTasks($tasks)
   {
      $temp['request']['multiactions']['add'][0] = array(
         'entity_type' => 4,
         'multiaction_type' => 4,
         'data' => array(
            'data' => array(
               'ACTION' => 'DELETE'
            )
         )
      );
      if (is_array($tasks)) {
         foreach ($tasks as $item) {
            if (!($item instanceof TaskEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является TaskEntity');
            }
            $temp['request']['multiactions']['add'][0]['ids'][] = $item->getId();
         }
      } else {
         if (!($tasks instanceof TaskEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является TaskEntity');
         }
         $temp['request']['multiactions']['add'][0]['ids'][] = $tasks->getId();
      }
      return $this->client->call(
         '/ajax/v1/multiactions/set/',
         'POST',
         true,
         true,
         false,
         array(),
         $temp
      );
   }

   /**
    * Получить задачи с возможностью фильтрации и постраничной выборки
    *
    * @param int|null $id Выбрать элемент с заданным id
    * @param int|null $limit_rows
    * @param int|null $limit_offset
    * @param int|BaseEntity|null $element_id
    * @param int|null $responsible_user_id
    * @param int|null $type
    * @param array $filter
    * @return array Ответ от AmoCRM
    */
   public function getTasks(
      $id = null,
      $limit_rows = null,
      $limit_offset = null,
      $element_id = null,
      $responsible_user_id = null,
      $type = null,
      array $filter = array(),
      $return_array = true
   ) {
      $get = array();
      if ($id != null) {
         if (!is_numeric($id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $get['id'] = $id;
      }
      if ($limit_rows != null) {
         if (!is_numeric($limit_rows)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $get['limit_rows'] = $limit_rows;
      }
      if ($limit_offset != null) {
         if ($limit_rows == null) {
            throw new AmoCRMException('Для указания limit_offset требуется указать limit_rows');
         }
         if (!is_numeric($limit_offset)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $get['limit_offset'] = $limit_offset;
      }
      if ($element_id != null) {
         if (!($element_id instanceof BaseEntity)) {
            if (!is_numeric($element_id)) {
               throw new AmoCRMException('Передаваемая переменная не является числом или типом BaseEntity');
            }
            $get['element_id'] = $element_id;
         } else {
            $get['element_id'] = $element_id->getId();
         }
      }
      if ($responsible_user_id != null) {
         if (!is_numeric($responsible_user_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $get['responsible_user_id'] = $responsible_user_id;
      }
      if ($type != null) {
         if (!is_numeric($type)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
         }
         $get['type'] = $type;
      }
      if (count($filter) > 0) {
         if (isset($filter['date_create'])) {
            if (!isset($filter['date_create']['from'])) {
               throw new AmoCRMException('Передаваемый массив не содержит ключ from');
            } else {
               $date = strtotime($filter['date_create']['from']);
               if ($date === false) {
                  throw new AmoCRMException('Задан не верный формат даты');
               }
            }
            if (!isset($filter['date_create']['to'])) {
               throw new AmoCRMException('Передаваемый массив не содержит ключ to');
            } else {
               $date = strtotime($filter['date_create']['to']);
               if ($date === false) {
                  throw new AmoCRMException('Задан не верный формат даты');
               }
            }
         }
         if (isset($filter['date_modify'])) {
            if (!isset($filter['date_modify']['from'])) {
               throw new AmoCRMException('Передаваемый массив не содержит ключ from');
            } else {
               $date = strtotime($filter['date_modify']['from']);
               if ($date === false) {
                  throw new AmoCRMException('Задан не верный формат даты');
               }
            }
            if (!isset($filter['date_modify']['to'])) {
               throw new AmoCRMException('Передаваемый массив не содержит ключ to');
            } else {
               $date = strtotime($filter['date_modify']['to']);
               if ($date === false) {
                  throw new AmoCRMException('Задан не верный формат даты');
               }
            }
         }
         if (isset($filter['pipe'])) {
            foreach ($filter['pipe'] as $key => $value) {
               if (!is_numeric($key)) {
                  throw new AmoCRMException('Передаваемая переменная не является числом');
               }
               if (!is_numeric($value)) {
                  throw new AmoCRMException('Передаваемая переменная не является числом');
               }
            }
         }
         if (isset($filter['status'])) {
            if (count($filter['status'] > 1 || count($filter['status']) < 1)) {
               throw new AmoCRMException('Указанно несколько статусов');
            }
            if (!is_numeric($filter['status'][0])) {
               throw new AmoCRMException('Передаваемая переменная не является числом');
            }
         }
         if (isset($filter['created_by'])) {
            foreach ($filter['created_by'] as $value) {
               if (!is_numeric($value)) {
                  throw new AmoCRMException('Передаваемая переменная не является числом');
               }
            }
         }
         if (isset($filter['task_type'])) {
            foreach ($filter['task_type'] as $value) {
               if (!is_numeric($value)) {
                  throw new AmoCRMException('Передаваемая переменная не является числом');
               }
            }
         }
         $get['filter'] = $filter;
      }

      $temp = array();
      $tasks = $this->client->call(
         '/api/v2/tasks',
         'GET',
         true,
         false,
         false,
         $get
      );
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      if ($return_array) {
         return $temp;
      } else {
         if (count($temp) < 1) {
            return null;
         }
         return $temp[0];
      }
   }

   /**
    * Получить задачу по уникальному индификатору
    *
    * @param int $id
    * @return TaskEntity|null
    */
   public function getTaskById($id)
   {
      return $this->getTasks($id, null, null, null, null, null, array(), false);
   }

   /**
    * Получить задачи указанного элемента
    *
    * @param int|BaseEntity $element
    * @param int|null $limit_rows
    * @param int|null $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksFromElement($element, $limit_rows = null, $limit_offset = null)
   {
      if ($element == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }

      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, $element);
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи ответственного пользователя
    *
    * @param int $responsible_user_id
    * @param int|null $limit_rows
    * @param int|null $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByResponsibleUser($responsible_user_id, $limit_rows = null, $limit_offset = null)
   {
      if ($responsible_user_id == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }

      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, $responsible_user_id);
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи определенных сущностей
    *
    * @param int $element_type
    * @param int|null $limit_rows
    * @param int|null $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByElementType($element_type, $limit_rows = null, $limit_offset = null)
   {
      if ($element_type == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, $element_type);
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи по дате создания
    *
    * @param string $from
    * @param string $to
    * @param int|null $limit_rows
    * @param int|null $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByDateCreate($from, $to, $limit_rows = null, $limit_offset = null)
   {
      if ($from == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      if ($to == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, null, array('date_create' => array('from' => $from, 'to' => $to)));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи по дате изминения
    *
    * @param string $from
    * @param string $to
    * @param int|null $limit_rows
    * @param int|null $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByDateModify($from, $to, $limit_rows = null, $limit_offset = null)
   {
      if ($from == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      if ($to == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, null, array('date_modify' => array('from' => $from, 'to' => $to)));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи по статусам сделки
    *
    * @param array $pipe
    * @param int $limit_rows
    * @param int $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByPipe(array $pipe, $limit_rows = null, $limit_offset = null)
   {
      if ($pipe == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, null, array('pipe' => $pipe));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи по их статусу
    *
    * @param array $status
    * @param int $limit_rows
    * @param int $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByStatus(array $status, $limit_rows = null, $limit_offset = null)
   {
      if ($status == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, null, array('status' => $status));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи по создавшему их пользователю
    *
    * @param array $users
    * @param int $limit_rows
    * @param int $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByCreatedUsers(array $users, $limit_rows = null, $limit_offset = null)
   {
      if ($users == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, null, array('created_by' => $users));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить задачи по их типу
    *
    * @param array $task_type
    * @param int $limit_rows
    * @param int $limit_offset
    * @return TaskEntity[]
    */
   public function getTasksByTaskType(array $task_type, $limit_rows = null, $limit_offset = null)
   {
      if ($task_type == null) {
         throw new AmoCRMException('Передаваемая переменная не может быть null');
      }
      $temp = array();
      $tasks = $this->getTasks(null, $limit_rows, $limit_offset, null, null, null, array('task_type' => $task_type));
      foreach ($tasks['_embedded']['items'] as $item) {
         $temp[] = new TaskEntity($item);
      }
      return $temp;
   }

   /**
    * Получить типы задач
    *
    * @return array типы задач
    */
   public function getTaskTypes()
   {
      $types = $this->client->call(
         '/ajax/tasks/types',
         'GET',
         true,
         true
      );
      $temp = array();
      foreach ($types as $item) {
         $temp[] = array('id' => $item['id'], 'name' => $item['option']);
      }
      return $temp;
   }

   /**
    * Получить тип задачи по названию
    *
    * @param string $name
    * @return array типы задач
    */
   public function getTaskTypeByName($name)
   {
      $types = $this->client->call(
         '/ajax/tasks/types',
         'GET',
         true,
         true
      );
      $temp = array();
      foreach ($types as $item) {
         if ($name == $item['option'])
            $temp[] = array('id' => $item['id'], 'name' => $item['option']);
      }
      return $temp;
   }
}
