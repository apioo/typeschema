<?php

namespace App\Service;

use GuzzleHttp\Client;
use PSX\Framework\Config\ConfigInterface;
use PSX\Json;

class CaptchaVerifier
{
    private Client $httpClient;
    private string $secret;

    public function __construct(ConfigInterface $config)
    {
        $this->httpClient = new Client();
        $this->secret = $config->get('recaptcha_secret');
    }

    public function verify(?string $recaptchaResponse): bool
    {
        if ($recaptchaResponse === null) {
            return false;
        }

        $response = $this->httpClient->post('https://www.google.com/recaptcha/api/siteverify', [
            'headers' => [
                'User-Agent' => 'typeschema.org'
            ],
            'form_params' => [
                'secret'   => $this->secret,
                'response' => $recaptchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
            ],
            'verify' => false
        ]);

        if ($response->getStatusCode() == 200) {
            $data = Json\Parser::decode((string) $response->getBody());
            if (isset($data->success) && $data->success === true) {
                return true;
            }
        }

        return false;
    }
}
