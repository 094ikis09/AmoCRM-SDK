<?php

namespace AmoCRM\Models;

use AmoCRM\Contracts\AmoCRMInterface;

/**
 * Базавая модель
 */
abstract class BaseModel
{

   protected $client;

   public function __construct(AmoCRMInterface $client)
   {
      $this->client = $client;
   }
}
