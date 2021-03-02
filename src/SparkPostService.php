<?php

namespace Leandreaci\Lumen\SparkPost;

use GuzzleHttp\Client;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use SparkPost\SparkPost;

/**
 * Class SparkPostService.
 *
 * @package Nord\Lumen\SparkPost
 */
class SparkPostService implements SparkPostServiceContract
{
    /**
     * @var SparkPost
     */
    private SparkPost $client;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $client = $config['client'];
        $clientConfig = isset($client) ? $client : [];
        $this->client = new SparkPost(new GuzzleAdapter(new Client()), $clientConfig);
    }

    /**
     * @inheritdoc
     */
    public function send(array $config)
    {
        return $this->client->transmissions->post($config);
    }
}
