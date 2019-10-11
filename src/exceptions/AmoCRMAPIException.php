<?php

namespace AmoCRM\Exceptions;

class AmoCRMAPIException extends \Exception
{

    protected $errors = array(
        101 => 'Аккаунт не найден',
        102 => 'POST-параметры должны передаваться в формате JSON',
        103 => 'Параметры не переданы',
        104 => 'Запрашиваемый метод API не найден',
    );

    private $otherErrors = array(
        400 => 'Неверная структура массива передаваемых данных, либо не верные идентификаторы кастомных полей',
        402 => 'Подписка закончилась',
        403 => 'Аккаунт заблокирован, за неоднократное превышение количества запросов в секунду',
        429 => 'Превышено допустимое количество запросов в секунду',
        2002 => 'По вашему запросу ничего не найдено',
    );

    public function __construct($code = 0, $message = null)
    {
        if (array_key_exists($code, $this->errors)) {
            $message = $this->errors[$code];
        } elseif (array_key_exists($code, $this->otherErrors)) {
            $message = $this->otherErrors[$code];
        }
        parent::__construct($message, $code !== '' ? $code : 0);
    }
}
