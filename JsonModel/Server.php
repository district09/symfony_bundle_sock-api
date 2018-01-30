<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class Server extends ArrayMappable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var Account[]
     */
    protected $accounts;

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
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     *
     * @return $this
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * @return Account[]
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @param Account[] $accounts
     *
     * @return $this
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;

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
        $object->setIp($data['ip']);
        $object->setHostname($data['hostname']);
        $object->setAccounts(Account::fromArray($data['accounts']));
        $object->setCreatedAt(new \DateTime($data['created_at']));
        return $object;
    }

    public function toArray()
    {
        $accounts = array();

        foreach ($this->getAccounts() as $acc) {
            $accounts = $acc->toArray();
        }

        return array(
            'id' => $this->getId(),
            'ip' => $this->getId(),
            'hostname' => $this->getId(),
            'accounts' => $accounts,
            'createdAt' => $this->getCreatedAt()->format(\DateTime::ISO8601),
        );
    }
}
