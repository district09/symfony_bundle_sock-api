<?php

namespace DigipolisGent\SockAPIBundle\Service\Promise;

class PromiseQueue extends Promise
{
    /**
     * @var Promise[]
     */
    protected $promises = [];

    /**
     * @return array
     */
    public function getPromises()
    {
        return $this->promises;
    }

    /**
     * @param array $promises
     *
     * @return $this
     */
    public function setPromises($promises)
    {
        $this->promises = $promises;

        return $this;
    }

    /**
     * @param Promise $promise
     *
     * @return $this
     */
    public function addPromise(Promise $promise)
    {
        $this->promises[] = $promise;

        return $this;
    }

    public function waitForResolution()
    {
        foreach ($this->promises as $promise) {
            $promise->waitForResolution();
        }

        parent::waitForResolution();
    }
}
