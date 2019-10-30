<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность неразобранного с типом входящий звонок
 */
class IncomingLeadSipEntity extends BaseEntity
{

   protected
      $source_name,
      $source_uid,
      $created_at,
      $pipeline_id,
      $incoming_lead_info = array(
         'to' => null,
         'from' => null,
         'date_call' => null,
         'service_code' => null,
         'duration' => null,
         'link' => null,
         'add_note' => null,
      ),
      $incoming_entities = array(
         'leads' => array(),
         'contacts' => array(),
         'companies' => array()
      );

   private
      $category,
      $uid;

   public function __construct($entity = null)
   {
      if (is_array($entity)) {
         $this->category = $entity['category'];
         $this->uid = $entity['uid'];
         $this->created_at = $entity['created_at'];
         $this->source_uid = $entity['source_uid'];
         $this->incoming_lead_info = $entity['incoming_lead_info'];
         $this->incoming_entities = $entity['incoming_entities'];
      }
   }


   /**
    * Получить название источника заявки
    * @return string|null
    */
   public function getSourceName()
   {
      return $this->source_name;
   }

   /**
    * Задать название источника заявки
    * @param string $source_name
    * @return  self
    */
   public function setSourceName($source_name)
   {
      if (!is_string($source_name)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }
      $this->source_name = $source_name;
      return $this;
   }

   /**
    * Задать uid источника заявки
    * @param string $source_uid
    * @return  self
    */
   public function setSourceUid($source_uid)
   {
      if (!is_string($source_uid)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }
      $this->source_uid = $source_uid;
      return $this;
   }

   /**
    * Получить дату создания (Unix)
    * @return int|null
    */
   public function getCreatedAt()
   {
      return $this->created_at;
   }

   /**
    * Задать дату создания
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
    * Получить id воронки
    * @return int|null
    */
   public function getPipelineId()
   {
      return $this->pipeline_id;
   }

   /**
    * Задать id воронки
    * @param int $pipeline_id
    * @return  self
    */
   public function setPipelineId($pipeline_id)
   {
      if (!is_numeric($pipeline_id)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->pipeline_id = $pipeline_id;
      return $this;
   }

   /**
    * Получить ID пользователя, который принял звонок
    *
    * @return int|null
    */
   public function getIncomingLeadInfoTo()
   {
      return $this->incoming_lead_info['to'];
   }

   /**
    * Задать ID пользователя, который принял звонок
    *
    * @param int $to
    * @return self
    */
   public function setIncomingLeadInfoTo($to)
   {
      if (!is_numeric($to)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->incoming_lead_info['to'] = $to;
      return $this;
   }

   /**
    * Получить Внешний номер телефона, с которого поступил звонок
    *
    * @return string|null
    */
   public function getIncomingLeadInfoFrom()
   {
      return $this->incoming_lead_info['from'];
   }

   /**
    * Задать Внешний номер телефона, с которого поступил звонок
    *
    * @param string $from
    * @return self
    */
   public function setIncomingLeadInfoFrom($from)
   {
      if (!is_string($from)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->incoming_lead_info['from'] = $from;
      return $this;
   }

   /**
    * Получить Дату и время звонка
    *
    * @return int|null
    */
   public function getIncomingLeadInfoDateCall()
   {
      return $this->incoming_lead_info['date_call'];
   }

   /**
    * Задать Дату и время звонка
    *
    * @param string $date_call
    * @return self
    */
   public function setIncomingLeadInfoDateCall($date_call)
   {
      $date_call = strtotime($date_call);
      if ($date_call === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }
      $this->incoming_lead_info['date_call'] = $date_call;
      return $this;
   }




   /**
    * Получить Код виджета или сервиса, через который был совершён звонок.
    *
    * @return string|null
    */
   public function getIncomingLeadInfoServiceCode()
   {
      return $this->incoming_lead_info['service_code'];
   }

   /**
    * Задать Код виджета или сервиса, через который был совершён звонок.
    *
    * @param string $service_code
    * @return self
    */
   public function setIncomingLeadInfoServiceCode($service_code)
   {
      if (!is_string($service_code)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }
      $this->incoming_lead_info['service_code'] = $service_code;
      return $this;
   }

   /**
    * Получить Продолжительность звонка
    *
    * @return int|null
    */
   public function getIncomingLeadInfoDuration()
   {
      return $this->incoming_lead_info['duration'];
   }

   /**
    * Задать Продолжительность звонка
    *
    * @param int $duration
    * @return self
    */
   public function setIncomingLeadInfoDuration($duration)
   {
      if (!is_numeric($duration)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->incoming_lead_info['duration'] = $duration;
      return $this;
   }

   /**
    * Получить Ссылку на запись звонка
    *
    * @return string|null
    */
   public function getIncomingLeadInfoLink()
   {
      return $this->incoming_lead_info['link'];
   }

   /**
    * Задать Ссылку на запись звонка
    *
    * @param string $link
    * @return self
    */
   public function setIncomingLeadInfoLink($link)
   {
      if (!is_string($link)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }
      $this->incoming_lead_info['link'] = $link;
      return $this;
   }

   /**
    * Получить Флаг, если передан этот параметр, то после принятия неразобранного к сделке будет добавлено событие о совершённом звонке.
    *
    * @return bool|null
    */
   public function getIncomingLeadInfoAddNote()
   {
      return $this->incoming_lead_info['add_note'];
   }

   /**
    * Задать Флаг, если передан этот параметр, то после принятия неразобранного к сделке будет добавлено событие о совершённом звонке.
    *
    * @param bool $add_note
    * @return self
    */
   public function setIncomingLeadInfoAddNote($add_note)
   {
      if (!is_bool($add_note)) {
         throw new AmoCRMException('Передаваемая переменная не является булевой');
      }
      $this->incoming_lead_info['add_note'] = $add_note;
      return $this;
   }

   /**
    * Задать сделки
    *
    * @param LeadEntity|LeadEntity[] $leads
    * @return self
    */
   public function setIncomingEntitiesLeads($leads)
   {
      $this->incoming_entities['leads'] = array();
      if (!is_array($leads)) {
         if (!($leads instanceof LeadEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является LeadEntity');
         }
         $this->incoming_entities['leads'][] = $leads->generateQuery();
      } else {
         foreach ($leads as $item) {
            if (!($item instanceof LeadEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является LeadEntity');
            }
            $this->incoming_entities['leads'][] = $item->generateQuery();
         }
      }
      return $this;
   }

   /**
    * Задать контакты
    *
    * @param ContactEntity|ContactEntity[] $contacts
    * @return self
    */
   public function setIncomingEntitiesContacts($contacts)
   {
      $this->incoming_entities['contacts'] = array();
      if (!is_array($contacts)) {
         if (!($contacts instanceof ContactEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является ContactEntity');
         }
         $this->incoming_entities['contacts'][] = $contacts->generateQuery();
      } else {
         foreach (!$contacts as $item) {
            if (!($item instanceof ContactEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является ContactEntity');
            }
            $this->incoming_entities['contacts'][] = $item->generateQuery();
         }
      }
      return $this;
   }

   /**
    * Задать компании
    *
    * @param CompanyEntity|CompanyEntity[] $companies
    * @return self
    */
   public function setIncomingEntitiesCompanies($companies)
   {
      $this->incoming_entities['companies'] = array();
      if (!is_array($companies)) {
         if (!($companies instanceof CompanyEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является CompanyEntity');
         }
         $this->incoming_entities['companies'][] = $companies->generateQuery();
      } else {
         foreach (!$companies as $item) {
            if (!($item instanceof CompanyEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является CompanyEntity');
            }
            $this->incoming_entities['companies'][] = $item->generateQuery();
         }
      }
      return $this;
   }

   /**
    * Задать контакты
    *
    * @param ContactEntity|ContactEntity[] $contacts
    * @return self
    */
   public function setIncomingEntitiesContacts($contacts)
   {
      $this->incoming_entities['contacts'] = array();
      if (!is_array($contacts)) {
         if (!($contacts instanceof ContactEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является ContactEntity');
         }
         $this->incoming_entities['contacts'][] = $contacts->generateQuery();
      } else {
         foreach (!$contacts as $item) {
            if (!($item instanceof ContactEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является ContactEntity');
            }
            $this->incoming_entities['contacts'][] = $item->generateQuery();
         }
      }

      return $this;
   }

   /**
    * Задать компании
    *
    * @param CompanyEntity|CompanyEntity[] $companies
    * @return self
    */
   public function setIncomingEntitiesCompanies($companies)
   {
      $this->incoming_entities['companies'] = array();
      if (!is_array($companies)) {
         if (!($companies instanceof CompanyEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является CompanyEntity');
         }
         $this->incoming_entities['companies'][] = $companies->generateQuery();
      } else {
         foreach (!$companies as $item) {
            if (!($item instanceof CompanyEntity)) {
               throw new AmoCRMException('Передаваемая переменная не является CompanyEntity');
            }
            $this->incoming_entities['companies'][] = $item->generateQuery();
         }
      }

      return $this;
   }
}
