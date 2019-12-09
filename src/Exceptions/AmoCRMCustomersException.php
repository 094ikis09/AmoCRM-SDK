<?php

namespace AmoCRM\Exceptions;

/**
 * Class AmoCRMCustomersException
 * @package AmoCRM\Exceptions
 */
class AmoCRMCustomersException extends AmoCRMAPIException
{
    /**
     * @var array
     */
    protected $errors = array(
        288 => 'Недостаточно прав. Доступ запрещен.',
        402 => 'Необходимо оплатить функционал',
        425 => 'Функционал недоступен',
        428 => 'Функционал выключен'
    );
}
