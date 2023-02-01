<?php
/*
    Copyright (c) 2023, Alexander Jentz
    All rights reserved.

    This source code is licensed under the BSD-style license found in the
    LICENSE file in the root directory of this source tree. 
*/

namespace AJToolbox\RouteActions\Traits;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

trait withRamseyUUID
{
    public function view(string $name, array $params = []): Response
    {
        $view = Twig::fromRequest($this->request());
        return $view->render($this->response(), $name, $params);
    }
}
