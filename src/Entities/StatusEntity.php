<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность этапа
 */
class StatusEntity extends AbstractEntity
{

    protected
        $pipeline_id,
        $name,
        $color,
        $sort = 0;

    private
        $is_editable;

    /**
     * StatusEntity constructor.
     * @param $pipeline_id
     * @param null $entity
     * @param null $sort
     * @throws AmoCRMException
     */
    public function __construct($pipeline_id, $entity = null, $sort = null)
    {
        if (!is_numeric($pipeline_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->pipeline_id = $pipeline_id;

        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->name = $entity['name'];
            $this->color = $entity['color'];
            $this->sort = $entity['sort'];
            $this->is_editable = $entity['is_editable'];
        } else {
            if ($sort !== null) {
                $this->sort = ($sort) * 10;
            }
        }
    }

    /**
     * Получить название этапа
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Задать название этапа
     * @param string $name
     * @return  self
     * @throws AmoCRMException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new AmoCRMException('Передаваемая переменная не является строкой');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Получить цвет этапа
     * @return string|null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Задать цвет этапа
     * @param string $color
     * @return  self
     * @throws AmoCRMException
     */
    public function setColor($color)
    {
        if (!is_string($color)) {
            throw new AmoCRMException('Передаваемая переменная не является строкой');
        }

        $this->color = $color;

        return $this;
    }

    /**
     * Получить порядковый номер этапа
     * @return int|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Задать порядковый номер этапа
     * @param int $sort
     * @return  self
     * @throws AmoCRMException
     */
    public function setSort($sort)
    {
        if (!is_numeric($sort)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $this->sort = $sort;

        return $this;
    }

    /**
     * Возвращает можно ли редактировать этап
     * @return bool|null
     */
    public function getIsEditable()
    {
        return $this->is_editable;
    }
}
