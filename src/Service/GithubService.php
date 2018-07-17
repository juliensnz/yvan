<?php

namespace App\Service;

use Github\Api\Repo;
use Github\Client;

class GithubService
{
    protected $client;

    public function __construct($githubToken)
    {
        $client = new Client();
        $client->authenticate($githubToken, null, Client::AUTH_HTTP_TOKEN);
        $this->client = $client;
    }

    /**
     * @return Repo
     */
    protected function getRepoClient()
    {
        return $this->client->api('repo');
    }
}
