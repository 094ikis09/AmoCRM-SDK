<?php


namespace AmoCRM\Entities;

use AmoCRM\Exceptions\AmoCRMException;

/**
 * Сущность воронки
 */
class PipelineEntity extends AbstractEntity
{

    private
        $newStatusCount = 0;

    protected
        $name,
        $sort,
        $statuses = array(),
        $is_main;

    /**
     * PipelineEntity constructor.
     * @param null $entity
     * @throws AmoCRMException
     */
    public function __construct($entity = null)
    {
        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->name = $entity['name'];
            $this->sort = $entity['sort'];
            $this->is_main = $entity['is_main'];
            foreach ($entity['statuses'] as $key => $value) {
                $this->statuses[$key] = new StatusEntity($this->id, $value);
            }
        }
    }

    /**
     * Добавить этап в воронку
     *
     * @return StatusEntity
     * @throws AmoCRMException
     */
    public function addStatus()
    {
        $this->newStatusCount++;
        return $this->statuses["new_$this->newStatusCount"] = new StatusEntity($this->id != null ? $this->id : 0, null, count($this->statuses));
    }

    /**
     * Получить этап по уникальному индетификатору
     *
     * @param int $id
     * @return StatusEntity|null
     * @throws AmoCRMException
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
     * @throws AmoCRMException
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
     * @throws AmoCRMException
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
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Задать наименование воронки
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
     * Получить порядковый номер воронки
     * @return int|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Задать порядковы номер воронки
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
     * Получить Является ли воронка “главной”
     * @return bool|null
     */
    public function getIsMain()
    {
        return $this->is_main;
    }

    /**
     * Задать Является ли воронка “главной”
     * @param bool $is_main
     * @return  self
     * @throws AmoCRMException
     */
    public function setIsMain($is_main)
    {
        if (!is_bool($is_main)) {
            throw new AmoCRMException('Передаваемая переменная не является булевой');
        }
        if ($is_main) {
            $this->is_main = 'on';
        } else {
            $this->is_main = null;
        }


        return $this;
    }
}
