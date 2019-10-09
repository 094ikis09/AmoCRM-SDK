<?php

namespace AmoCRM\Pipelines;

use AmoCRM\Pipelines\Statuses\CreateableStatusEntity;
use AmoCRM\Pipelines\Statuses\EditableStatusEntity;

class EditablePipelineEntity
{
   private
      $id,
      $name,
      $sort,
      $is_main,
      $statuses,
      $add_statuses;

   public function __construct(PipelineEntity $pipeline)
   {
      $this->name = $pipeline->name ?? '';
      $this->sort = $pipeline->sort ?? '';
      $this->is_main = $pipeline->is_main ?? '';
      foreach ($pipeline->statuses as $key => $value) {
         if ($value->is_editable)
            $this->statuses[$key] = new EditableStatusEntity($value);
      }
      $this->id = $pipeline->elem_id;
      // unset($this->statuses[142]);
      // unset($this->statuses[143]);
      // foreach ($this->statuses as $key => $value) {
      //    unset($this->statuses[$key]['is_editable']);
      // }
   }

   public function setName(String $name)
   {
      $this->name = $name;
   }

   public function setSort(Int $sort)
   {
      $this->sort = $sort;
   }

   public function setIsMain(Bool $isMain)
   {
      $this->is_main = $isMain;
   }


   /**
    * Undocumented function
    *
    * @return EditableStatusEntity[]
    */
   public function getStatuses()
   {
      return $this->statuses;
   }

   public function generateQuery()
   {
      $temp = [];
      $class_vars = get_object_vars($this);
      foreach ($class_vars as $name => $value) {
         if (null !== $value) {
            if ($name === 'statuses') {
               foreach ($value as $key => $val) {
                  $temp[$name][$key] = $val->generateQuery();
               }
            } elseif ($name === 'add_statuses') {
               foreach ($value as $key => $val) {
                  $temp['statuses'][$key] = $val->generateQuery();
               }
            } else {
               $temp[$name] = $value;
            }
         }
      }
      return [$this->id => $temp];
   }

   public function deleteStatus(EditableStatusEntity $status)
   {
      $as = array_search($status, $this->statuses);
      if (false !== $as)
         unset($this->statuses[$as]);
   }

   public function addStatus()
   {
      return $this->add_statuses[] = new CreateableStatusEntity();
   }
}
