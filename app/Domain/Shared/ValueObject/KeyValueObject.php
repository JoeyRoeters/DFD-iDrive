<?php

namespace App\Domain\Shared\ValueObject;

class KeyValueObject
{
    public function __construct(
        private string $key,
        private mixed $value
    ) {
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return KeyValueObject
     */
    public function setKey(string $key): KeyValueObject
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return KeyValueObject
     */
    public function setValue(mixed $value): KeyValueObject
    {
        $this->value = $value;
        return $this;
    }

}
