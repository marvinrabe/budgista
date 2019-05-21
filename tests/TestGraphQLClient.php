<?php

namespace Tests;

use GraphQL\Mutation;
use GraphQL\Query;
use Illuminate\Foundation\Testing\TestResponse;

class TestGraphQLClient
{

    protected $endpoint;

    /**
     * GraphQLClient constructor.
     * @param  Query|Mutation  $builder
     * @param $fun
     */
    protected function __construct($builder, $fun)
    {
        $this->builder = $builder;
        $this->endpoint = $fun;
    }

    public static function query($object, $fun)
    {
        return new self(new Query($object), $fun);
    }

    public static function mutation($object, $fun)
    {
        return new self(new Mutation($object), $fun);
    }

    public function setArguments($arguments)
    {
        $this->builder->setArguments($arguments);
        return $this;
    }

    public function setSelectionSet($selectionSet)
    {
        $this->builder->setSelectionSet($this->translateSelection($selectionSet));
        return $this;
    }

    protected function translateSelection($arguments)
    {
        return collect($arguments)
            ->map(function ($value, $key) {
                if (is_array($value)) {
                    return (new Query($key))->setSelectionSet($this->translateSelection($value));
                }
                return $value;
            })
            ->values()
            ->toArray();
    }

    /**
     * @return TestResponse
     */
    public function getData()
    {
        return ($this->endpoint)($this->getGql());
    }

    /**
     * Returns GQL string.
     * @return string
     */
    public function getGql()
    {
        return (string) $this->builder;
    }

}
