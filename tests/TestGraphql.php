<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestResponse;

trait TestGraphql
{

    /**
     * Execute a query as if it was sent as a request to the server.
     *
     * @param  string $query
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function query(string $query): TestResponse
    {
        return $this->postGraphQL(
            [
                'query' => $query,
            ]
        );
    }

    /**
     * Execute a query as if it was sent as a request to the server.
     *
     * @param  string $query
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function mutation(string $mutation): TestResponse
    {
        return $this->query("mutation {{$mutation}}");
    }

    /**
     * Execute a query as if it was sent as a request to the server.
     *
     * @param  mixed[] $data
     * @param  mixed[] $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function postGraphQL(array $data, array $headers = []): TestResponse
    {
        return $this->postJson(
            'graphql',
            $data,
            $headers
        );
    }
}
