<?php

namespace DigipolisGent\SockAPIBundle\Service\Promise;

use DigipolisGent\SockAPIBundle\JsonModel\ArrayMappable;
use DigipolisGent\SockAPIBundle\Service\Event\Poller;

class EntityCreatePromise extends Promise
{
    /**
     * @var ArrayMappable
     */
    protected $entity;

    /**
     * @var bool
     */
    protected $isCreated = false;

    /**
     * @var bool
     */
    protected $didExist = false;

    /**
     * @var Poller
     */
    protected $poller;

    /**
     * @var string
     */
    protected $error;

    /**
     * @param ArrayMappable $entity
     */
    public function __construct(ArrayMappable $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getIsCreated()
    {
        return $this->isCreated;
    }

    /**
     * @param mixed $isCreated
     *
     * @return $this
     */
    public function setIsCreated($isCreated)
    {
        $this->isCreated = $isCreated;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDidExist()
    {
        return $this->didExist;
    }

    /**
     * @param mixed $didExist
     *
     * @return $this
     */
    public function setDidExist($didExist)
    {
        $this->didExist = $didExist;

        return $this;
    }

    /**
     * @return ArrayMappable
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param ArrayMappable $entity
     *
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return Poller
     */
    public function getPoller()
    {
        return $this->poller;
    }

    /**
     * @param Poller $poller
     *
     * @return $this
     */
    public function setPoller($poller)
    {
        $this->poller = $poller;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function waitForResolution()
    {
        if ($this->getIsResolved()) {
            return;
        }

        if ($this->poller) {
            $this->poller->waitForFinish();
            if (!$this->poller->isSuccess()) {
                $this->isCreated = false;
                $this->executeHandlers($this->errorHandlers);

                return;
            }
        }

        $this->isCreated = true;
        parent::waitForResolution();
    }
}
