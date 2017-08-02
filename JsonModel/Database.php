<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class Database extends ArrayMappable
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
    protected $name;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $engine;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var array|string[]
     */
    protected $hosts;

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
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @param array|string[] $hosts
     *
     * @return $this
     */
    public function setHosts(array $hosts)
    {
        $this->hosts = $hosts;

        return $this;
    }

    protected static function mapArray(array $data)
    {
        $object = new self();
        $object->setId($data['id']);
        $object->setName($data['name']);
        $object->setHosts($data['hosts']);
        $object->setEngine($data['engine']);
        $object->setAccountId($data['account_id']);

        if (isset($data['login'])) {
            $object->setLogin($data['login']);
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'login' => $this->getLogin(),
            'password' => $this->getPassword(),
            'hosts' => $this->getHosts(),
            'account_id' => $this->getAccountId(),
            'engine' => $this->getEngine(),
        );
    }
}
