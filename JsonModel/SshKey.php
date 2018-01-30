<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class SshKey extends ArrayMappable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $favorite;

    /**
     * @var string
     */
    protected $key;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFavorite()
    {
        return $this->favorite;
    }

    /**
     * @param bool $favorite
     *
     * @return $this
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    protected static function mapArray(array $data)
    {
        $object = new self();
        $object->setId($data['id']);
        $object->setDescription($data['description']);
        $object->isFavorite($data['favorite']);
        $object->setKey($data['key']);
        return $object;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'favorite' => $this->isFavorite(),
            'key' => $this->getKey(),
        );
    }
}
