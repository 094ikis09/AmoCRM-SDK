<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность примечания
 */
class NoteEntity extends AbstractEntity
{
    protected
        $element_id,
        $element_type,
        $text,
        $note_type,
        $created_at,
        $updated_at,
        $responsible_user_id,
        $params,
        $created_by;

    private
        $account_id,
        $group_id,
        $is_editable,
        $attachment;

    /**
     * NoteEntity constructor.
     * @param null $entity
     */
    public function __construct($entity = null)
    {
        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->responsible_user_id = $entity['responsible_user_id'];
            $this->created_by = $entity['created_by'];
            $this->created_at = $entity['created_at'];
            $this->updated_at = $entity['updated_at'];
            $this->account_id = $entity['account_id'];
            $this->group_id = $entity['group_id'];
            $this->is_editable = $entity['is_editable'];
            $this->element_id = $entity['element_id'];
            $this->element_type = $entity['element_type'];
            $this->attachment = $entity['attachment'];
            $this->note_type = $entity['note_type'];
            $this->text = $entity['text'];
            $this->params = $entity['params'];
        }
    }

    /**
     * Получить id элемента, в карточке которого создано событие
     * @return int|null
     */
    public function getElementId()
    {
        return $this->element_id;
    }

    /**
     * Задать id элемента, в карточку которого будет добавлено событие
     * @param int $element_id
     * @return  self
     * @throws AmoCRMException
     */
    public function setElementId($element_id)
    {
        if (!is_numeric($element_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->element_id = $element_id;

        return $this;
    }

    /**
     * Получить тип сущности элемента, в карточке которого создано событие
     * @return int|null
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * Задать тип сущности элемента, в карточку которого будет добавлено событие.
     * @param int $element_type
     * @return  self
     * @throws AmoCRMException
     */
    public function setElementType($element_type)
    {
        if (!is_numeric($element_type)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->element_type = $element_type;

        return $this;
    }

    /**
     * Получить текст события
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Задать текст события
     * @param string $text
     * @return  self
     * @throws AmoCRMException
     */
    public function setText($text)
    {
        if (!is_string($text)) {
            throw new AmoCRMException('Передаваемая переменная не является строкой');
        }
        $this->text = $text;

        return $this;
    }

    /**
     * Получить тип события
     * @return int|null
     */
    public function getNoteType()
    {
        return $this->note_type;
    }

    /**
     * Залать тип события
     * @param int $note_type
     * @return  self
     * @throws AmoCRMException
     */
    public function setNoteType($note_type)
    {
        if (!is_numeric($note_type)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->note_type = $note_type;

        return $this;
    }

    /**
     * Получить дату и время создания события (UNIX)
     * @return int|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Задать дату и время создания события
     * @param string $created_at
     * @return  self
     * @throws AmoCRMException
     */
    public function setCreatedAt($created_at)
    {
        $date = strtotime($created_at);
        if ($date === false) {
            throw new AmoCRMException('Задан не верный формат даты');
        }
        $this->created_at = $date;

        return $this;
    }

    /**
     * Получить дату и время изменения события (UNIX)
     * @return int|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Задать дату и время изменения события
     * @param string $updated_at
     * @return  self
     * @throws AmoCRMException
     */
    public function setUpdatedAt($updated_at)
    {
        $updated_at = strtotime($updated_at);
        if ($updated_at === false) {
            throw new AmoCRMException('Задан не верный формат даты');
        }
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Получить id пользователя ответственного за событие.
     * @return int|null
     */
    public function getResponsibleUserId()
    {
        return $this->responsible_user_id;
    }

    /**
     * Задать id пользователя ответственного за событие.
     * @param int $responsible_user_id
     * @return  self
     * @throws AmoCRMException
     */
    public function setResponsibleUserId($responsible_user_id)
    {
        if (!is_numeric($responsible_user_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->responsible_user_id = $responsible_user_id;

        return $this;
    }

    /**
     * Получить массив, содержащий параметры
     * @return array|null
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Задать массив, содержащий параметры
     * @param array $params
     * @return  self
     * @throws AmoCRMException
     */
    public function setParams($params)
    {
        if (!is_array($params)) {
            throw new AmoCRMException('Передаваемая переменная не является массивом');
        }
        $this->params = $params;

        return $this;
    }

    /**
     * Получить id пользователя, создавшего примечание
     * @return int|null
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Задать id пользователя, создавшего примечание
     * @param int $created_by
     * @return  self
     * @throws AmoCRMException
     */
    public function setCreatedBy($created_by)
    {
        if (!is_numeric($created_by)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * Получить уникальный идентификатор аккаунта
     * @return int|null
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * Получить id группы, в которой состоит пользователь, имеющий отношение к событию
     * @return int|null
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Можно ли изменять данное событие
     * @return bool|null
     */
    public function getIsEditable()
    {
        return $this->is_editable;
    }
}
