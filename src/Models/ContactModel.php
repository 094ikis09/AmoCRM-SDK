<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\ContactEntity;

class ContactModel extends BaseModel
{

   /**
    * Undocumented function
    *
    * @param [type] $query
    * @return ContactEntity
    */
   public function getContacts($query = null)
   {
      $contacts = $this->client->call('/api/v2/contacts', array('query' => $query));
      $temp = array();
      foreach ($contacts['_embedded']['items'] as $item) {
         $temp[] = new ContactEntity($item);
      }
      return $temp;
   }

   public function getContactById($id)
   {
      $contacts = $this->client->call('/api/v2/contacts', array('id' => $id));
      if (!isset($contacts['_embedded']['items'])) return false;
      return new ContactEntity($contacts['_embedded']['items'][0]);
   }

   public function updateContact($contacts)
   {
      $temp['update'] = array();
      if (is_array($contacts)) {
         foreach ($contacts as $item) {
            if ($item instanceof ContactEntity) {
               $temp['update'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['update'][] = $contacts->generateQuery();
      }
      return $this->client->call('/api/v2/contacts', array(), $temp);
   }

   public function createContact($contacts)
   {
      $temp['add'] = array();
      if (is_array($contacts)) {
         foreach ($contacts as $item) {
            if ($item instanceof ContactEntity) {
               $temp['add'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['add'][] = $contacts->generateQuery();
      }
      return $this->client->call('/api/v2/contacts', array(), $temp);
   }
}
