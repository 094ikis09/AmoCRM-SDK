<?php

namespace AmoCRM\Exceptions;

/**
 * Class AmoCRMCatalogsException
 * @package AmoCRM\Exceptions
 */
class AmoCRMCatalogsException extends AmoCRMAPIException
{
    /**
     * @var array
     */
    protected $errors = array(
        202 => 'Добавление/Обновление/Удаление каталогов: пустой запрос',
        244 => 'Добавление/Обновление/Удаление каталогов: нет прав.',
        281 => 'Каталог не удален: внутренняя ошибка',
        282 => 'Каталог не найден в аккаунте.',
        283 => 'Неверный запрос, данные не переданы.',
        284 => 'Неверный запрос, передан не массив.',
        285 => 'Требуемое поле не передано.',
        405 => 'Метод передачи запроса неверный',
    );
}
