<?php

namespace AmoCRM\Models;

use AmoCRM\Entities\PipelineEntity;
use AmoCRM\Exceptions\AmoCRMException;

/**
 * Модель для работы с воронками
 * @package AmoCRM\Models
 */
class PipelineModel extends AbstractModel
{

    /**
     * Создание задач (по одной или пакетно)
     *
     * @param PipelineEntity|PipelineEntity[] $pipelines
     * @return array ответ от AmoCRM
     * @throws AmoCRMException
     */
    public function createPipelines($pipelines)
    {
        $temp['request']['pipelines']['add'] = array();
        if (is_array($pipelines)) {
            foreach ($pipelines as $item) {
                if (!($item instanceof PipelineEntity)) {
                    throw new AmoCRMException('Передаваемая переменная не является PipelineEntity');
                }
                $temp['request']['pipelines']['add'][] = $item->generateQuery();
            }
        } else {
            if (!($pipelines instanceof PipelineEntity)) {
                throw new AmoCRMException('Передаваемая переменная не является PipelineEntity');
            }
            $temp['request']['pipelines']['add'][] = $pipelines->generateQuery();
        }
        return $this->client->call('/private/api/v2/json/pipelines/set', 'POST', true, false, false, array(), $temp);
    }

    /**
     * Получить воронки
     *
     * @return PipelineEntity[]
     */
    public function getPipelines()
    {
        $res = $this->client->call('/api/v2/pipelines', 'GET');
        $temp = array();
        foreach ($res['_embedded']['items'] as $pipeline) {
            $temp[] = new PipelineEntity($pipeline);
        }
        return $temp;
    }

    /**
     * Получить воронку по id
     *
     * @param int $id
     * @return PipelineEntity|bool
     * @throws AmoCRMException
     */
    public function getPipelineById($id)
    {
        if (!is_numeric($id)) {
            throw new AmoCRMException('$id должна быть числом');
        }
        $res = $this->client->call('/api/v2/pipelines', 'GET');

        if (!array_key_exists($id, $res['_embedded']['items'])) return false;
        return new PipelineEntity($res['_embedded']['items'][$id]);
    }

    /**
     * Получить главную воронку
     *
     * @return PipelineEntity|null
     */
    public function getMainPipeline()
    {
        $res = $this->client->call('/api/v2/pipelines', 'GET');
        foreach ($res['_embedded']['items'] as $pipeline) {
            $temp = new PipelineEntity($pipeline);

            if ($temp->getIsMain()) {
                return $temp;
            }
        }
        return null;
    }

    /**
     * Получить воронки по имени
     *
     * @param string $pipelineName
     * @return PipelineEntity[]|null
     * @throws AmoCRMException
     */
    public function getPipelinesByName($pipelineName)
    {
        if (!is_string($pipelineName)) {
            throw new AmoCRMException('$pipelineName должна быть строкой');
        }
        $res = $this->client->call('/api/v2/pipelines', 'GET');
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
     * Удалить воронки
     *
     * @param PipelineEntity|PipelineEntity[] $pipelines
     * @return array
     * @throws AmoCRMException
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
        return $this->client->call('/private/api/v2/json/pipelines/delete', 'POST', true, false, false, array('request' => array('id' => $temp)));
    }

    /**
     * Обновить воронки
     *
     * @param PipelineEntity[]|PipelineEntity $pipelines
     * @return array
     * @throws AmoCRMException
     */
    public function updatePipelines($pipelines)
    {
        $aPipelines['request']['pipelines']['update'] = array();
        if (is_array($pipelines)) {
            foreach ($pipelines as $value) {
                if (!($value instanceof PipelineEntity)) {
                    throw new AmoCRMException('Передан не верный параметр');
                }
                $aPipelines['request']['pipelines']['update'][$value->getId()] = $value->generateQuery();
            }
        } else {
            if (!($pipelines instanceof PipelineEntity)) {
                throw new AmoCRMException('Передан не верный параметр');
            }
            $aPipelines['request']['pipelines']['update'][$pipelines->getId()] = $pipelines->generateQuery();
        }
        return $this->client->call('/private/api/v2/json/pipelines/set', 'POST', true, false, false, array(), $aPipelines);
    }
}
