<?php

namespace AmoCRM\Entities;

use AmoCRM\Constants\ElementType;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность задачи
 */
class TaskEntity extends AbstractEntity
{

    protected
        $element_id,
        $element_type,
        $complete_till,
        $task_type,
        $text,
        $created_at,
        $updated_at,
        $responsible_user_id,
        $is_completed,
        $created_by;

    private
        $complete_till_at,
        $account_id,
        $group_id,
        $result,
        $duration;

    /**
     * TaskEntity constructor.
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
            $this->element_type = $entity['element_type'];
            $this->element_id = $entity['element_id'];
            $this->is_completed = $entity['is_completed'];
            $this->task_type = $entity['task_type'];
            $this->complete_till_at = $entity['complete_till_at'];
            $this->text = $entity['text'];
        }
    }

    /**
     * Получить уникальный идентификатор привязываемого элемента
     * @return int|null
     */
    public function getElementId()
    {
        return $this->element_id;
    }

    /**
     * Задать уникальный идентификатор привязываемого элемента
     *
     * @param int $element_id id элемента
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
     * Получить тип привязываемого элемента
     * @return int|null
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * Задать тип привязываемого элемента
     * - ElementType::CONTACT
     * - ElementType::LEAD
     * - ElementType::COMPANY
     * - ElementType::CUSTOMER
     * - ElementType::NONE
     *
     * @param int $element_type тип привязываемого элемента
     * @return  self
     * @throws AmoCRMException
     */
    public function setElementType($element_type)
    {
        if (!is_numeric($element_type)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        } elseif (
            $element_type != ElementType::CONTACT &&
            $element_type != ElementType::LEAD &&
            $element_type != ElementType::COMPANY &&
            $element_type != ElementType::CUSTOMER &&
            $element_type != ElementType::NONE
        ) {
            throw new AmoCRMException('Передаваемый тип не найден');
        }
        $this->element_type = $element_type;

        return $this;
    }

    /**
     * Получить дату, до которой необходимо завершить задачу
     *
     * @param string $complete_till Дата, до которой необходимо завершить задачу - '10.06.1997' или '+10 minutes'
     * @return  self
     * @throws AmoCRMException
     */
    public function setCompleteTill($complete_till)
    {
        $date = strtotime($complete_till);
        if ($date === false) {
            throw new AmoCRMException('Задан не верный формат даты');
        }
        $this->complete_till = $date;

        return $this;
    }

    /**
     * Получить тип задачи
     * @return int|null
     */
    public function getTaskType()
    {
        return $this->task_type;
    }

    /**
     * Задать тип задачи
     * - TaskType::CALL
     * - TaskType::MEET
     * - TaskType::MAIL
     * @param int $task_type
     * @return  self
     * @throws AmoCRMException
     */
    public function setTaskType($task_type)
    {
        if (!is_numeric($task_type)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        $this->task_type = $task_type;

        return $this;
    }

    /**
     * Получить текст задачи
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Задать текст задачи
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
     * Получить дату создания данной задачи (Unix)
     * @return int|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Задать дату создания данной задачи
     * @param string $created_at Дата создания данной задачи - '10.06.1997' или '+10 minutes'
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
     * Получить дату последнего изменения данной задачи (Unix)
     * @return int|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Задать дату последнего изменения данной задачи (Unix)
     * @param string $updated_at Дата последнего изменения данной задачи - '10.06.1997' или '+10 minutes'
     * @return  self
     * @throws AmoCRMException
     */
    public function setUpdatedAt($updated_at)
    {
        $date = strtotime($updated_at);
        if ($date === false) {
            throw new AmoCRMException('Задан не верный формат даты');
        }
        $this->updated_at = $date;

        return $this;
    }

    /**
     * Получить уникальный идентификатор ответственного пользователя
     * @return int|null
     */
    public function getResponsibleUserId()
    {
        return $this->responsible_user_id;
    }

    /**
     * Задать уникальный идентификатор ответственного пользователя
     * @param int $responsible_user_id уникальный идентификатор ответственного пользователя
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
     * Получить завершена задача или нет
     * @return bool|null
     */
    public function getIsCompleted()
    {
        return $this->is_completed;
    }

    /**
     * Задать завершена задача или нет
     * @param bool $is_completed завершена задача или нет
     * @return  self
     * @throws AmoCRMException
     */
    public function setIsCompleted($is_completed)
    {
        if (!is_bool($is_completed)) {
            throw new AmoCRMException('Передаваемая переменная не является булевой');
        }
        $this->is_completed = $is_completed;

        return $this;
    }

    /**
     * Получить уникальный идентификатор создателя задачи
     * @return int|null
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Задать уникальный идентификатор создателя задачи
     * @param int $created_by уникальный идентификатор создателя задачи
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
     * Получить дату до которой необходимо завершить задачу (UNIX / Только для созданных задач)
     * @return int|null
     */
    public function getCompleteTillAt()
    {
        return $this->complete_till_at;
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
     * Получить id группы в которой состоит пользователь имеющей отношение к задаче
     * @return int|null
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Получить Массив, содержащий информацию о результате
     * @return array|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Раз Амо это возвращает пусть будет
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
