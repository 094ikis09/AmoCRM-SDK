<?php

namespace AmoCRM\Entities;

/**
 * Сущность компании
 */
class CompanyEntity extends BaseEntity
{
   protected
      $name,
      $created_at,
      $updated_at,
      $responsible_user_id,
      $created_by,
      $tags,
      $leads_id,
      $customers_id,
      $contacts_id,
      $custom_fields,
      $unlink;

   private
      $account_id,
      $updated_by,
      $group_id,
      $contacts,
      $leads,
      $closest_task_at,
      $customers;

   public function __construct($entity = null)
   {
      if (is_array($entity)) {
         $this->id = $entity['id'];
         $this->name = $entity['name'];
         $this->responsible_user_id = $entity['responsible_user_id'];
         $this->created_by = $entity['created_by'];
         $this->created_at = $entity['created_at'];
         $this->updated_at = $entity['updated_at'];
         $this->account_id = $entity['account_id'];
         $this->updated_by = $entity['updated_by'];
         $this->group_id = $entity['group_id'];
         $this->contacts = $entity['contacts'];
         $this->leads = $entity['leads'];
         $this->closest_task_at = $entity['closest_task_at'];
         $this->tags = $entity['tags'];
         foreach ($entity['custom_fields'] as $item) {
            $this->custom_fields[$item['id']] = $item;
         }
         $this->customers = $entity['customers'];
      }
   }

   /**
    * Получить название компании
    * @return string|null
    */
   public function getName()
   {
      return $this->name;
   }

   /**
    * Задать название компании
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
    * Получить дату и время создания компании
    * @return int|null
    */
   public function getCreatedAt()
   {
      return $this->created_at;
   }

   /**
    * Задать дату и время создания компании
    * @param string $created_at
    * @return  self
    */
   public function setCreatedAt($created_at)
   {
      $created_at = strtotime($created_at);
      if ($created_at === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }

      $this->created_at = $created_at;

      return $this;
   }

   /**
    * Получить дату и время последнего изменения
    * @return int|null
    */
   public function getUpdatedAt()
   {
      return $this->updated_at;
   }

   /**
    * Задать дату и время последнего изменения
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
    * Получить id ответственного за компанию
    * @return int|null
    */
   public function getResponsibleUserId()
   {
      return $this->responsible_user_id;
   }

   /**
    * Задать ответственного за компанию
    * @param int $responsible_user_id
    * @return  self
    */
   public function setResponsibleUserId($responsible_user_id)
   {
      $this->responsible_user_id = $responsible_user_id;

      return $this;
   }

   /**
    * Получить id пользователя создавшего компанию
    * @return int|null
    */
   public function getCreatedBy()
   {
      return $this->created_by;
   }

   /**
    * Задать id пользователя создавшего компанию
    * @return int|null
    */
   public function setCreatedBy()
   {
      return $this->created_by;
   }

   /**
    * Получить тэги компании
    * @return string[]|null
    */
   public function getTags()
   {
      return $this->tags;
   }

   /**
    * Задать тэги компании
    * @param string[] $tags
    * @return  self
    */
   public function setTags($tags)
   {
      if (!is_array($tags)) {
         throw new AmoCRMException('Передаваемая переменная не является массивом');
      }
      $this->tags = implode(',', $tags);

      return $this;
   }

   /**
    * Получить Массив сделок, привязываемых к компании.
    * @return int[]
    */
   public function getLeadsId()
   {
      return $this->leads_id;
   }

   /**
    * Задать Массив сделок, привязываемых к компании.
    * @param int[] $leads_id
    * @return  self
    */
   public function setLeadsId($leads_id)
   {
      if (!is_array($leads_id)) {
         throw new AmoCRMException('Передаваемая переменная не является массивом');
      }
      $this->leads_id = $leads_id;

      return $this;
   }

   /**
    * Получить Покупателей
    * @return string
    */
   public function getCustomersId()
   {
      return $this->customers_id;
   }

   /**
    * Задать Покупателей
    * @param string $customers_id
    * @return self
    */
   public function setCustomersId($customers_id)
   {
      if (!is_string($customers_id)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->customers_id = $customers_id;

      return $this;
   }

   /**
    * Получить список id контактов прикрепленных к компании
    * @return int|null
    */
   public function getContactsId()
   {
      return $this->contacts_id;
   }

   /**
    * Задать список id контактов прикрепленных к компании
    * @param int[] $contacts_id
    * @return  self
    */
   public function setContactsId($contacts_id)
   {
      $this->contacts_id = $contacts_id;

      return $this;
   }

   /**
    * Установка значения кастомного поля
    *
    * @param int $id
    * @param mixed $value
    * @param mixed $enum
    * @param mixed $subtype
    * @return self
    */
   public function setCustomField($id, $value, $enum = false, $subtype = false)
   {
      $field = array(
         'id' => $id,
         'values' => array(),
      );

      if (!is_array($value)) {
         $values = array(
            array(
               $value,
               $enum
            )
         );
      } else {
         $values = $value;
      }
      foreach ($values as $val) {
         list($value, $enum) = $val;
         $fieldValue = [
            'value' => $value,
         ];
         if ($enum !== false) {
            $fieldValue['enum'] = $enum;
         }
         if ($subtype !== false) {
            $fieldValue['subtype'] = $subtype;
         }
         $field['values'][] = $fieldValue;
      }
      if (!is_array($this->custom_fields[$id])) {
         $this->custom_fields[$id] = array();
      }
      $this->custom_fields[$id] = array_merge($this->custom_fields[$id], $field);
      return $this;
   }

   /**
    * Установка значения кастомного поля типа мультиселект
    *
    * @param int $id
    * @param int|array $values
    * @return self
    */
   public function setCustomMultiField($id, $values)
   {
      $field = [
         'id' => $id,
         'values' => [],
      ];
      if (!is_array($values)) {
         $values = [$values];
      }
      $field['values'] = $values;
      if (!is_array($this->custom_fields[$id])) {
         $this->custom_fields[$id] = array();
      }
      debug($this->custom_fields[$id]);
      $this->custom_fields[$id] = array_merge($this->custom_fields[$id], $field);
      debug($this->custom_fields[$id]);
      return $this;
   }

   /**
    * Получить значение кастомного поля
    *
    * @param int $id
    * @return array|null
    */
   public function getCustomFieldValues($id)
   {
      return $this->custom_fields[$id]['values'];
   }

   /**
    * Открепить покупателей
    *
    * @param array $customers_id
    * @return self
    */
   public function unlinkCustomers(array $customers_id)
   {
      $this->unlink['customers_id'] = $customers_id;
      return $this;
   }

   /**
    * Открепить контакты
    *
    * @param array $contacts_id
    * @return self
    */
   public function unlinkContacts(array $contacts_id)
   {
      $this->unlink['contacts_id'] = $contacts_id;
      return $this;
   }

   /**
    * Открепить сделки
    *
    * @param array $leads
    * @return self
    */
   public function unlinkLeads(array $leads_id)
   {
      $this->unlink['leads_id'] = $leads_id;
      return $this;
   }

   /**
    * Получить id аккаунта
    * @return int|null
    */
   public function getAccountId()
   {
      return $this->account_id;
   }

   /**
    * Получить id пользователя обновившего компанию
    * @return int|null
    */
   public function getUpdatedBy()
   {
      return $this->updated_by;
   }

   /**
    * Получить id группы
    * @return int|null
    */
   public function getGroupId()
   {
      return $this->group_id;
   }

   /**
    * Получить контакты
    * @return array|null
    */
   public function getContacts()
   {
      return $this->contacts;
   }

   /**
    * Получить Массив, содержащий информацию о сделках, которые прикреплены к данной компании
    * @return array|null
    */
   public function getLeads()
   {
      return $this->leads;
   }

   /**
    * Получить время ближайщей задачи
    * @return int|null
    */
   public function getClosestTaskAt()
   {
      return $this->closest_task_at;
   }

   /**
    * Получить Массив, содержащий информацию о покупателях, которые прикреплены к данной компании
    *
    * @return array|null
    */
   public function getCustomers()
   {
      return $this->customers;
   }
}
