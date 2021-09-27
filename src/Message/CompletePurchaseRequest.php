<?php

namespace Omnipay\AfterPay\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return array(
            'token'             => $this->httpRequest->get('orderToken'),
            'merchantReference' => $this->getTransactionReference(),
        );
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/capture';
    }
}
