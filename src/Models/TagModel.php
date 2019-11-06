<?php

namespace AmoCRM\Models;

class TagModel extends BaseModel
{
   public function getTags()
   {
      return $this->client->call(
         '/v3/leads/tags',
         'GET',
         true,
         true,
         true
      );
   }
}
