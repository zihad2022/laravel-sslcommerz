<?php

namespace Devzihad\LaravelSslcommerz\Services;

use GuzzleHttp\Client;

class SslCommerzService
{
    protected $client;

    protected $config;

    public function __construct()
    {
        $this->config = config('sslcommerz');
        $this->client = new Client([
            'base_uri' => $this->config['sandbox_mode']
                ? 'https://sandbox.sslcommerz.com'
                : 'https://securepay.sslcommerz.com',
        ]);
    }

    public function initiatePayment(array $data)
    {
        $response = $this->client->post('/gwprocess/v4/api.php', [
            'form_params' => array_merge($data, [
                'store_id' => $this->config['api_key'],
                'store_passwd' => $this->config['api_secret'],
            ]),
        ]);

        return json_decode($response->getBody(), true);
    }

    public function validateTransaction($val_id)
    {
        $response = $this->client->get('/validator/api/validationserverAPI.php', [
            'query' => [
                'val_id' => $val_id,
                'store_id' => $this->config['api_key'],
                'store_passwd' => $this->config['api_secret'],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
