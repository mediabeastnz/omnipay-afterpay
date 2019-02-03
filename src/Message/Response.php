<?php

namespace Omnipay\AfterPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{

    public function getData()
    {
        $contents = json_decode($this->data->getBody(),true);
        return $contents;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if ($this->isRedirect()) {
            return false;
        }

        if (array_key_exists('errorCode', $this->getData())) {
            return false;
        }

        return true;
    }

}
