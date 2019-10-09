<?php

namespace AmoCRM\Entities;

class IncomingLeadSipEntity extends BaseEntity
{

   protected $pipeline_id;
   protected $incoming_lead_info = array(
      'to' => null,
      'from' => null,
      'date_call' => null,
      'duration' => null,
      'link' => null,
      'service_code' => null,
      'add_note' => null

   );
   protected $incoming_entities = array(
      'leads' => array(),
      'contacts' => array(),
      'companies' => array()
   );


   public function __construct($entity = null)
   { }

   /**
    * ID пользователя, который принял звонок
    *
    * @param int $int
    * @return void
    */
   public function setTo($int)
   {
      $this->incoming_lead_info['to'] = $int;
      return $this;
   }

   public function setFrom($string)
   {
      $this->incoming_lead_info['from'] = $string;
      return $this;
   }

   public function setDateCall($date)
   {
      $this->incoming_lead_info['date_call'] = strtotime($date);
      return $this;
   }

   public function setServiceCode($service_code)
   {
      $this->incoming_lead_info['service_code'] = strtotime($service_code);
      return $this;
   }
}
