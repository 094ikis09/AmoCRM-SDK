<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\NoteEntity;

class NoteModel extends BaseModel
{
   public function createNotes($notes)
   {
      $temp['add'] = array();
      if (is_array($notes)) {
         foreach ($notes as $item) {
            if ($item instanceof NoteEntity) {
               $temp['add'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['add'][] = $notes->generateQuery();
      }
      return $this->client->call('/api/v2/notes', array(), $temp);
   }

   /**
    * Undocumented function
    *
    * @param [type] $type
    * @param [type] $element_id
    * @return NoteEntity[]
    */
   public function getNotes($type = null, $element_id = null)
   {
      $temp = $this->client->call(
         '/api/v2/notes',
         array(
            'type' => $type,
            'element_id' => $element_id
         )
      );

      $notes = array();
      foreach ($temp['_embedded']['items'] as $item) {
         $notes[] = new NoteEntity($item);
      }
      return $notes;
   }
}
