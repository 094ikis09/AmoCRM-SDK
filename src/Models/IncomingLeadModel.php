<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\IncomingLeadFormEntity;
use AmoCRM\Entities\IncomingLeadSipEntity;
use AmoCRM\Exceptions\AmoCRMException;


/**
 * Модель для работы с неразобранным
 * @package AmoCRM\Models
 */
class IncomingLeadModel extends AbstractModel
{
    /**
     * Создание неразобранного
     *
     * @param IncomingLeadSipEntity[]|IncomingLeadSipEntity|IncomingLeadFormEntity[]|IncomingLeadFormEntity $leads
     * @return array
     * @throws AmoCRMException
     */
    public function createIncomingLead($leads)
    {
        $temp['add'] = array();
        if (is_array($leads)) {
            foreach ($leads as $item) {
                if ($item instanceof IncomingLeadSipEntity || $item instanceof IncomingLeadFormEntity) {
                    $temp['add'][] = $item->generateQuery();
                } else {
                    throw new AmoCRMException('Указан не вернный параметр');
                }
            }
        } else {
            $temp['add'][] = $leads->generateQuery();
        }
        return $this->client->call('/api/v2/incoming_leads/sip', 'POST', true, false, false, array(), $temp);
    }
}
