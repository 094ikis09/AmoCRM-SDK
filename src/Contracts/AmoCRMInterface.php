<?php

namespace AmoCRM\Contracts;

use AmoCRM\AmoCRM;
use AmoCRM\Exceptions\AmoCRMException;


/**
 * Interface AmoCRMInterface
 * @package AmoCRM\Contracts
 * @package AmoCRM\Contracts
 */
interface AmoCRMInterface
{

    /**
     * Максимальное количество сущностей в пакетном запросе
     */
    const MAX_BATCH_CALLS = 50;

    /**
     * Задержка между запросами
     */
    const CALL_DELAY = 145000;

    /**
     * Создает основной объект для работы с AmoCRM REST API
     *
     * @param string $subDomain - Субдомен
     * @param string $login - Логин
     * @param string $keyAPI - Ключ API
     * @return AmoCRM
     * @throws AmoCRMException
     */
    public function __construct($subDomain, $login, $keyAPI);

    /**
     * Возвращает Субдомен
     * @return string
     */
    public function getSubDomain();

    /**
     * Возвращает Логин
     * @return string
     */
    public function getLogin();

    /**
     * Возвращает Ключ API
     * @return string
     */
    public function getKeyAPI();

    /**
     * Обращение к REST API AmoCRM
     * @param string $methodName - Метод
     * @param string $requestType
     * @param bool $jsonEncode
     * @param bool $ajax
     * @param bool $cookie
     * @param array $getParameters - GET параметры
     * @param array $postParameters - POST параметры
     * @param null $modified - Изменено с...
     * @return array - Ответ от AmoCRM
     */
    public function call(
        $methodName,
        $requestType,
        $jsonEncode = true,
        $ajax = false,
        $cookie = false,
        array $getParameters = array(),
        array $postParameters = array(),
        $modified = null
    );

    /**
     * Задает количество повторений CURL запросов подключения
     * @param int $retriesCnt - Количество повторений
     * @return AmoCRMInterface
     * @throws AmoCRMException
     */
    public function setRetriesToConnectCount($retriesCnt = 1);

    /**
     * Задает задержку между попытками запроса подключения CURL
     * @param int $microseconds - Задержка между попытками в микросекундах
     * @return AmoCRMInterface
     * @throws AmoCRMException
     */
    public function setRetriesToConnectTimeout($microseconds = 1000000);

    /**
     * Возвращает количество попыток запроса подключения CURL
     * @return int
     */
    public function getRetriesToConnectCount();

    /**
     * Возвращает задержку в микросекундах между попытками запроса подключения CURL
     * @return int
     */
    public function getRetriesToConnectTimeout();

    /**
     * Задает опции cURL, переопределяя значения по умолчанию
     *
     * @link http://php.net/manual/en/function.curl-setopt.php
     *
     * @param array $options - array(CURLOPT_XXX => value1, CURLOPT_XXX2 => value2,...)
     *
     * @return AmoCRMInterface
     */
    public function setCustomCurlOptions(array $options);

    /**
     * Задает проверку SSL при CURL запросе
     *
     * @param boolean $isEnable
     * @return AmoCRMInterface
     * @throws AmoCRMException
     */
    public function setSslVerify($isEnable);

    /**
     * Возвращает задана ли проверка SSL CURL
     *
     * @return bool
     */
    public function getSslVerify();
}
