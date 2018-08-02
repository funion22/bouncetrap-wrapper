<?php

namespace Optimail\BounceTrap;

use stdClass;

class Response
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Response constructor.
     * @param $response
     */
    public function __construct(stdClass $response)
    {
        if (isset($response->data)) {
            $this->data = $response->data;
        }

        if (isset($response->errors)) {
            $this->errors = $response->errors;
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return (bool)count($this->errors());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'errors' => $this->errors
        ];
    }

    /**
     * Return the data as a JSON string
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->data->{$name};
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value): void
    {
        $this->data->{$name} = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __isset(string $name): bool
    {
        return isset($this->data->{$name});
    }

    /**
     * @param $name
     */
    public function __unset(string $name): void
    {
        unset($this->data->{$name});
    }
}