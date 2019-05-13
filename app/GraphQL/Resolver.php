<?php

namespace App\GraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;

abstract class Resolver
{

    /**
     * The container instance.
     * @var Container
     */
    protected $container;

    /**
     * Create a new resolver instance.
     * @param  Container  $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $request = new Request($rootValue, $args, $context, $resolveInfo);

        $parameters = $this->resolveDependencies($request);

        return $this->respond(...array_values($parameters));
    }

    protected function resolveDependencies(Request $request)
    {
        $reflection = new ReflectionMethod($this, 'respond');

        $result = [];
        foreach ($reflection->getParameters() as $key => $parameter) {
            $result[$key] = $this->resolveDependency($request, $parameter);
        }
        return $result;
    }

    protected function resolveDependency(Request $request, ReflectionParameter $parameter)
    {
        $parameters = $request->parametersWithoutNulls();

        if ($parameter->getClass()) {
            if ($parameter->getClass()->name == Request::class) {
                return $request;
            }

            $instance = $this->container->make($parameter->getClass()->name);

            if ($model = $this->bindEloquentModels($request, $instance, $parameter->name)) {
                return $model;
            }

            return $instance;
        }

        if (isset($parameters[$parameter->name])) {
            return $parameters[$parameter->name];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new RuntimeException("No default value for {$parameter->name} in ".static::class);
    }

    protected function bindEloquentModels(Request $request, $instance, $name)
    {
        if (!$instance instanceof UrlRoutable) {
            return null;
        }

        $parameters = $request->parametersWithoutNulls();

        if (!$parameterName = static::getEloquentParameterName($name, $parameters)) {
            return null;
        }

        $parameterValue = $parameters[$parameterName];

        if (!$model = $instance->resolveRouteBinding($parameterValue)) {
            throw (new ModelNotFoundException)->setModel(get_class($instance));
        }

        return $model;
    }

    protected static function getEloquentParameterName($name, $parameters)
    {
        if (array_key_exists($name, $parameters)) {
            return $name;
        }

        if (array_key_exists($snakedName = Str::snake($name), $parameters)) {
            return $snakedName;
        }

        if (array_key_exists('id', $parameters)) {
            return 'id';
        }
    }

}
