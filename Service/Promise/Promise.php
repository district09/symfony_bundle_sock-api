<?php

namespace DigipolisGent\SockAPIBundle\Service\Promise;

class Promise
{
    /**
     * @var bool
     */
    protected $isResolved = false;

    /**
     * @var bool
     */
    protected $isSuccessful;

    /**
     * @var array|callable[]
     */
    protected $successHandlers = array();

    /**
     * @var array|callable[]
     */
    protected $errorHandlers = array();

    /**
     * @return bool
     */
    public function getIsResolved()
    {
        return $this->isResolved;
    }

    /**
     * @param bool $isSuccessful
     *
     * @return $this
     */
    public function setResolved($isSuccessful = true)
    {
        $this->isResolved = true;
        $this->isSuccessful = $isSuccessful;

        $this->executeHandlers(
            $isSuccessful ? $this->successHandlers : $this->errorHandlers
        );

        return $this;
    }

    /**
     * @param $callable
     *
     * @return $this
     */
    public function then($callable)
    {
        $this->successHandlers[] = $callable;

        if ($this->isResolved && $this->isSuccessful === true) {
            $this->executeHandlers([$callable]);
        }

        return $this;
    }

    /**
     * @param $callable
     *
     * @return $this
     */
    public function error($callable)
    {
        $this->errorHandlers[] = $callable;

        if ($this->isResolved && $this->isSuccessful === false) {
            $this->executeHandlers([$callable]);
        }

        return $this;
    }

    public function waitForResolution()
    {
        $this->setResolved();
    }

    public function executeHandlers($handlers, array $context = array())
    {
        foreach ($handlers as $h) {
            call_user_func_array($h, [$this, $context]);
        }
    }
}
