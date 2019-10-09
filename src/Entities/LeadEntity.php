<?php

namespace AmoCRM\Entities;

use AmoCRM\Models\ContactModel;

class LeadEntity extends BaseEntity
{

   protected $name;
   protected $responsible_user_id;
   protected $created_by;
   protected $created_at;
   protected $updated_at;
   protected $account_id;
   protected $updated_by;
   protected $pipeline_id;
   protected $status_id;
   protected $is_deleted;
   protected $main_contact;
   protected $group_id;
   protected $company;
   protected $closed_at;
   protected $closest_task_at;
   protected $tags = array();
   protected $custom_fields;
   protected $sale;
   protected $loss_reason_id;
   protected $contacts;
   protected $pipeline;
   protected $contacts_id;

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
         $this->pipeline_id = $entity['pipeline_id'];
         $this->status_id = $entity['status_id'];
         $this->is_deleted = $entity['is_deleted'];
         $this->main_contact = $entity['main_contact'];
         $this->group_id = $entity['group_id'];
         $this->company = $entity['company'];
         $this->closed_at = $entity['closed_at'];
         $this->closest_task_at = $entity['closest_task_at'];
         foreach ($entity['tags'] as $item) {
            $this->tags[] = $item['name'];
         }
         $this->custom_fields = $entity['custom_fields'];
         $this->sale = $entity['sale'];
         $this->loss_reason_id = $entity['loss_reason_id'];
         $this->contacts = $entity['contacts'];

         $this->pipeline = $entity['pipeline'];
      }
   }

   public function setName($name)
   {
      $this->name = $name;
      return $this;
   }

   public function setResponsibleUser($user)
   {
      $this->responsible_user_id = $user;
      return $this;
   }

   public function setStatus($status)
   {
      if ($status instanceof StatusEntity) {
         $this->status_id = $status->getId();
      } else {
         $this->status_id = $status;
      }
      return $this;
   }

   public function setSale($sale)
   {
      $this->sale = $sale;
      return $this;
   }

   public function addTags($tags)
   {
      $tags = explode(',', $tags);
      foreach ($tags as $item) {
         if (array_search($item, $this->tags) === false) {
            $this->tags[] = trim($item);
         }
      }
      return $this;
   }

   public function removeTags($tags)
   {
      $tags = explode(',', $tags);
      foreach ($tags as $item) {
         $a = array_search($item, $this->tags);
         if ($a !== false) {
            unset($this->tags[$a]);
         }
      }
      return $this;
   }

   public function removeAllTags()
   {
      $this->tags = array('');
      return $this;
   }

   public function getMainContact()
   {
      if (!isset($this->main_contact)) return false;
      return $this->main_contact['id'];
   }

   private function addCustomField($id, $values)
   {
      $this->custom_fields[] = array(
         'id' => $id,
         'values' => $values
      );
   }

   public function setCustomFiled($id, $value)
   {
      foreach ($this->custom_fields as $key => $custom_field) {
         if ($custom_field['id'] == $id) {
            debug($value);
            $this->custom_fields[$key]['values'] = $value;
            return;
         }
      }
      $this->addCustomField($id, $value);
   }

   public function setContacts($contacts)
   {
      $this->contacts_id = $contacts;
   }
}
