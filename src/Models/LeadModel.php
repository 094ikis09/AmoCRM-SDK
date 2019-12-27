<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\LeadEntity;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Модель для работы со сдлеками
 * @package AmoCRM\Models
 */
class LeadModel extends AbstractModel
{
    /**
     * Получить сделки
     *
     * @param integer $limitRows
     * @param integer $limitOffset
     * @param string $query
     * @param string $with
     * @param array $status
     * @param array $filter
     * @return LeadEntity[]
     */
    public function getLeads($limitRows = 500, $limitOffset = 0, $query = '', $with = '', $status = array(), $filter = array())
    {
        $leads = $this->client->call(
            '/api/v2/leads',
            'GET',
            true,
            false,
            false,
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

    /**
     * Создать сделки
     *
     * @param LeadEntity[]|LeadEntity $leads
     * @return array
     * @throws AmoCRMException
     */
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
        return $this->client->call('/api/v2/leads', 'POST', true, false, false, array(), $temp);
    }

    /**
     * Обновить сделки
     *
     * @param LeadEntity[]|LeadEntity $leads
     * @return array
     * @throws AmoCRMException
     */
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
        return $this->client->call('/api/v2/leads', 'POST', true, false, false, array(), $temp);
    }

    /**
     * Получить сделку по id
     *
     * @param $id
     * @param string $with
     * @return LeadEntity|null
     */
    public function getLeadById($id, $with = '')
    {
        if ($id === null) {
            return null;
        }
        $lead = $this->client->call('/api/v2/leads', 'GET', true, false, false, array('id' => $id, 'with' => $with));
        if (!isset($lead['_embedded']['items'][0])) {
            return null;
        }
        return new LeadEntity($lead['_embedded']['items'][0]);
    }

    /**
     * Удалить сделку
     *
     * @param LeadEntity[]|LeadEntity $leads
     * @return array
     * @throws AmoCRMException
     */
    public function removeLeads($leads)
    {
        $temp['request']['multiactions']['add'][0] = array();
        if (is_array($leads)) {
            foreach ($leads as $item) {
                if ($item instanceof LeadEntity) {
                    $temp['request']['multiactions']['add'][0]['ids'][] = $item->getId();
                } else {
                    throw new AmoCRMException('Указан не вернный параметр');
                }
            }
        } else {
            $temp['request']['multiactions']['add'][0]['ids'][] = $leads->getId();
        }
        $temp['request']['multiactions']['add'][0]['data']['data']['ACTION'] = 'DELETE';
        $temp['request']['multiactions']['add'][0]['entity_type'] = 2;
        $temp['request']['multiactions']['add'][0]['multiaction_type'] = 4;
        return $this->client->call('/ajax/v1/multiactions/set', 'POST', true, true, false, array(), $temp);
    }
}
