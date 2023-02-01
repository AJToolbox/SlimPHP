<?php
/*
    Copyright (c) 2023, Alexander Jentz
    All rights reserved.

    This source code is licensed under the BSD-style license found in the
    LICENSE file in the root directory of this source tree. 
*/

namespace AJToolbox\RouteActions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use AJToolbox\RouteActions\Contracts\RouteActionInterface;

abstract class BaseRouteAction implements RouteActionInterface
{
    protected Request $request;
    protected Response $response;
    protected array $args;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->__execute();
    }

    public function response(): Response
    {
        return $this->response;
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function redirectTo(string $to, int $code = 303): Response
    {
        return $this->response()
            ->withHeader('Location', $to)
            ->withStatus($code);
    }

    public function write(string $data): self
    {
        $this->response->getBody()->write($data);
        return $this;
    }

    public function getFromQuery($name, $default = null)
    {
        $params = $this->request()->getQueryParams();
        if (count($params) < 1) {
            return $default;
        }
        if (!isset($params[$name])) {
            return $default;
        }
        return $params[$name];
    }

    public function respond(mixed $data = '', $force_json = false): Response
    {
        if (is_array($data) === true || $force_json === true) {
            return $this->respondJson($data);
        }
        return $this->respondPlain((string) $data);
    }

    public function respondPlain(string $data = ''): Response
    {
        if (!empty($data)) {
            $this->write($data);
        }
        return $this->response();
    }

    public function respondJson(array $data): Response
    {
        return $this->response()->withJson($data);
    }
}
