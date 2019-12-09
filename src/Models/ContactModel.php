<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\ContactEntity;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Модель для работы с контактами
 * @package AmoCRM\Models
 */
class ContactModel extends AbstractModel
{

    /**
     * Получить контакты
     *
     * @param int $limit_rows
     * @param int $limit_offset
     * @param string|null $query
     * @return ContactEntity[]
     */
    public function getContacts($limit_rows = 500, $limit_offset = 0, $query = null)
    {
        $contacts = $this->client->call(
            '/api/v2/contacts',
            'GET',
            true,
            false,
            false,
            array(
                'limit_rows' => $limit_rows,
                'limit_offset' => $limit_offset,
                'query' => $query
            )
        );
        $temp = array();
        if (!isset($contacts['_embedded']['items'])) {
            return $temp;
        }
        foreach ($contacts['_embedded']['items'] as $item) {
            $temp[] = new ContactEntity($item);
        }
        return $temp;
    }

    /**
     * @param $id
     * @return ContactEntity|bool
     */
    public function getContactById($id)
    {
        $contacts = $this->client->call(
            '/api/v2/contacts',
            'GET',
            true,
            false,
            false,
            array('id' => $id)
        );
        if (!isset($contacts['_embedded']['items'])) return false;
        return new ContactEntity($contacts['_embedded']['items'][0]);
    }

    /**
     * @param ContactEntity[]|ContactEntity $contacts
     * @return array
     * @throws AmoCRMException
     */
    public function updateContact($contacts)
    {
        $temp['update'] = array();
        if (is_array($contacts)) {
            foreach ($contacts as $item) {
                if ($item instanceof ContactEntity) {
                    $temp['update'][] = $item->generateQuery();
                } else {
                    throw new AmoCRMException('Указан не вернный параметр');
                }
            }
        } else {
            $temp['update'][] = $contacts->generateQuery();
        }
        return $this->client->call('/api/v2/contacts', 'GET', true, false, false, array(), $temp);
    }

    /**
     * @param ContactEntity[]|ContactEntity $contacts
     * @return array
     * @throws AmoCRMException
     */
    public function createContact($contacts)
    {
        $temp['add'] = array();
        if (is_array($contacts)) {
            foreach ($contacts as $item) {
                if ($item instanceof ContactEntity) {
                    $temp['add'][] = $item->generateQuery();
                } else {
                    throw new AmoCRMException('Указан не вернный параметр');
                }
            }
        } else {
            $temp['add'][] = $contacts->generateQuery();
        }
        return $this->client->call('/api/v2/contacts', 'POST', true, false, false, array(), $temp);
    }
}
