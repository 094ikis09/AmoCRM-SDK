<?php

namespace AmoCRM\Pipelines;

use AmoCRM\AmoCRMController;

class PipelineController extends AmoCRMController
{

   private $editable_pipelines;
   private $createable_pipelines;

   /**
    * Undocumented variable
    *
    * @var PipelineEntity[]
    */
   private $deletable_pipelines;


   /**
    * Undocumented function
    *
    * @return PipelineEntity[]
    */
   public function getPipelines()
   {
      $temp = [];
      foreach ($this->client->call('pipelines')['_embedded']['items'] as $value) {
         $temp[] = new PipelineEntity($value);
      }
      return $temp;
   }

   public function editablePipeline(PipelineEntity $pipeline)
   {
      return $this->editable_pipelines[] = new EditablePipelineEntity($pipeline);
   }

   public function createablePipeline()
   {
      return $this->createable_pipelines[] = new CreateablePipelineEntity();
   }

   public function createPipeline()
   {
      if (count($this->createable_pipelines) <= 0) return false;
      $cfa = [];
      $response_temp = [];
      $pipelines['request']['pipelines']['add'] = [];
      $count = 0;
      foreach ($this->createable_pipelines as $val) {
         $pipelines['request']['pipelines']['add'][] = $val->generateQuery();
         $count++;
         if ($count >= $this->client::MAX_BATCH_CALLS) {
            $response_temp[] = $this->client->call('pipelines', [],  $pipelines, 'set');
            unset($pipelines['request']['pipelines']['add']);
            $count = 0;
         }
      }
      if (count($pipelines['request']['pipelines']['add']) > 0) {
         // debug($pipelines);
         // exit;
         $response_temp[] = $this->client->call('pipelines', [],  $pipelines, 'set');
      }
      return $response_temp;
   }

   public function addDeletePipeline(PipelineEntity $pipeline)
   {
      $this->deletable_pipelines[] = $pipeline;
   }

   public function deletePipeline()
   {
      if (count($this->deletable_pipelines) <= 0) return false;
      $cfa = [];
      $response_temp = [];
      $count = 0;
      foreach ($this->deletable_pipelines as $val) {
         $cfa[] = $val->elem_id;
         $count++;
         if ($count >= $this->client::MAX_BATCH_CALLS) {
            $response_temp[] = $this->client->call('pipelines', [],  ['request' => ['id' => [implode(',', $cfa)]]], 'delete');
            unset($cfa);
            $count = 0;
         }
      }
      if (count($cfa) > 0) {
         $response_temp[] = $this->client->call('pipelines', [],  ['request' => ['id' => [implode(',', $cfa)]]], 'delete');
      }
      return $response_temp;
   }

   public function editPipelines()
   {
      if (count($this->editable_pipelines) <= 0) return false;
      $cfa = [];
      $response_temp = [];
      $pipelines['request']['pipelines']['update'] = [];
      $count = 0;
      foreach ($this->editable_pipelines as $val) {
         $pipelines['request']['pipelines']['update'] = $val->generateQuery();
         $count++;
         if ($count >= $this->client::MAX_BATCH_CALLS) {
            $response_temp[] = $this->client->call('pipelines', [],  $pipelines, 'set');
            unset($pipelines['request']['pipelines']['update']);
            $count = 0;
         }
      }
      if (count($pipelines['request']['pipelines']['update']) > 0) {
         $response_temp[] = $this->client->call('pipelines', [],  $pipelines, 'set');
      }
      return $response_temp;
   }
}
