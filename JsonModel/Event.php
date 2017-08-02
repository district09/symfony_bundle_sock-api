<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class Event extends ArrayMappable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $receiver;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var string
     */
    protected $state;

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
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param string $receiver
     *
     * @return $this
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     *
     * @return $this
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    protected static function mapArray(array $data)
    {
        $object = new self();
        $object->setId($data['id']);
        $object->setSender($data['sender']);
        $object->setReceiver($data['receiver']);
        $object->setState($data['state']);

        return $object;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'sender' => $this->getSender(),
            'receiver' => $this->getReceiver(),
            'state' => $this->getState(),
        );
    }
}
