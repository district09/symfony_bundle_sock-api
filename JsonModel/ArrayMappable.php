<?php

namespace DigipolisGent\SockAPIBundle\JsonModel;

class ArrayMappable
{
    public static function fromArray(array $data)
    {
        $keys = array_keys($data);
        if (is_numeric(reset($keys))) {
            $objects = array();
            foreach ($data as $singleData) {
                $objects[] = self::fromArray($singleData);
            }

            return $objects;
        }

        return static::mapArray($data);
    }

    public function toArray()
    {
        return array();
    }

    protected static function mapArray(array $data)
    {
        return new self($data);
    }
}
