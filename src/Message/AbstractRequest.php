<?php

namespace Omnipay\AfterPay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://api.secure-afterpay.com.au/v1';
    protected $testEndpoint = 'https://api-sandbox.secure-afterpay.com.au/v1';


    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * @return mixed
     */
    public function getMerchantSecret()
    {
        return $this->getParameter('merchantSecret');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchantSecret($value)
    {
        return $this->setParameter('merchantSecret', $value);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        return $headers;
    }


    public function send()
    {
        $data = $this->getData();
        $authorization = $this->buildAuthorizationHeader();
        $headers = array_merge(
            $this->getHeaders(),
            [
                'Authorization' => $authorization,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        return $this->sendData($data, $headers);
    }

    /**
     * @param mixed $data
     * @return \Omnipay\AfterPay\Message\Response
     * @throws \Guzzle\Http\Exception\RequestException
     */
    public function sendData($data, array $headers = null)
    {
        try {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndPoint(),
                $headers,
                json_encode($data)
            );
        } catch (ClientErrorResponseException $e) {
            $httpResponse = $e->getResponse();
        }

        return (new Response($this, $httpResponse));

    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @param \Guzzle\Http\Message\Response $httpResponse
     * @return array
     */
    protected function parseResponseData(GuzzleResponse $httpResponse)
    {
        return $httpResponse->json();
    }

    /**
     * @param mixed $data
     * @return \Omnipay\AfterPay\Message\Response
     */
    protected function createResponse($data)
    {
        return new Response($this, $data);
    }

    /**
     * @return string
     */
    protected function buildAuthorizationHeader()
    {
        $merchantId = $this->getMerchantId();
        $merchantSecret = $this->getMerchantSecret();

        return 'Basic ' . base64_encode($merchantId . ':' . $merchantSecret);
    }
}
