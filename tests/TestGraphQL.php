<?php

namespace Tests;

trait TestGraphQL
{
    /**
     * Execute a query as if it was sent as a request to the server.
     *
     * @param string $object
     * @return TestGraphQLClient
     */
    protected function query(string $object): TestGraphQLClient
    {
        return TestGraphQLClient::query($object, function ($query) {
            return $this->postJson(
                'graphql',
                [
                    'query' => $query,
                ]
            );
        });
    }

    /**
     * Execute a query as if it was sent as a request to the server.
     *
     * @param string $object
     * @return TestGraphQLClient
     */
    protected function mutation(string $object): TestGraphQLClient
    {
        return TestGraphQLClient::mutation($object, function ($query) {
            return $this->postJson(
                'graphql',
                [
                    'query' => $query,
                ]
            );
        });
    }
}
