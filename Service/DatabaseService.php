<?php

namespace DigipolisGent\SockAPIBundle\Service;

use DigipolisGent\SockAPIBundle\JsonModel\Database;
use DigipolisGent\SockAPIBundle\JsonModel\Event;

class DatabaseService extends SockAPIService
{
    /**
     * @var string
     */
    protected $path = '/databases';

    protected $modelClass = '\\DigipolisGent\\SockAPIBundle\\JsonModel\\Database';

    /**
     * @param int    $accountId
     * @param string $name
     *
     * @return bool|Database
     */
    public function findByName($accountId, $name)
    {
        /** @var Database[] $dbs */
        $dbs = $this->index(array('account_id' => $accountId));

        foreach ($dbs as $db) {
            if ($db->getName() === $name) {
                return $db;
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
