<?php


namespace AmoCRM\Entities;


abstract class BaseEntity
{

    protected  $id;

    /**
     * Получить структуру элемента для запроса
     *
     * @return void
     */
    public function generateQuery($type = null)
    {
        if ($type != null) {
            $this->checkFields($type);
        }
        $temp = array();
        $class_vars = get_object_vars($this);
        foreach ($class_vars as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    if ($val instanceof BaseEntity) {
                        $temp[$name][$key] = $val->generateQuery();
                    } else {
                        $temp[$name][$key] = $val;
                    }
                }
            } elseif (null !== $value) {
                $temp[$name] = $value;
            }
        }
        return $temp;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Проверка заполнености полей
     *
     * @param string $type
     * @return bool
     */
    protected function checkFields($type)
    {
        return true;
    }
}
