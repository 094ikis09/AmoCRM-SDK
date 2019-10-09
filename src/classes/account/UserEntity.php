<?php

namespace AmoCRM\Account;

use AmoCRM\AmoCRMEntity;
use AmoCRM\Exceptions\AmoCRMException;


/**
 * @property  String $name
 * @property  String $last_name
 * @property  String $login
 * @property  String $language
 * @property  String $group_id
 * @property  String $is_active
 * @property  String $is_free
 * @property  String $is_admin
 * @property  String $phone_number
 * @property  array $rights
 */
class UserEntity extends AmoCRMEntity
{
   private
      $name,
      $last_name,
      $login,
      $language,
      $group_id,
      $is_active,
      $is_free,
      $is_admin,
      $phone_number,
      $rights;

   public function __construct(array $user)
   {
      $this->name = $user['name'] ?? '';
      $this->last_name = $user['last_name'] ?? '';
      $this->login = $user['login'] ?? '';
      $this->language = $user['language'] ?? '';
      $this->group_id = $user['group_id'] ?? '';
      $this->is_active = $user['is_active'] ?? '';
      $this->is_free = $user['is_free'] ?? '';
      $this->is_admin = $user['is_admin'] ?? '';
      $this->phone_number = $user['phone_number'] ?? '';
      $this->rights = $user['rights'] ?? '';
      parent::__construct($user['id']);
   }

   public function __get($name)
   {
      if (property_exists($this, $name))  return $this->$name;
      throw new AmoCRMException('Нет такого параметра');
   }
}
