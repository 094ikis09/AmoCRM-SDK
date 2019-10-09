<?php


namespace AmoCRM\Entities;


abstract class BaseEntity
{

    protected  $id;

    abstract public function __construct($entity = null);

    public function generateQuery()
    {
        $temp = array();
        $class_vars = get_object_vars($this);
        foreach ($class_vars as $name => $value) {
            if (null !== $value) {
                    $temp[$name] = $value;
            }
        }
        return $temp;
    }
}