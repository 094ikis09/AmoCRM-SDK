<?php

namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность покупателя
 */
class CustomerEntity extends AbstractEntity
{

    protected
        $name,
        $next_date,
        $created_at,
        $updated_at,
        $responsible_user_id,
        $created_by,
        $next_price,
        $periodicity,
        $tags,
        $period_id,
        //$contacts_id,
        //$company_id,
        $custom_fields//$unlink
    ;

    private
        $account_id,
        $updated_by,
        $is_deleted,
        $main_contact,
        $contacts,
        $company,
        $closest_task_at;


    /**
     * CustomerEntity constructor.
     * @param array|null $entity
     */
    public function __construct(array $entity = null)
    {
        $this->id = $entity['id'];
        $this->name = $entity['name'];
        $this->responsible_user_id = $entity['responsible_user_id'];
        $this->created_by = $entity['created_by'];
        $this->created_at = $entity['created_at'];
        $this->updated_at = $entity['updated_at'];
        $this->account_id = $entity['account_id'];
        $this->updated_by = $entity['updated_by'];
        $this->is_deleted = $entity['is_deleted'];
        $this->main_contact = $entity['main_contact'];
        $this->tags = $entity['tags'];
        foreach ($entity['custom_fields'] as $item) {
            $this->custom_fields[$item['id']] = $item;
        }
        $this->contacts = $entity['contacts'];
        $this->company = $entity['company'];
        $this->next_price = $entity['next_price'];
        $this->closest_task_at = $entity['closest_task_at'];
        $this->period_id = $entity['period_id'];
        $this->periodicity = $entity['periodicity'];
        $this->next_date = $entity['next_date'];
    }

    /**
     * Получить название сделки
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Задать название сделки
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
     * Получить Дату и время следующей покупки
     * @return int
     */
    public function getNextDate()
    {
        return $this->next_date;
    }

    /**
     * Задать Дату и время следующей покупки
     * @param string $next_date
     * @return  self
     * @throws AmoCRMException
     */
    public function setNextDate($next_date)
    {
        $next_date = strtotime($next_date);
        if ($next_date === false) {
            throw new AmoCRMException('Задан не верный формат даты');
        }

        $this->next_date = $next_date;

        return $this;
    }

    /**
     * Получить дату и время создания сделки
     * @return int|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Задать дату и время создания сделки
     * @param string $created_at
     * @return  self
     * @throws AmoCRMException
     */
    public function setCreatedAt($created_at)
    {
        $created_at = strtotime($created_at);
        if ($created_at === false) {
            throw new AmoCRMException('Задан не верный формат даты');
        }

        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Получить дату и время последнего изменения
     * @return int|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Задать дату и время последнего изменения
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
     * Получить id ответственного за сделку
     * @return int|null
     */
    public function getResponsibleUserId()
    {
        return $this->responsible_user_id;
    }

    /**
     * Задать ответственного за сделку
     * @param int $responsible_user_id
     * @return  self
     */
    public function setResponsibleUserId($responsible_user_id)
    {
        $this->responsible_user_id = $responsible_user_id;

        return $this;
    }

    /**
     * Получить ответсвенного за создание
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Устоновить ответсвенного за создание
     *
     * @param int $created_by
     * @return  self
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;

        return $this;
    }
}
