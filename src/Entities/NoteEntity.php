<?php

namespace AmoCRM\Entities;

class NoteEntity extends BaseEntity
{
   const NOTE_TYPE_COMMON = 4;
   const ELEMENT_TYPE_LEAD = 2;

   protected $element_type;
   protected $element_id;
   protected $text;
   protected $note_type;

   public function __construct($entity = null)
   { }

   /**
    * Set the value of note_type
    *
    * @return  self
    */
   public function setNoteType($note_type)
   {
      $this->note_type = $note_type;

      return $this;
   }

   /**
    * Set the value of text
    *
    * @return  self
    */
   public function setText($text)
   {
      $this->text = $text;

      return $this;
   }

   /**
    * Set the value of element_id
    *
    * @return  self
    */
   public function setElementId($element_id)
   {
      $this->element_id = $element_id;

      return $this;
   }

   /**
    * Set the value of element_type
    *
    * @return  self
    */
   public function setElementType($element_type)
   {
      $this->element_type = $element_type;

      return $this;
   }
}
