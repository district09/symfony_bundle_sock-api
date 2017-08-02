<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class Application extends ArrayMappable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $accountId;

    /**
     * @var int
     */
    protected $technology = 'php-fpm';

    /**
     * @var string
     */
    protected $documentRoot = 'current';

    /**
     * @var array|string[]
     */
    protected $aliases = array();

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
    public function getDocumentRoot()
    {
        return $this->documentRoot;
    }

    /**
     * @param string $documentRoot
     *
     * @return $this
     */
    public function setDocumentRoot($documentRoot)
    {
        $this->documentRoot = $documentRoot;

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
     * @return array|\string[]
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param array|\string[] $aliases
     *
     * @return $this
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;

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
        $object->setAccountId($data['account_id']);
        $object->setAliases($data['aliases']);
        $object->setDocumentRoot($data['documentroot_suffix']);
        $object->setCreatedAt(new \DateTime($data['created_at']));

        return $object;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'account_id' => $this->getAccountId(),
            'name' => $this->getName(),
            'documentroot_suffix' => $this->getDocumentRoot(),
            'aliases' => $this->getAliases(),
            'technology' => $this->technology,
        );
    }
}
