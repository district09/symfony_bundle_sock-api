<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class FtpUser extends ArrayMappable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $accountId;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var string
     */
    protected $host;

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
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     *
     * @return $this
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param string $directory
     *
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    protected static function mapArray(array $data)
    {
        $object = new self();
        $object->setId($data['id']);
        $object->setAccountId($data['account_id']);
        $object->setHost($data['host']);
        $object->setUser($data['user']);
        $object->setDirectory($data['directory']);
        return $object;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'account_id' => $this->getAccountId(),
            'host' => $this->getHost(),
            'user' => $this->getUser(),
            'directory' => $this->getDirectory(),
        );
    }
}
