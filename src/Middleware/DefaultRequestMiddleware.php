<?php

namespace Iamport\RestClient\Middleware;

use Psr\Http\Message\RequestInterface;

class DefaultRequestMiddleware
{
    public function __invoke(callable $handler)
    {
        return function (
            RequestInterface $request,
            array $options
    ) use ($handler) {
            $request = $request
                  ->withHeader('Content-Type', 'application/json; charset=utf-8')
                  ->withHeader('Accept', 'application/json');

            return $handler($request, $options);
        };
    }
}
