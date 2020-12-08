<?php
namespace Iamport;

class IamportPayment
{

    protected $response;
    protected $custom_data;

    public function __construct($response)
    {
        $this->response = $response;

        $this->custom_data = json_decode($response->custom_data);
    }

    public function __get($name)
    {
        if (isset($this->response->{$name})) {
            return $this->response->{$name};
        }
    }

    public function getCustomData($name = null)
    {
        if (is_null($name)) {
            return $this->custom_data;
        }

        if (isset($this->custom_data->{$name})) {
            return $this->custom_data->{$name};
        }

        return null;
    }

}