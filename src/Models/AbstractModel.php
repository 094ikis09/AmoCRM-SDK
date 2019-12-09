<?php

namespace AmoCRM\Models;

use AmoCRM\Contracts\AmoCRMInterface;

/**
 * Базовая модель
 */
abstract class AbstractModel
{

    /**
     * @var AmoCRMInterface
     */
    protected $client;

    /**
     * AbstractModel constructor.
     * @param AmoCRMInterface $client
     */
    public function __construct(AmoCRMInterface $client)
    {
        $this->client = $client;
    }
}
