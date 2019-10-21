<?php


namespace AmoCRM\Entities;

/**
 * Сущность воронки
 */
class PipelineEntity extends BaseEntity
{

    private
        $newStatusCount = 0;

    protected
        $name,
        $sort,
        $statuses = array(),
        $is_editable;

    public function __construct($entity = null)
    {
        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->name = $entity['name'];
            $this->sort = $entity['sort'];
            $this->is_main = $entity['is_main'];
            foreach ($entity['statuses'] as $key => $value) {
                $this->statuses[$key] = new StatusEntity($value, $this->id);
            }
        }
    }

    /**
     * Добавить этап в воронку
     *
     * @return StatusEntity
     */
    public function addStatus()
    {
        $this->newStatusCount++;
        return $this->statuses["new_$this->newStatusCount"] = new StatusEntity(null, $this->id != null ? $this->id : 0, count($this->statuses));
    }

    /**
     * Получить этап по уникальному индетификатору
     *
     * @param int $id
     * @return StatusEntity|null
     */
    public function getStatusByID($id)
    {
        if (!is_numeric($id)) {
            throw new AmoCRMException('Передаваемая переменная не является числом');
        }

        return isset($this->statuses[$id]) ? $this->statuses[$id] : null;
    }

    /**
     * Получить этапы по наименованию
     *
     * @param string $name
     * @return StatusEntity[]
     */
    public function getStatusByName($name)
    {
        if (!is_string($name)) {
            throw new AmoCRMException('Передаваемая переменная не является строкой');
        }

        $temp = array();
        foreach ($this->statuses as $key => $value) {
            if (mb_strtolower($value->getName()) === mb_strtolower($name))
                $temp[] = $value;
        }
        return $temp;
    }

    /**
     * Удалить этап
     *
     * @param StatusEntity $status
     * @return self
     */
    public function removeStatus($status)
    {
        if (!($status instanceof StatusEntity)) {
            throw new AmoCRMException('Передаваемая переменная не является StatusEntity');
        }

        $id = array_search($status, $this->statuses);
        if ($id !== false) {
            unset($this->statuses[$id]);
        }
        return $this;
    }

    /**
     * Получить наименование воронки
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Задать наименование воронки
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
     * Получить порядковый номер воронки
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Задать порядковы номер воронки
     * @param int $sort
     * @return  self
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
     * Возвращает можно ли изменить воронку
     * @return bool
     */
    public function getIsEditable()
    {
        return $this->is_editable;
    }

    /**
     * Задает можно ли изменить воронку
     * @param bool $is_editable
     * @return  self
     */
    public function setIsEditable($is_editable)
    {
        $this->is_editable = $is_editable;

        return $this;
    }
}
