<?php

namespace DigipolisGent\SockAPIBundle\Service;

use DigipolisGent\SockAPIBundle\JsonModel\Application;
use DigipolisGent\SockAPIBundle\JsonModel\Event;

class ApplicationService extends SockAPIService
{
    /**
     * @var string
     */
    protected $path = '/applications';

    protected $modelClass = '\\DigipolisGent\\SockAPIBundle\\JsonModel\\Application';

    /**
     * @param int    $accountId
     * @param string $name
     *
     * @return bool|Application
     */
    public function findByName($accountId, $name)
    {
        /** @var Application[] $apps */
        $apps = $this->index(array('account_id' => $accountId));

        foreach ($apps as $app) {
            if ($app->getName() === $name) {
                return $app;
            }
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return array|Event[]
     */
    public function events($id)
    {
        $data = $this->doRequest('GET', $this->constructUrl($id).'/events');

        return $this->assertModels($data, '\\DigipolisGent\\SockAPIBundle\\JsonModel\\Event');
    }
}
