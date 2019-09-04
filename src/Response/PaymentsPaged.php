<?php

namespace Iamport\RestClient\Response;

/**
 * Class PaymentsPaged.
 */
class PaymentsPaged
{
    protected $total;
    protected $previous;
    protected $next;
    protected $payments;

    /**
     * PaymentsPaged constructor.
     *
     * @param $response
     */
    public function __construct($response)
    {
        $this->total    = $response->total;
        $this->previous = $response->previous;
        $this->next     = $response->next;

        $this->payments = [];
        foreach ($response->list as $row) {
            $this->payments[] = new Payment((object) $row);
        }
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @return int
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return array
     */
    public function getPayments()
    {
        return $this->payments;
    }
}
