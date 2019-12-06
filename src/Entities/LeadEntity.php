<?php

namespace AmoCRM\Entities;

use AmoCRM\Contracts\AmoCRMInterface;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность сдлеки
 */
class LeadEntity extends BaseEntity
{

    protected
        $name,
        $created_at,
        $updated_at,
        $status_id,
        $pipeline_id,
        $responsible_user_id,
        $sale,
        $tags,
        $contacts_id,
        $company_id,
        $custom_fields,
        $catalog_elements_id,
        $unlink;

    private
        $created_by,
        $account_id,
        $is_deleted,
        $main_contact,
        $group_id,
        $company,
        $closed_at,
        $closest_task_at,
        $contacts,
        $pipeline,
        $loss_reason_id;

    public function __construct($entity = null)
    {
        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->name = $entity['name'];
            $this->created_by = $entity['created_by'];
            $this->created_at = $entity['created_at'];
            $this->updated_at = $entity['updated_at'];
            $this->account_id = $entity['account_id'];
            $this->pipeline_id = $entity['pipeline_id'];
            $this->status_id = $entity['status_id'];
            $this->is_deleted = $entity['is_deleted'];
            $this->main_contact = $entity['main_contact'];
            $this->group_id = $entity['group_id'];
            $this->company = $entity['company'];
            $this->closed_at = $entity['closed_at'];
            $this->closest_task_at = $entity['closest_task_at'];
            $this->tags = explode(', ', trim($entity['tags']));
            foreach ($entity['custom_fields'] as $item) {
                $this->custom_fields[$item['id']] = $item;
            }
            $this->sale = $entity['sale'];
            $this->loss_reason_id = $entity['loss_reason_id'];
            $this->contacts = $entity['contacts'];
            $this->pipeline = $entity['pipeline'];
            $this->responsible_user_id = $entity['responsible_user_id'];
        }
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
     * Получить id этапа на котором находится сделка
     * @return int|null
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * Задать этап на котором находится сделка
     * @param int $status_id
     * @return  self
     */
    public function setStatusId($status_id)
    {
        if (!is_numeric($status_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $this->status_id = $status_id;

        return $this;
    }

    /**
     * Получить воронку в которой находится сделка
     * @return int|null
     */
    public function getPipelineId()
    {
        return $this->pipeline_id;
    }

    /**
     * Задать воронку в которой находится сделка
     * @param int $pipeline_id
     * @return  self
     */
    public function setPipelineId($pipeline_id)
    {
        if (!is_numeric($pipeline_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $this->pipeline_id = $pipeline_id;

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
     * Получить бюджет сделки
     * @return int|null
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Задать бюджет сделки
     * @param int $sale
     * @return  self
     */
    public function setSale($sale)
    {
        if (!is_numeric($sale)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $this->sale = $sale;

        return $this;
    }

    /**
     * Получить тэги сделки
     * @return string[]|null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Задать тэги сделки
     * @param string[] $tags
     * @return  self
     * @throws AmoCRMException
     */
    public function setTags($tags)
    {
        if (!is_array($tags)) {
            throw new AmoCRMException('Передаваемая переменная не является массивом');
        }
        $this->tags = implode(',', $tags);

        return $this;
    }

    /**
     * Задать список id контактов прикрепленных к сделке
     * @param int[] $contacts_id
     * @return  self
     */
    public function setContactsId($contacts_id)
    {
        $this->contacts_id = $contacts_id;

        return $this;
    }

    /**
     * Задать компанию
     * @param int $company_id
     * @return  self
     */
    public function setCompanyId($company_id)
    {
        if (!is_numeric($company_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $this->company_id = $company_id;

        return $this;
    }

    /**
     * Установка значения кастомного поля
     *
     * @param int $id
     * @param mixed $value
     * @param mixed $enum
     * @param mixed $subtype
     * @return self
     */
    public function setCustomField($id, $value, $enum = false, $subtype = false)
    {
        $field = array(
            'id' => $id,
            'values' => array(),
        );

        if (!is_array($value)) {
            $values = array(
                array(
                    $value,
                    $enum
                )
            );
        } else {
            $values = $value;
        }
        foreach ($values as $val) {
            list($value, $enum) = $val;
            $fieldValue = [
                'value' => $value,
            ];
            if ($enum !== false) {
                $fieldValue['enum'] = $enum;
            }
            if ($subtype !== false) {
                $fieldValue['subtype'] = $subtype;
            }
            $field['values'][] = $fieldValue;
        }
        if (!is_array($this->custom_fields[$id])) {
            $this->custom_fields[$id] = array();
        }
        $this->custom_fields[$id] = array_merge($this->custom_fields[$id], $field);
        return $this;
    }

    /**
     * Установка значения кастомного поля типа мультиселект
     *
     * @param int $id
     * @param int|array $values
     * @return self
     */
    public function setCustomMultiField($id, $values)
    {
        $field = [
            'id' => $id,
            'values' => [],
        ];
        if (!is_array($values)) {
            $values = [$values];
        }
        $field['values'] = $values;
        if (!is_array($this->custom_fields[$id])) {
            $this->custom_fields[$id] = array();
        }
        $this->custom_fields[$id] = array_merge($this->custom_fields[$id], $field);
        return $this;
    }

    /**
     * Получить значение кастомного поля
     *
     * @param int $id
     * @return array|null
     */
    public function getCustomFieldValues($id)
    {
        return $this->custom_fields[$id]['values'];
    }

    /**
     * Задать товар для сделки
     *
     * @param int $catalog_id
     * @param int $element_id
     * @param int $count
     * @return self
     */
    public function addCatalogElement($catalog_id, $element_id, $count)
    {
        if (!is_numeric($catalog_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        if (!is_numeric($element_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        if (!is_numeric($count)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }
        if (!is_array($this->catalog_elements_id[$catalog_id])) {
            $this->catalog_elements_id[$catalog_id] = array();
        }
        $this->catalog_elements_id[$catalog_id][$element_id] = $count;
        return $this;
    }


    /**
     * Удалить товар из сделки
     *
     * @param AmoCRMInterface $client
     * @param int $catalog_id
     * @param int $element_id
     * @return self
     */
    public function removeCatalogElement($client, $catalog_id, $element_id)
    {
        $client->call(
            '/ajax/v1/links/set/',
            'POST',
            true,
            true,
            false,
            array(),
            array(
                'request' => array(
                    'links' => array(
                        'unlink' => array(
                            array(
                                'from' => 'leads',
                                'from_id' => $this->id,
                                'to' => 'catalog_elements',
                                'to_id' => $element_id,
                                'from_catalog_id' => 2,
                                'to_catalog_id' => $catalog_id
                            )
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * Получить товары в сделке
     *
     * @param AmoCRMInterface $client
     * @return array|null
     */
    public function getListCatalogElements($client, $catalog_id)
    {
        if (!($client instanceof AmoCRMInterface)) {
            throw new AmoCRMException('Передаваемая переменная не является AmoCRMInterface');
        }
        if (!is_numeric($catalog_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $temp = $client->call(
            '/ajax/v1/links/list/',
            'GET',
            true,
            true,
            false,
            array(
                'links' => array(
                    array(
                        'from' => 'leads',
                        'from_id' => $this->id,
                        'to' => 'catalog_elements',
                        'from_catalog_id' => 2,
                        'to_catalog_id' => $catalog_id
                    )
                )
            )
        );
        $list = array();
        foreach ($temp['response']['links'] as $item) {
            $t = array('element_id' => $item['to_id'], 'quantity' => $item['quantity']);
            $list[] = $t;
        }
        return $list;
    }

    /**
     * Открепить контакты
     *
     * @param array $contacts_id
     * @return self
     */
    public function setUnlinkContacts(array $contacts_id)
    {
        $this->unlink['contacts_id'] = $contacts_id;
        return $this;
    }

    /**
     * Открепить контакты
     *
     * @param int $contacts_id
     * @return self
     */
    public function setUnlinkCompany($company_id)
    {
        if (!is_numeric($company_id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        $this->unlink['company_id'] = $company_id;
        return $this;
    }

    /**
     * Получить id пользователя создавшего сделку
     * @return int|null
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Получить id аккаунта
     * @return int|null
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * Удалена ли сделка?
     * @return bool|null
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Получить главный контакт
     * @return array|null
     */
    public function getMainContact()
    {
        return $this->main_contact;
    }

    /**
     * Получить id группы
     * @return int|null
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Получить компанию
     * @return int|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Получить дату закрытия
     * @return int|null
     */
    public function getClosedAt()
    {
        return $this->closed_at;
    }

    /**
     * Получить время ближайщей задачи
     * @return int|null
     */
    public function getClosestTaskAt()
    {
        return $this->closest_task_at;
    }

    /**
     * Получить массив контактов
     * @return array|null
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Получить воронку
     * @return int|null
     */
    public function getPipeline()
    {
        return $this->pipeline;
    }

    /**
     * Получить id причины отказа
     * @return int|null
     */
    public function getLossReasonId()
    {
        return $this->loss_reason_id;
    }
}
