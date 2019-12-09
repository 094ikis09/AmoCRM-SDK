<?php

namespace AmoCRM\Models;

/**
 * Модель для работы с тэгами
 * @package AmoCRM\Models
 */
class TagModel extends AbstractModel
{
    /**
     * Получить созданные тэги
     *
     * @return array|null
     */
    public function getTags()
    {
        $temp = $this->client->call(
            '/v3/leads/tags',
            'GET',
            true,
            true,
            true
        );
        return $temp === null ? null : $temp['_embedded']['items'];
    }
}
