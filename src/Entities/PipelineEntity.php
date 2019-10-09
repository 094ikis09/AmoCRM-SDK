<?php


namespace AmoCRM\Entities;


class PipelineEntity extends BaseEntity
{
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
    }

    /**
     * @param int $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @param bool $is_main
     */
    public function setIsMain($is_main)
    {
        $this->is_main = $is_main;
    }

    protected $statuses = array();

    public function __construct($entity = null)
    {
        if (is_array($entity)) {
            $this->id = $entity['id'];
            $this->name = $entity['name'];
            $this->sort = $entity['sort'];
            $this->is_main = $entity['is_main'];
            $this->statuses = $entity['statuses'];
        }
    }

    /**
     * @return bool|null
     */
    public function getIsMain()
    {
        return $this->is_main;
    }

    public function getId()
    {
        return $this->id;
    }
}