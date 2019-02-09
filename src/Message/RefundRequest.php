<?php

namespace Omnipay\Afterpay\Message;

class RefundRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return array (
            'amount' => array(
                'amount' => $this->getAmount(),
                'currency' => $this->getCurrency()
            )
        );
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getTransactionReference() . '/refund';
    }
}
