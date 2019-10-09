<?php


namespace AmoCRM\Entities;


class PipelineEntity extends BaseEntity
{

    private $newStatusCount = 0;


    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $sort;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return array|mixed
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @var bool
     */
    protected $is_main;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @param bool $is_main
     */
    public function setIsMain($is_main)
    {
        $this->is_main = $is_main;
        return $this;
    }

    /**
     * Statuses
     *
     * @var StatusEntity[]
     */
    protected $statuses = array();

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
     * @return bool|null
     */
    public function getIsMain()
    {
        return $this->is_main;
    }


    public function addStatus()
    {
        $this->newStatusCount++;
        debug($this->newStatusCount);
        return $this->statuses["new_$this->newStatusCount"] = new StatusEntity(null, $this->id, count($this->statuses));
    }

    public function getStatusByID($id)
    {
        return $this->statuses[$id];
    }

    /**
     * Получить воронки с указаным наименованием
     *
     * @param string $name
     * @return StatusEntity[]
     */
    public function getStatusByName($name)
    {
        $temp = array();
        foreach ($this->statuses as $key => $value) {
            if (mb_strtolower($value->getName()) === mb_strtolower($name))
                $temp[] = $value;
        }
        return $temp;
    }

    public function removeStatus($status)
    {
        $id = array_search($status, $this->statuses);
        if ($id !== false) {
            unset($this->statuses[$id]);
        }
        return $this;
    }
}
