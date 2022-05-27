<?php

namespace Braspag\Http\Factories\CartaoProtegido;

use Braspag\Entities\CartaoProtegido\Parameters;
use Closure;
use Psr\Http\Message\RequestInterface;

class BearerMiddleware
{
    /**
     * @param Parameters $parameters
     * @return Closure
     */
    public static function handle(Parameters $parameters): Closure
    {
        return function (callable $handler) use ($parameters) {
            return function (RequestInterface $request, array $options) use ($handler, $parameters) {
                $request = $request->withHeader('Authorization', 'Bearer ' . TokenManager::get($parameters));
                return $handler($request, $options);
            };
        };
    }
}
