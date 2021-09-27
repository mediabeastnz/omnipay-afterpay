<?php

namespace Omnipay\AfterPay\Message;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class PurchaseResponse extends Response
{
    protected $script = 'https://portal.sandbox.afterpay.com/afterpay.js';

    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        if ($this->isResponseHasError())
        {
            return false;
        }

        return true;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRedirectResponse()
    {
        $output = <<<EOF
<html>
<head>
    <title>Redirecting...</title>
    <script src="%s" async></script>
</head>
<body>
    <script>
    window.onload = function() {
        AfterPay.init({countryCode: "%s"});
        AfterPay.redirect({token: "%s"});
    };
    </script>
</body>
</html>
EOF;
        $output = sprintf($output, $this->getScriptUrl(), $this->request->getCountryCode(), $this->getToken());

        return new HttpResponse($output);
    }

    /**
     * @return string
     */
    public function getScriptUrl()
    {
        return $this->script;
    }

}
