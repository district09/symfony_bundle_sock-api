<?php

namespace DigipolisGent\SockAPIBundle\Service\Event;

use Digip\DeployBundle\Task\Messenger;
use DigipolisGent\SockAPIBundle\Service\SockAPIService;

class Poller
{
    const STATE_IN_PROGRESS = 'progress';
    const STATE_READY = 'ready';
    const STATE_EXPIRED = 'expired';
    const STATE_ERROR = 'error';

    /** @var SockAPIService */
    protected $service;

    /**
     * @var string
     */
    protected $taskName;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $maxTries = 1000;

    /**
     * @var int
     */
    protected $tries = 0;

    /**
     * @var string
     */
    protected $state = self::STATE_IN_PROGRESS;

    /**
     * @param SockAPIService $service
     * @param int            $id
     * @param string         $taskName
     */
    public function __construct(SockApiService $service, $id, $taskName)
    {
        $this->service = $service;
        $this->id = $id;
        $this->taskName = $taskName;
    }

    /**
     * @return bool
     */
    public function hasEnded()
    {
        return $this->state !== self::STATE_IN_PROGRESS;
    }

    public function isSuccess()
    {
        return $this->state === self::STATE_READY;
    }

    public function getState()
    {
        return $this->state;
    }

    public function poll()
    {
        if ($this->hasEnded()) {
            return true;
        }

        if ($this->tries === 0 || $this->tries % 10 === 0) {
            Messenger::send(sprintf("polling event queue for '%s' (attempt #%s)", $this->taskName, $this->tries));
        }

        $events = $this->service->events($this->id);

        if (!count($events)) {
            $this->state = self::STATE_READY;

            return true;
        }

        foreach ($events as $e) {
            if ($e->getState() === 'failed') {
                $this->state = self::STATE_ERROR;
            }
        }

        ++$this->tries;

        if ($this->tries > $this->maxTries) {
            $this->state = self::STATE_EXPIRED;

            return false;
        }
    }

    public function waitForFinish($exceptionOnFailure = false)
    {
        while (!$this->hasEnded()) {
            $this->poll();
            sleep(2);
        }

        if ($exceptionOnFailure && !$this->isSuccess()) {
            if ($this->state === self::STATE_EXPIRED) {
                throw new \Exception(sprintf('sock API command "%s" timed out', $this->taskName));
            }
            throw new \Exception(sprintf('sock API command "%s" failed', $this->taskName));
        }
    }
}
