<?php

namespace AmoCRM;

use AmoCRM\Contracts\iAmoCRM;
use AmoCRM\Exceptions\AmoCRMException;
use AmoCRM\Exceptions\NetworkException;
use DateTime;

class AmoCRM implements iAmoCRM
{
   private
      $domain,
      $login,
      $keyAPI;

   public function __construct(String $domain, String $login, String $keyAPI)
   {
      $this->setDomain($domain);
      $this->setLogin($login);
      $this->setKeyAPI($keyAPI);
   }

   public function getDomain()
   {
      return $this->domain;
   }
   public function setDomain(string $domain)
   {
      if ('' === $domain) {
         throw new AmoCRMException('Домен не может быть пустым');
      }
      $this->domain = $domain;

      return true;
   }

   public function getLogin()
   {
      return $this->login;
   }
   public function setLogin(String $login)
   {
      if ('' === $login) {
         throw new AmoCRMException('Логин не может быть пустым');
      }
      $this->login = $login;

      return true;
   }

   public function getKeyAPI()
   {
      return $this->keyAPI;
   }

   public function setKeyAPI(string $keyAPI)
   {
      if ('' === $keyAPI) {
         throw new AmoCRMException('API ключ не может быть пустым');
      }
      $this->keyAPI = $keyAPI;

      return true;
   }


   public function call($methodName, array $additionalParametersGET = array(), $additionalParametersPOST = array(), $custom_url = null, $modified = null)
   {
      return $this->_call($methodName, $additionalParametersGET, $additionalParametersPOST, $custom_url, $modified);
   }

   protected function _call($methodName, array $additionalParametersGET = array(), $additionalParametersPOST = array(), $custom_url = null, $modified = null)
   {

      $query = http_build_query(array_merge($additionalParametersGET, [
         'USER_LOGIN' => $this->getLogin(),
         'USER_HASH' => $this->getKeyAPI(),
      ]), null, '&');

      if ($custom_url === null)
         $query = sprintf('https://%s.amocrm.ru/api/v2/%s?%s', $this->getDomain(), $methodName, $query);
      else
         $query = sprintf('https://%s.amocrm.ru/private/api/v2/json/%s/%s?%s', $this->getDomain(), $methodName, $custom_url, $query);

      debug($query);

      $headers = $this->prepareHeaders($modified);

      $curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, $query);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_ENCODING, '');


      if (count($additionalParametersPOST) > 0) {
         $fields = json_encode($additionalParametersPOST);
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
         curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
      }

      $result = curl_exec($curl);
      $info = curl_getinfo($curl);
      $error = curl_error($curl);
      $errno = curl_errno($curl);
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

      debug($code);

      curl_close($curl);

      usleep(self::CALL_DELLAY);


      if ($result === false && !empty($error)) {
         throw new NetworkException($error, $errno);
      }

      return $this->parseResponse($result, $info);
   }

   protected function prepareHeaders($modified = null)
   {
      $headers = [
         'Connection: keep-alive',
         'Content-Type: application/json',
      ];
      if ($modified !== null) {
         if (is_int($modified)) {
            $headers[] = 'IF-MODIFIED-SINCE: ' . $modified;
         } else {
            $headers[] = 'IF-MODIFIED-SINCE: ' . (new DateTime($modified))->format(DateTime::RFC1123);
         }
      }
      return $headers;
   }

   protected function parseResponse($response, $info)
   {

      $result = json_decode($response, true);

      if (floor($info['http_code'] / 100) >= 3) {
         if (isset($result['response']['error_code']) && $result['response']['error_code'] > 0) {
            $code = $result['response']['error_code'];
         } elseif ($result !== null) {
            $code = 0;
         } else {
            $code = $info['http_code'];
         }
         if (isset($result['response']['error'])) {
            throw new AmoCRMException($result['response']['error'], $code);
         } else {
            throw new AmoCRMException('Неверное тело ответа.', $code);
         }
      } elseif (count($result) < 1) return false;

      if ($result['response'])
         return $result['response'];

      return $result;
   }
}
