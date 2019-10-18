<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\PipelineEntity;
use AmoCRM\Exceptions\AmoCRMException;
use AmoCRM\Models\BaseModel;

class PipelineModel extends BaseModel
{
    /**
     * @return PipelineEntity[]
     */
    public function getPipelines()
    {
        $res = $this->client->call('/api/v2/pipelines');
        $temp = array();
        foreach ($res['_embedded']['items'] as $pipeline) {
            $temp[] = new PipelineEntity($pipeline);
        }
        return $temp;
    }

    /**
     * @return PipelineEntity|bool
     */
    public function getPipelineById($id)
    {
        if (!is_numeric($id)) {
            throw new AmoCRMException('$id должна быть числом');
        }
        $res = $this->client->call('/api/v2/pipelines');

        if (!array_key_exists($id, $res['_embedded']['items'])) return false;
        return new PipelineEntity($res['_embedded']['items'][$id]);
    }

    /**
     * @return PipelineEntity
     */
    public function getMainPipeline()
    {
        $res = $this->client->call('/api/v2/pipelines');
        foreach ($res['_embedded']['items'] as $pipeline) {
            $temp = new PipelineEntity($pipeline);

            if ($temp->getIsMain()) {
                return $temp;
            }
        }
    }

    /**
     * @param string $pipelineName
     * @return PipelineEntity[]|null
     */
    public function getPipelinesByName($pipelineName)
    {
        if (!is_string($pipelineName)) {
            throw new AmoCRMException('$pipelineName должна быть строкой');
        }
        $res = $this->client->call('/api/v2/pipelines');
        $temp = null;

        foreach ($res['_embedded']['items'] as $pipeline) {
            $ePipeline = new PipelineEntity($pipeline);
            if (mb_strtolower($ePipeline->getName()) === mb_strtolower($pipelineName)) {
                $temp[] = $ePipeline;
            }
        }
        return $temp;
    }

    /**
     * @param PipelineEntity|PipelineEntity[] $pipelines
     */
    public function deletePipelines($pipelines)
    {
        $temp = array();
        if (is_array($pipelines)) {
            foreach ($pipelines as $value) {
                if (!($value instanceof PipelineEntity)) {
                    throw new AmoCRMException('Передан не верный параметр');
                }
                $temp[] = $value->getId();
            }
        } else {
            if (!($pipelines instanceof PipelineEntity)) {
                throw new AmoCRMException('Передан не верный параметр');
            }
            $temp[] = $pipelines->getId();
        }
        return $this->client->call('/private/api/v2/json/pipelines/delete', array(), array('request' => array('id' => $temp)));
    }

    public function addPipelines($pipelines)
    {
        $aPipelines['request']['pipelines']['add'] = array();
        if (is_array($pipelines)) {
            foreach ($pipelines as $value) {
                if (!($value instanceof PipelineEntity)) {
                    throw new AmoCRMException('Передан не верный параметр');
                }
                $aPipelines['request']['pipelines']['add'][] = $value->generateQuery();
            }
        } else {
            if (!($pipelines instanceof PipelineEntity)) {
                throw new AmoCRMException('Передан не верный параметр');
            }
            $aPipelines['request']['pipelines']['add'][] = $pipelines->generateQuery();
        }
        return $this->client->call('/private/api/v2/json/pipelines/set', array(), $aPipelines);
    }

    public function updatePipelines($pipelines)
    {
        $aPipelines['request']['pipelines']['update'] = array();
        if (is_array($pipelines)) {
            foreach ($pipelines as $value) {
                if (!($value instanceof PipelineEntity)) {
                    throw new AmoCRMException('Передан не верный параметр');
                }
                $aPipelines['request']['pipelines']['update'][$value->getId()] = $value->generateQuery('update');
            }
        } else {
            if (!($pipelines instanceof PipelineEntity)) {
                throw new AmoCRMException('Передан не верный параметр');
            }
            $aPipelines['request']['pipelines']['update'][$pipelines->getId()] = $pipelines->generateQuery('update');
        }
        return $this->client->call('/private/api/v2/json/pipelines/set', array(), $aPipelines);
    }
}
