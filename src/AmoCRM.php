<?php

namespace AmoCRM;

use AmoCRM\Contracts\AmoCRMInterface;
use AmoCRM\Exceptions\AmoCRMAPIException;
use AmoCRM\Exceptions\AmoCRMAuthException;
use AmoCRM\Exceptions\AmoCRMCatalogElementsException;
use AmoCRM\Exceptions\AmoCRMCatalogsException;
use AmoCRM\Exceptions\AmoCRMContactsException;
use AmoCRM\Exceptions\AmoCRMCustomersException;
use AmoCRM\Exceptions\AmoCRMException;
use AmoCRM\Exceptions\AmoCRMIoException;
use AmoCRM\Exceptions\AmoCRMLeadsException;
use AmoCRM\Exceptions\AmoCRMNotesException;
use AmoCRM\Exceptions\AmoCRMTasksException;
use DateTime;

/**
 * Class AmoCRM
 *
 * Основной объект для работы с AmoCRM REST API
 *
 * @package AmoCRM
 * @author 094ikis09 <094ikis09@gmail.com>
 * @copyright 2019 094ikis09
 */
class AmoCRM implements AmoCRMInterface
{
    /**
     * Последный запрошенный метод
     *
     * @var string $lastExecuteMethod
     */
    protected $lastExecuteMethod;

    /**
     * Время последнего запроса
     *
     * @var int $lastExecuteTime
     */
    protected $lastExecuteTime = 0;

    /**
     * Субдомен
     * @var string $subDomain
     */
    protected $subDomain;

    /**
     * Логин
     * @var string $login
     */
    protected $login;

    /**
     * Ключ API
     * @var string $keyAPI
     */
    protected $keyAPI;

    /**
     * Проверка SSL для CURLOPT_SSL_VERIFYPEER и CURLOPT_SSL_VERIFYHOST
     * @var bool $sslVerify
     */
    protected $sslVerify = false;

    /**
     * Количество попыток запроса подключения cURL
     * @var int $retriesToConnectCount
     */
    protected $retriesToConnectCount;

    /**
     * Задержка между попытками запроса подключения cURL
     *
     * @var int $retriesToConnectTimeout
     */
    protected $retriesToConnectTimeout;

    /**
     * Свои настройки для cURL
     * @var array $customCurlOptions
     */
    protected $customCurlOptions;


    /**
     * Последний полученый HTTP CODE от cURL
     *
     * @var int $lastHttpCode
     */
    protected $lastHttpCode;

    /**
     * Создает основной объект для работы с AmoCRM REST API
     *
     * @param string $subDomain - Субдомен
     * @param string $login - Логин
     * @param string $keyAPI - Ключ API
     * @return AmoCRM
     * @throws AmoCRMException
     */
    public function __construct($subDomain, $login, $keyAPI)
    {
        $this->setSubDomain($subDomain)
            ->setLogin($login)
            ->setKeyAPI($keyAPI)
            ->setRetriesToConnectCount()
            ->setRetriesToConnectTimeout();
        return $this;
    }

    /**
     * Задает Субдомен
     * @param string $subDomain
     * @return AmoCRM
     * @throws AmoCRMException
     */
    private function setSubDomain($subDomain)
    {
        if (!is_string($subDomain)) {
            throw new AmoCRMException('Субдомен должен быть строкой');
        } elseif (trim($subDomain) == false) {
            throw new AmoCRMException('Субдомен не может быть пустым');
        } elseif (strpos($subDomain, '.')) {
            throw new AmoCRMException('Указан не верный Субдомен');
        }
        $this->subDomain = trim($subDomain);
        return $this;
    }

    /**
     * Задает Логин
     * @param string $login
     * @return AmoCRM
     * @throws AmoCRMException
     */
    private function setLogin($login)
    {
        if (!is_string($login)) {
            throw new AmoCRMException('Логин должен быть строкой');
        } elseif (trim($login) == false) {
            throw new AmoCRMException('Логин не может быть пустым');
        }
        $this->login = trim($login);
        return $this;
    }

    /**
     * Задает ключ API
     * @param string $keyAPI
     * @return AmoCRM
     * @throws AmoCRMException
     */
    private function setKeyAPI($keyAPI)
    {
        if (!is_string($keyAPI)) {
            throw new AmoCRMException('Ключ API должен быть строкой');
        } elseif (trim($keyAPI) == false) {
            throw new AmoCRMException('Ключ API не может быть пустым');
        }
        $this->keyAPI = trim($keyAPI);
        return $this;
    }

    public function getSubDomain()
    {
        return $this->subDomain;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getKeyAPI()
    {
        return $this->keyAPI;
    }

    public function setRetriesToConnectCount($retriesCnt = 1)
    {
        if (!is_numeric($retriesCnt)) {
            throw new AmoCRMException('Количество попыток должно быть числом');
        } elseif ($retriesCnt < 1) {
            throw new AmoCRMException('Количество попыток не может быть меньше 1');
        }
        $this->retriesToConnectCount = (int) $retriesCnt;
        return $this;
    }

    public function setRetriesToConnectTimeout($microseconds = 1000000)
    {
        if (!is_numeric($microseconds)) {
            throw new AmoCRMException('Задержка между попытками должно быть числом');
        } elseif ($microseconds < 1) {
            throw new AmoCRMException('Задержка между попытками не может быть меньше 1');
        }
        $this->retriesToConnectTimeout = (int) $microseconds;
        return $this;
    }

    public function getRetriesToConnectCount()
    {
        return $this->retriesToConnectCount;
    }

    public function getRetriesToConnectTimeout()
    {
        return $this->retriesToConnectTimeout;
    }

    public function setCustomCurlOptions(array $options)
    {
        $this->customCurlOptions = $options;
        return $this;
    }

    public function setSslVerify($isEnable)
    {
        if (!is_bool($isEnable)) {
            throw new AmoCRMException('$isEnable не является булевой');
        }
        $this->sslVerify = $isEnable;
        return $this;
    }

    public function getSslVerify()
    {
        return $this->sslVerify;
    }

    public function call(
        $methodName,
        array $getParameters = array(),
        array $postParameters = array(),
        $modified = null,
        $ajax = false,
        $auth = false
    ) {
        if (!is_string($methodName)) {
            throw new AmoCRMException('$methodName должна быть строкой');
        } elseif (trim($methodName) == false) {
            throw new AmoCRMException('Укажите метод');
        }

        $this->lastExecuteMethod = rtrim(strtolower(trim($methodName)), '/');

        if ($ajax) {
            $headers = array(
                'X-Requested-With: XMLHttpRequest'
            );
        } else {
            $headers = array(
                'Connection: keep-alive',
                'Content-Type: application/json',
            );
        }

        if (isset($modified)) {
            if (is_string($modified)) {
                if (trim($modified) == false) {
                    throw new AmoCRMException('$modified не может быть пустой');
                }
                $dt = new DateTime($modified);
                $headers[] = 'IF-MODIFIED-SINCE: ' . $dt->format(DateTime::RFC1123);
            } elseif (is_int($modified)) {
                $headers[] = 'IF-MODIFIED-SINCE: ' . $modified;
            } else {
                throw new AmoCRMException('Неверный формат $modified');
            }
        }

        $query = http_build_query(
            array_merge(
                $getParameters,
                array(
                    'USER_LOGIN' => $this->getLogin(),
                    'USER_HASH' => $this->getKeyAPI(),
                )
            ),
            null,
            '&'
        );
        if ($auth) {
            $this->authAmo();
        }
        $query = sprintf('https://%s.amocrm.ru%s?%s', $this->getSubDomain(), $this->lastExecuteMethod, $query);
        $result = $this->executeRequest($query, $headers, $postParameters, $ajax, $auth);

        if (isset($result['response']['error'])) {
            $errorResult['code'] = $result['response']['error_code'];
            $errorResult['message'] = $result['response']['error'];
            if ($this->lastHttpCode === 403 || $this->lastHttpCode === 401) {
                throw new AmoCRMAuthException($errorResult['code'], $errorResult['message']);
            }
        }

        if (isset($result['_embedded']['errors'])) {
            if (isset($result['_embedded']['errors']['update'])) {
                $errorResult['code'] = $result['_embedded']['errors']['update'][0]['code'];
                $errorResult['message'] = $result['_embedded']['errors']['update'][0]['message'];;
            } else {
                $errorResult['code'] = preg_replace('/^Код ошибки ([0-9]{1,}).*/', '$1', $result['_embedded']['errors'][0][0]);
                $errorResult['message'] = $result['_embedded']['errors'][0][0];
            }
        }

        if (isset($result['title']) && $result['title'] == 'Error') {
            $errorResult['code'] = $result['status'];
            $errorResult['message'] = $result['detail'];
        }

        if (isset($errorResult)) {
            $this->handleAmoCRMAPILevelErrors($this->lastExecuteMethod, $errorResult['code'], $errorResult['message']);
        }

        return $result;
    }


    /**
     * Исключение по запросу
     *
     * @param string $method - метод
     * @param int $code - код ошибки
     * @param string $message - сообщение ошибки
     * @throws AmoCRMAuthException
     * @throws AmoCRMContactsException
     * @throws AmoCRMLeadsException
     * @throws AmoCRMNotesException
     * @throws AmoCRMTasksException
     * @throws AmoCRMAPIException
     * @throws AmoCRMCatalogsException
     * @throws AmoCRMCustomersException
     * @throws AmoCRMCatalogElementsException
     */
    protected function handleAmoCRMAPILevelErrors($method, $code, $message)
    {
        switch ($method) {
            case '/private/api/auth.php':
                throw new AmoCRMAuthException($code, $message);
            case '/api/v2/contacts':
                throw new AmoCRMContactsException($code, $message);
            case '/api/v2/leads':
                throw new AmoCRMLeadsException($code, $message);
            case '/api/v2/notes':
                throw new AmoCRMNotesException($code, $message);
            case '/api/v2/tasks':
                throw new AmoCRMTasksException($code, $message);
            case '/api/v2/catalogs':
                throw new AmoCRMCatalogsException($code, $message);
            case '/api/v2/catalog_elements':
                throw new AmoCRMCatalogElementsException($code, $message);
            case '/api/v2/customers':
                throw new AmoCRMCustomersException($code, $message);
            case '/api/v2/account':
            default:
                throw new AmoCRMAPIException($code, $message);
        }
    }

    protected function authAmo()
    {
        $user = array(
            'USER_LOGIN' => $this->getLogin(),
            'USER_HASH' => $this->getKeyAPI()
        );
        $link = 'https://' . $this->getSubDomain() . '.amocrm.ru/private/api/auth.php?type=json';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/Cookies/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/Cookies//cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_exec($curl);
        curl_close($curl);
    }

    /**
     * Выполняет запрос
     *
     * @param string $url - URL
     * @param array $headers - Заголовки
     * @param array $postParameters - Пост данные
     * @return array - Ответ от AmoCRM
     * @throws AmoCRMException
     */
    protected function executeRequest($url, array $headers, array $postParameters = array(), $ajax, $auth)
    {
        $retryableErrorCodes = array(
            CURLE_COULDNT_RESOLVE_HOST,
            CURLE_COULDNT_CONNECT,
            CURLE_HTTP_NOT_FOUND,
            CURLE_READ_ERROR,
            CURLE_OPERATION_TIMEOUTED,
            CURLE_HTTP_POST_ERROR,
            CURLE_SSL_CONNECT_ERROR,
        );

        $curlOptions = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 65,
            CURLOPT_TIMEOUT => 70,
            CURLOPT_SSL_VERIFYHOST => (int) $this->sslVerify,
            CURLOPT_SSL_VERIFYPEER => (int) $this->sslVerify,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_ENCODING => '',
        );
        if ($auth) {
            $curlOptions[CURLOPT_COOKIEFILE] = dirname(__FILE__) . '/Cookies/cookie.txt';
            $curlOptions[CURLOPT_COOKIEJAR] = dirname(__FILE__) . '/Cookies/cookie.txt';
        }
        if (count($postParameters) > 0) {
            $curlOptions[CURLOPT_POST] = true;
            if (!$ajax) {
                $curlOptions[CURLOPT_POSTFIELDS] = json_encode($postParameters);
            } else {
                $curlOptions[CURLOPT_POSTFIELDS] = $postParameters;
            }
        }

        if (is_array($this->customCurlOptions)) {
            foreach ($this->customCurlOptions as $customCurlOptionKey => $customCurlOptionValue) {
                $curlOptions[$customCurlOptionKey] = $customCurlOptionValue;
            }
        }

        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);

        $curlResult = false;
        $retriesCnt = $this->retriesToConnectCount;
        while ($retriesCnt--) {
            usleep((int) max(0, self::CALL_DELAY - ((microtime(true) - $this->lastExecuteTime) * 1000000)));
            $this->lastExecuteTime = microtime(true);
            $curlResult = curl_exec($curl);
            if (false === $curlResult) {
                $curlErrorNumber = curl_errno($curl);
                $errorMsg = sprintf(
                    'Попытка[%s] cURL ошибка (код %s): %s' . PHP_EOL,
                    $retriesCnt,
                    $curlErrorNumber,
                    curl_error($curl)
                );
                if (false === in_array($curlErrorNumber, $retryableErrorCodes, true) || !$retriesCnt) {
                    curl_close($curl);
                    throw new AmoCRMIoException($errorMsg);
                }
                usleep($this->retriesToConnectTimeout);
                continue;
            }
            $this->lastHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            break;
        }
        $jsonResult = json_decode($curlResult, true);
        unset($curlResult);
        $jsonErrorCode = json_last_error();
        if (null !== $jsonResult && (JSON_ERROR_NONE !== $jsonErrorCode)) {
            $errorMsg = json_last_error_msg() . PHP_EOL . 'Код ошибки: ' . $jsonErrorCode . PHP_EOL;
            throw new AmoCRMException($errorMsg);
        }
        return $jsonResult;
    }
}
