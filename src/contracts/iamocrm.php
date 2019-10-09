<?php

namespace AmoCRM\Contracts;

interface iAmoCRM
{
   const MAX_BATCH_CALLS = 50;
   const CALL_DELLAY = 145000;

   public function __construct(String $domain, String $login, String $KeyAPI);

   public function getDomain();
   public function setDomain(String $domain);

   public function getLogin();
   public function setLogin(String $login);

   public function getKeyAPI();
   public function setKeyAPI(String $keyAPI);

   public function call($methodName, array $additionalParametersGET = array(), $additionalParametersPOST = array(), $modified = null);
}
