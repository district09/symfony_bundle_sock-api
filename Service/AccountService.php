<?php

namespace DigipolisGent\SockAPIBundle\Service;

use DigipolisGent\SockAPIBundle\JsonModel\Account;
use DigipolisGent\SockAPIBundle\JsonModel\Event;

class AccountService extends SockAPIService
{
    /**
     * @var string
     */
    protected $path = '/accounts';

    protected $modelClass = '\\Digip\\SockAPIBundle\\JsonModel\\Account';

    /**
     * @param string      $name
     * @param string|null $serverId
     *
     * @return bool|Account
     */
    public function findByName($name, $serverId = null)
    {
        /** @var Account[] $accounts */
        $accounts = $this->index();

        foreach ($accounts as $acc) {
            if ($acc->getName() === $name && ($serverId === null || $acc->getServerId() == $serverId)) {
                return $acc;
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

        return $this->assertModels($data, '\\Digip\\SockAPIBundle\\JsonModel\\Event');
    }
}
