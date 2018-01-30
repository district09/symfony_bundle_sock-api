<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class Account extends ArrayMappable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $serverId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array|SshKey[]|int[]
     */
    protected $sshKeys = array();

    /**
     * @var Application[]
     */
    protected $applications = array();

    /**
     * @var Database[]
     */
    protected $databases = array();

    /**
     * @var FtpUser[]
     */
    protected $ftpUsers = array();

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * @param int $serverId
     *
     * @return $this
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array|SshKey[]|int[]
     */
    public function getSshKeys()
    {
        return $this->sshKeys;
    }

    /**
     * @param array|SshKey[]|int[] $sshKeys
     *
     * @return $this
     */
    public function setSshKeys($sshKeys)
    {
        $this->sshKeys = $sshKeys;

        return $this;
    }

    /**
     * @return Application[]
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param Application[] $applications
     *
     * @return $this
     */
    public function setApplications($applications)
    {
        $this->applications = $applications;

        return $this;
    }

    /**
     * @return Database[]
     */
    public function getDatabases()
    {
        return $this->databases;
    }

    /**
     * @param Database[] $databases
     *
     * @return $this
     */
    public function setDatabases($databases)
    {
        $this->databases = $databases;

        return $this;
    }

    /**
     * @return FtpUser[]
     */
    public function getFtpUsers()
    {
        return $this->ftpUsers;
    }

    /**
     * @param FtpUser[] $ftpUsers
     *
     * @return $this
     */
    public function setFtpUsers($ftpUsers)
    {
        $this->ftpUsers = $ftpUsers;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    protected static function mapArray(array $data)
    {
        $object = new self();
        $object->setId($data['id']);
        $object->setName($data['name']);
        $object->setServerId($data['virtual_server_id']);
        $object->setCreatedAt(new \DateTime($data['created_at']));
        $object->setApplications($data['applications']);
        $object->setDatabases($data['databases']);
        $object->setFtpUsers($data['ftp_users']);
        $object->setSshKeys($data['ssh_keys']);
        return $object;
    }

    public function toArray()
    {
        $apps = array();
        foreach ($this->getApplications() as $app) {
            $apps[] = $app->toArray();
        }

        $sshKeys = array();
        foreach ($this->getSshKeys() as $sshKey) {
            $sshKeys[] = $sshKey instanceof SshKey ? $sshKey->toArray() : $sshKey;
        }

        return array(
            'id' => $this->getId(),
            'virtual_server_id' => $this->getServerId(),
            'name' => $this->getName(),
            'applications' => $apps,
            'ssh_key_ids' => $sshKeys,
        );
    }
}
