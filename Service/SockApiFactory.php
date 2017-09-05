<?php

namespace DigipolisGent\SockAPIBundle\Service;

use Digip\DeployBundle\Entity\Settings;
use DigipolisGent\SockAPIBundle\Service\SockAPIService;

class SockApiFactory
{
    /**
     * @var Settings
     */
    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param SockAPIService $service
     *
     * @return SockAPIService
     */
    public function configure($service)
    {
        $service
            ->setHost($this->settings->getSockDomain())
            ->setUserToken($this->settings->getSockUserToken())
            ->setClientToken($this->settings->getSockClientToken())
        ;

        return $service;
    }
}
