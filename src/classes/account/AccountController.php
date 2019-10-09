<?php

namespace AmoCRM\Account;

use AmoCRM\AmoCRMController;
use AmoCRM\CustomField\CustomFieldEntity;
use AmoCRM\Exceptions\AmoCRMException;
use AmoCRM\Pipelines\PipelineEntity;

class AccountController extends AmoCRMController
{
   const
      INFO_CUSTOMFIELDS = 'custom_fields',
      INFO_USERS        = 'users',
      INFO_PIPELINES    = 'pipelines',
      INFO_GROUPS       = 'groups',
      INFO_NOTE_TYPES   = 'note_types',
      INFO_TASK_TYPES   = 'task_types',
      INFO_ALL          = 'custom_fields,users,pipelines,groups,note_types,task_types';


   private $id;
   private $name;
   private $subdomain;
   private $currency;
   private $timezone;
   private $timezone_offset;
   private $language;
   private $date_pattern;
   private $current_user;

   /**
    * Undocumented variable
    *
    * @var UserEntity[]
    */
   private $users;
   private $custom_fields;
   private $groups;
   private $note_types;

   /**
    * Undocumented variable
    *
    * @var PipelineEntity[]
    */
   private $pipelines;
   private $task_types;

   /**
    * @param String|String[] $withs
    * @return void
    */
   public function getAccountInfo($withs = null)
   {
      $temp = [];
      if (null !== $withs) {
         if (is_array($withs)) {
            foreach ($withs as $with) {
               if (!is_string($with))
                  throw new AmoCRMException('Параметр не является строкой');
               elseif (empty(trim($with))) {
                  throw new AmoCRMException('Передан пустой параметр');
               }
               $temp[] = $with;
            }
         } elseif (!is_string($withs)) {
            throw new AmoCRMException('Параметр не является строкой');
         } elseif (empty(trim($withs))) {
            throw new AmoCRMException('Передан пустой параметр');
         } else {
            $temp[] = $withs;
         }
      }
      $result = $this->client->call('account', ['with' => implode(',', $temp)]);
      foreach ($result as $account_key => $account_value) {
         if (!is_array($account_value))
            $this->$account_key = $account_value;
         else
            switch ($account_key) {
               case '_embedded':
                  foreach ($account_value as $key_embedded => $value_embedded) {
                     switch ($key_embedded) {
                        case 'users':
                           foreach ($value_embedded as $users_key => $users_value) {
                              $this->users[$users_key] = new UserEntity($users_value);
                           }
                           break;
                        case 'custom_fields':
                           foreach ($value_embedded as $customfield_key => $customfield_value) {
                              foreach ($customfield_value as $key => $value) {
                                 $this->custom_fields[$customfield_key][$key] = new CustomFieldEntity($customfield_key, $value);
                              }
                           }
                           break;
                        case 'pipelines':
                           foreach ($value_embedded as $pipelines_key => $pipelines_value) {
                              $this->pipelines[$pipelines_key] = new PipelineEntity($pipelines_value);
                           }
                           break;
                        default:
                           foreach ($value_embedded as $key => $value) {
                              $this->$key_embedded[$key] = $value;
                           }
                           break;
                     }
                  }
                  break;
               default:
                  foreach ($account_value as $key => $value) {
                     $this->$account_key[$key] = $value;
                  }
                  break;
            }
      }
      unset($this->_links);
   }

   /**
    * Undocumented function
    *
    * @return CustomFieldEntity[][]
    */
   public function getCustomFields()
   {
      return $this->custom_fields;
   }

   public function getName()
   {
      return $this->name;
   }

   public function getSubdomain()
   {
      return $this->subdomain;
   }

   public function getCurrency()
   {
      return $this->currency;
   }

   public function getTimezone()
   {
      return $this->timezone;
   }

   public function getTimezoneOffset()
   {
      return $this->timezone_offset;
   }

   public function getLanguage()
   {
      return $this->language;
   }

   public function getDatePattern()
   {
      return $this->date_pattern;
   }

   public function getCurrentUser()
   {
      return $this->current_user;
   }

   public function getUsers()
   {
      return $this->users;
   }

   public function getGroups()
   {
      return $this->groups;
   }

   public function getNoteType()
   {
      return $this->note_types;
   }

   public function getPipelines()
   {
      return $this->pipelines;
   }

   public function getTaskType()
   {
      return $this->task_types;
   }
}
