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
        $tokenManager = new TokenManager($parameters);

        return function (callable $handler) use ($tokenManager) {
            return function (RequestInterface $request, array $options) use ($handler, $tokenManager) {
                $request = $request->withHeader('Authorization', 'Bearer ' . $tokenManager->getToken());
                return $handler($request, $options);
            };
        };
    }
}
