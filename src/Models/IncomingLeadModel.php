<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\IncomingLeadSipEntity;


class IncomingLeadModel extends BaseModel
{
   public function addIncomingLead($leads)
   {
      $temp['add'] = array();
      if (is_array($leads)) {
         foreach ($leads as $item) {
            if ($item instanceof IncomingLeadSipEntity) {
               $temp['add'][] = $item->generateQuery();
            } else {
               throw new AmoCRMException('Указан не вернный параметр');
            }
         }
      } else {
         $temp['add'][] = $leads->generateQuery();
      }
      return $this->client->call('/api/v2/incoming_leads/sip', array(), $temp);
   }
}
