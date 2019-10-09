<?php

namespace AmoCRM;

use AmoCRM\Contracts\iAmoCRM;

abstract class AmoCRMEntity
{
   protected static $elem_id = null;
   protected static $client = null;

   public function __construct(Int $elem_id)
   {
      $this->elem_id = $elem_id;
   }
}
