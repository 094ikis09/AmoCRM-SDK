<?php

namespace AmoCRM\Contracts;

use AmoCRM\AmoCRM;
use AmoCRM\Exceptions\AmoCRMAPIException;
use AmoCRM\Exceptions\AmoCRMAuthException;
use AmoCRM\Exceptions\AmoCRMCatalogElementsException;
use AmoCRM\Exceptions\AmoCRMCatalogsException;
use AmoCRM\Exceptions\AmoCRMContactsException;
use AmoCRM\Exceptions\AmoCRMCustomersException;
use AmoCRM\Exceptions\AmoCRMEmptyResponseException;
use AmoCRM\Exceptions\AmoCRMException;
use AmoCRM\Exceptions\AmoCRMLeadsException;
use AmoCRM\Exceptions\AmoCRMNotesException;
use AmoCRM\Exceptions\AmoCRMTasksException;


/**
 * Interface AmoCRMInterface
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
     * @param array $getParameters - GET параметры
     * @param array $postParameters - POST параметры
     * @param null $modified - Изменено с...
     * @return array - Ответ от AmoCRM
     * @throws AmoCRMAPIException
     * @throws AmoCRMAuthException
     * @throws AmoCRMCatalogElementsException
     * @throws AmoCRMCatalogsException
     * @throws AmoCRMContactsException
     * @throws AmoCRMCustomersException
     * @throws AmoCRMEmptyResponseException
     * @throws AmoCRMException
     * @throws AmoCRMLeadsException
     * @throws AmoCRMNotesException
     * @throws AmoCRMTasksException
     * @throws \Exception
     */
    public function call(
        $methodName,
        array $getParameters = array(),
        $postParameters = array(),
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

    /**
     * Задает проверку исключения при пустом ответе
     *
     * @param boolean $isEnable
     * @return AmoCRMInterface
     * @throws AmoCRMException
     */
    public function setThrowWhenEmptyResponse($isEnable);

    /**
     * Возвращает задана ли проверка исключения при пустом ответе
     *
     * @return bool
     */
    public function getThrowWhenEmptyResponse();
}
