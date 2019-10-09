<?php

namespace AmoCRM\CustomField;

use AmoCRM\Account\AccountController;
use AmoCRM\AmoCRMController;
use AmoCRM\Contracts\iAmoCRM;
use AmoCRM\Exceptions\AmoCRMException;


class CustomFieldsController extends AmoCRMController
{

   const
      CF_ET_CONTACTS = 'contacts',
      CF_ET_LEADS = 'leads',
      CF_ET_COMPANIES = 'companies',
      CF_ET_CUSTOMERS = 'customers';

   private $origin;

   /**
    * @var CreateableCustomFieldEntity[] $creatable_custom_fileds
    */
   private $creatable_custom_fileds;

   /**
    * @var CustomFieldEntity[] $deleted_custom_fields
    */
   private $deleted_custom_fields;

   /**
    *
    *
    * @param String $element_type
    * @return CustomFieldEntity[]
    */
   public function getCustomFields(String $element_type = null)
   {
      $temp = new AccountController($this->client);
      $temp->getAccountInfo($temp::INFO_CUSTOMFIELDS);
      if (null === $element_type) {
         $t = [];
         foreach ($temp->getCustomFields() as $key => $value) {
            foreach ($value as $key => $value) {
               $t[] = $value;
            }
         }
         return $t;
      }
      $t = [];
      $temp = $temp->getCustomFields();
      if (isset($temp[$element_type]))
         foreach ($temp[$element_type] as $key => $value) {
            $t[] = $value;
         }
      return $t;
   }

   /**
    * Undocumented function
    *
    * @param Int $id
    * @param String $element_type
    * @return bool|CustomFieldEntity
    */
   public function findCustomFieldById(Int $id, String $element_type = null)
   {
      $temp = new AccountController($this->client);
      $temp->getAccountInfo($temp::INFO_CUSTOMFIELDS);
      if (null === $element_type) {
         foreach ($temp->getCustomFields() as $key => $value) {
            if (isset($value[$id])) return $value[$id];
         }
         return false;
      }
      $temp = $temp->getCustomFields()[$element_type];
      if (isset($temp[$id])) return $temp[$id];
      return false;
   }

   /**
    * Undocumented function
    *
    * @param String $name
    * @param String $element_type
    * @return CustomFieldEntity[]
    */
   public function findCustomFieldByName(String $name, String $element_type = null)
   {
      $t = [];
      $temp = new AccountController($this->client);
      $temp->getAccountInfo($temp::INFO_CUSTOMFIELDS);
      if (null === $element_type) {
         foreach ($temp->getCustomFields() as $key => $value) {
            foreach ($value as $key => $value) {
               // debug($value->name);
               if ($value->name == $name)
                  $t[] = $value;
            }
         }
         return $t;
      }
      $temp = $temp->getCustomFields();
      if (isset($temp[$element_type]))
         foreach ($temp[$element_type] as $key => $value) {
            if ($value->name == $name)
               $t[] = $value;
         }
      return $t;
   }


   public function __construct(iAmoCRM $client, string $origin)
   {
      if (!is_string($origin))
         throw new AmoCRMException('Не указан origin');
      $this->origin = $origin;

      parent::__construct($client);
   }

   public function creatableCustomField(): CreateableCustomFieldEntity
   {
      $temp = new CreateableCustomFieldEntity($this->origin);
      return $this->creatable_custom_fileds[] = $temp;
   }

   public function createCustomField()
   {

      if (count($this->creatable_custom_fileds) > 0) {
         $cfa = [];
         $response_temp = [];

         $count = 0;
         foreach ($this->creatable_custom_fileds as $val) {
            $cfa[] = $val->generateQuery();
            $count++;
            if ($count >= $this->client::MAX_BATCH_CALLS) {
               $response_temp[] = $this->client->call('fields', [], ['add' => $cfa]);
               unset($cfa);
               $count = 0;
            }
         }
         if (count($cfa) > 0)
            $response_temp[] = $this->client->call('fields', [], ['add' => $cfa]);
         return $response_temp;
      }
      return false;
   }

   public function createableCustomFiledsList()
   {
      return $this->creatable_custom_fileds;
   }

   public function addDeleteCusstomField(CustomFieldEntity $cf)
   {
      $this->deleted_custom_fields[] = $cf;
   }

   public function deleteCustomField()
   {

      if (count($this->deleted_custom_fields) > 0) {
         $cfa = [];
         $response_temp = [];

         $count = 0;
         foreach ($this->deleted_custom_fields as $val) {
            $id = $val->elem_id;
            $cfa[] = [
               'id' => $id,
               'origin' => $this->origin
            ];
            $count++;
            if ($count >= $this->client::MAX_BATCH_CALLS) {
               $response_temp[] = $this->client->call('fields', [], ['delete' => $cfa]);
               unset($cfa);
               $count = 0;
            }
         }
         if (count($cfa) > 0)
            $response_temp[] = $this->client->call('fields', [], ['delete' => $cfa]);
         return $response_temp;
      }
      return false;
   }
}
