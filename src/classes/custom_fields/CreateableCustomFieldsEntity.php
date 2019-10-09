<?php

namespace AmoCRM\CustomField;

use AmoCRM\Exceptions\AmoCRMException;

class CreateableCustomFieldEntity
{

   const
      CCF_ET_CONTACT = 1,
      CCF_ET_LEAD = 2,
      CCF_ET_COMPANY = 3,
      CCF_T_TEXT = 1,
      CCF_T_NUMERIC = 2,
      CCF_T_CHECKBOX = 3,
      CCF_T_SELECT = 4,
      CCF_T_MULTISELECT = 5,
      CCF_T_DATE = 6,
      CCF_T_URL = 7,
      CCF_T_MULTITEXT = 8,
      CCF_T_TEXTAREA = 9,
      CCF_T_RADIOBUTTON = 10,
      CCF_T_STREETADDRESS = 11,
      CCF_T_SMART_ADDRESS = 13,
      CCF_T_BIRTHDAY = 14,
      CCF_T_LEGAL_ENTITY = 15,
      CCF_T_ORG_LEGAL_NAME = 17;

   private
      $origin,
      $name,
      $element_type,
      $type,
      $is_editable = true,
      $enums,
      $is_required,
      $is_deletable,
      $is_visible;

   public function __construct(String $origin)
   {
      $this->origin = $origin;
   }

   public function setName(String $name)
   {
      $this->name = $name;
   }

   public function setElementType(Int $elementType)
   {
      $this->element_type = $elementType;
   }

   public function setType(Int $type)
   {
      $this->type = $type;
   }

   public function setIsEditable(Bool $isEditable)
   {
      $this->is_editable = $isEditable;
   }

   /**
    *
    * @param String[]|String $enum
    */
   public function addEnum($enum)
   {
      if (is_array($enum)) {
         foreach ($enum as $val) {
            if (!is_string($val)) throw new AmoCRMException('Массив может состоять только из строк');
            $this->enums[] = $val;
         }
         return true;
      }
      if (!is_string($enum)) throw new AmoCRMException('Enum должен быть строкой');
      $this->enums[] = $enum;
      return true;
   }

   public function setIsRequired(Bool $isRequired)
   {
      $this->is_required = $isRequired;
   }

   public function setIsDeletable(Bool $isDeletable)
   {
      $this->is_deletable = $isDeletable;
   }

   public function setIsVisible(Bool $isVisible)
   {
      $this->is_visible = $isVisible;
   }

   public function generateQuery()
   {
      $temp = [];
      $class_vars = get_object_vars($this);
      foreach ($class_vars as $name => $value) {
         if (null !== $value)
            $temp[$name] = $value;
      }
      return $temp;
   }
}
