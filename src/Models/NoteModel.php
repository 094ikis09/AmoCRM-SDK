<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\NoteEntity;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Модель для работы с примечаниями
 * @package AmoCRM\Models
 */
class NoteModel extends AbstractModel
{

    /**
     * Создание примечания (по одному или пакетно)
     *
     * @param NoteEntity[]|NoteEntity $notes
     * @return array
     * @throws AmoCRMException
     */
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
        return $this->client->call('/api/v2/notes', 'POST', true, false, false, array(), $temp);
    }

    /**
     * Получить примечания с возможностью фильтрации
     *
     * @param int|null $type
     * @param int|null $element_id
     * @return NoteEntity[]
     */
    public function getNotes($type = null, $element_id = null)
    {
        $temp = $this->client->call(
            '/api/v2/notes',
            'GET',
            true,
            false,
            false,
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
