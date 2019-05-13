<?php


namespace App\GraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Request
{

    protected $rootValue;

    protected $parameters;

    protected $context;

    protected $resolveInfo;

    /**
     * @param  mixed  $rootValue  Usually contains the result returned from the parent field.
     * @param  mixed[]  $args  The arguments that were passed into the field.
     * @param  GraphQLContext  $context  Arbitrary data that is shared between all fields of a single query.
     * @param  ResolveInfo  $resolveInfo  Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     */
    public function __construct($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $this->rootValue = $rootValue;
        $this->parameters = $args;
        $this->context = $context;
        $this->resolveInfo = $resolveInfo;
    }

    /**
     * Usually contains the result returned from the parent field.
     * @return mixed
     */
    public function rootValue()
    {
        return $this->rootValue;
    }

    /**
     * Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return ResolveInfo
     */
    public function resolveInfo()
    {
        return $this->resolveInfo;
    }

    /**
     * Arbitrary data that is shared between all fields of a single query.
     * @return GraphQLContext
     */
    public function context()
    {
        return $this->context;
    }

    /**
     * Return array of parameters to be used in dependency resolving.
     * @return array
     */
    public function parameters()
    {
        return $this->parameters; /*+ [
                $this->resolveInfo,
                $this->context,
                $this
            ];*/
    }

    /**
     * Get the key / value list of parameters without null values.
     * @return array
     */
    public function parametersWithoutNulls()
    {
        return array_filter($this->parameters(), function ($p) {
            return !is_null($p);
        });
    }

    /**
     * Validates parameters
     * @param $rules array Laravel validation rules
     */
    public function validate($rules)
    {
        Validator::make($this->parameters, $rules)->validate();
    }
}
