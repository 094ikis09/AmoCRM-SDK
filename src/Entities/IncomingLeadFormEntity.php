<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность неразобранного с типом веб-форма
 */
class IncomingLeadFormEntity extends BaseEntity
{

   protected
      $source_name,
      $source_uid,
      $created_at,
      $pipeline_id,
      $incoming_lead_info = array(
         'form_id' => null,
         'form_page' => null,
         'ip' => null,
         'service_code' => null,
         'form_name' => null,
         'form_send_at' => null,
         'referer' => null,
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
    * Получить uid источника заявки
    * @return string|null
    */
   public function getSourceUid()
   {
      return $this->source_uid;
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
    * Получить Идентификатор формы
    *
    * @return int|null
    */
   public function getIncomingLeadInfoFormId()
   {
      return $this->incoming_lead_info['from_id'];
   }

   /**
    * Задать Идентификатор формы
    *
    * @param int $from_id
    * @return self
    */
   public function setIncomingLeadInfoFormId($from_id)
   {
      if (!is_numeric($from_id)) {
         throw new AmoCRMException('Передаваемая переменная не является числом');
      }
      $this->incoming_lead_info['from_id'] = $from_id;
      return $this;
   }

   /**
    * Получить Адрес страницы, на котором расположена форма
    *
    * @return string|null
    */
   public function getIncomingLeadInfoFormPage()
   {
      return $this->incoming_lead_info['form_page'];
   }

   /**
    * Задать Адрес страницы, на котором расположена форма
    *
    * @param string $form_page
    * @return self
    */
   public function setIncomingLeadInfoFormPage($form_page)
   {
      if (!is_string($form_page)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->incoming_lead_info['form_page'] = $form_page;
      return $this;
   }

   /**
    * Получить IP адрес, с которого поступила заявка
    *
    * @return string|null
    */
   public function getIncomingLeadInfoIp()
   {
      return $this->incoming_lead_info['ip'];
   }

   /**
    * Задать IP адрес, с которого поступила заявка
    *
    * @param string $ip
    * @return self
    */
   public function setIncomingLeadInfoIp($ip)
   {
      if (!is_string($ip)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->incoming_lead_info['ip'] = $ip;
      return $this;
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
    * Получить Название формы
    *
    * @return string|null
    */
   public function getIncomingLeadInfoFormName()
   {
      return $this->incoming_lead_info['form_name'];
   }

   /**
    * Задать Название формы
    *
    * @param string $form_name
    * @return self
    */
   public function setIncomingLeadInfoFormName($form_name)
   {
      if (!is_string($form_name)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->incoming_lead_info['form_name'] = $form_name;
      return $this;
   }

   /**
    * Получить Дата и время отправки данных через форму
    *
    * @return int|null
    */
   public function getIncomingLeadInfoLink()
   {
      return $this->incoming_lead_info['form_send_at'];
   }

   /**
    * Задать Дата и время отправки данных через форму
    *
    * @param string $form_send_at
    * @return self
    */
   public function setIncomingLeadInfoLink($form_send_at)
   {
      $form_send_at = strtotime($form_send_at);
      if ($form_send_at === false) {
         throw new AmoCRMException('Задан не верный формат даты');
      }

      $this->incoming_lead_info['form_send_at'] = $form_send_at;
      return $this;
   }

   /**
    * Получить информацию откуда был переход на страницу, где расположена форма.
    *
    * @return string|null
    */
   public function getIncomingLeadInfoReferer()
   {
      return $this->incoming_lead_info['referer'];
   }

   /**
    * Задать информацию откуда был переход на страницу, где расположена форма.
    *
    * @param string $referer
    * @return self
    */
   public function setIncomingLeadInfoReferer($referer)
   {
      if (!is_string($referer)) {
         throw new AmoCRMException('Передаваемая переменная не является строкой');
      }

      $this->incoming_lead_info['referer'] = $referer;
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
}
