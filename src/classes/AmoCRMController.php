<?php

namespace AmoCRM;

use AmoCRM\Contracts\iAmoCRM;

abstract class AmoCRMController
{
   const ITEMS_PER_PAGE_LIMIT = 500;

   protected $client = false;

   public function __construct(iAmoCRM $client)
   {
      $this->client = $client;
   }
}
