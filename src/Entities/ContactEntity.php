<?php

namespace AmoCRM\Entities;

class ContactEntity extends BaseEntity
{
    protected $name;
    protected $responsible_user_id;
    private $created_by;
    private $created_at;
    protected $updated_at;
    protected $account_id;
    private $updated_by;
    protected $group_id;
    protected $company;
    protected $leads;
    protected $closest_task_at;
    protected $tags = array();
    protected $custom_fields;
    protected $customers;

    public function __construct($entity = null)
    {
        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->name = $entity['name'];
            $this->responsible_user_id = $entity['responsible_user_id'];
            $this->created_by = $entity['created_by'];
            $this->created_at = $entity['created_at'];
            $this->updated_at = time();
            $this->account_id = $entity['account_id'];
            $this->updated_by = $entity['updated_by'];
            $this->group_id = $entity['group_id'];
            $this->company = $entity['company'];
            $this->leads = $entity['leads'];
            $this->closest_task_at = $entity['closest_task_at'];
            foreach ($entity['tags'] as $item) {
                $this->tags[] = $item['name'];
            }
            $this->custom_fields = $entity['custom_fields'];
            $this->customers = $entity['customers'];
        }
    }

    public function setResponsibleUser($user)
    {
        $this->responsible_user_id = $user;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCustomFieldById($id)
    {
        foreach ($this->custom_fields as $custom_field) {
            if ($custom_field['id'] === $id) {
                return $custom_field;
            }
        }
        return null;
    }

    public function getCustomFieldsByName($name)
    {
        $temp = array();
        foreach ($this->custom_fields as $custom_field) {
            if ($custom_field['name'] === $name) {
                $temp[] = $custom_field;
            }
        }
        if (count($temp) < 1) return null;
        return $temp;
    }

    private function addCustomField($id, $values)
    {
        $this->custom_fields[] = array(
            'id' => $id,
            'values' => $values
        );
    }

    public function setCustomFiled($id, $value)
    {
        foreach ($this->custom_fields as $key => $custom_field) {
            if ($custom_field['id'] == $id) {
                debug($value);
                $this->custom_fields[$key]['values'] = $value;
                return;
            }
        }
        $this->addCustomField($id, $value);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }
}
