<?php

namespace AmoCRM\Models;

use AmoCRM\Contracts\AmoCRMInterface;

abstract class BaseModel
{

   protected $client;

   public function __construct(AmoCRMInterface $client)
   {
      $this->client = $client;
   }
}
