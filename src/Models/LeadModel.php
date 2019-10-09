<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\LeadEntity;
use AmoCRM\Exceptions\AmoCRMException;

class LeadModel extends BaseModel
{
   public function getLeads($limitRows = 500, $limitOffset = 0, $query = '', $with = '', $status = array(), $filter = array())
   {
      $leads = $this->client->call(
         '/api/v2/leads',
         array(
            'limit_rows' => $limitRows,
            'limit_offset' => $limitOffset,
            'query' => $query,
            'with' => $with,
            'status' => $status,
            'filter' => $filter
         )
      );
      $temp = array();
      if (isset($leads['_embedded']['items'])) {
         foreach ($leads['_embedded']['items'] as $item) {
            $temp[] = new LeadEntity($item);
         }
      }
      return $temp;
   }

   public function createLeads($leads)
   {
      $temp['add'] = array();
      if (is_array($leads)) {
         foreach ($leads as $item) {
            if ($item instanceof LeadEntity) {
               $temp['add'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['add'][] = $leads->generateQuery();
      }
      return $this->client->call('/api/v2/leads', array(), $temp);
   }

   public function updateLeads($leads)
   {
      $temp['update'] = array();
      if (is_array($leads)) {
         foreach ($leads as $item) {
            if ($item instanceof LeadEntity) {
               $temp['update'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['update'][] = $leads->generateQuery();
      }
      return $this->client->call('/api/v2/leads', array(), $temp);
   }

   public function getLeadById($id)
   {
      $lead = $this->client->call(
         '/api/v2/leads',
         array(
            'id' => $id,
         )
      );
      return new LeadEntity($lead['_embedded']['items'][0]);
   }
}
