<?php
/*
    Copyright (c) 2023, Alexander Jentz
    All rights reserved.

    This source code is licensed under the BSD-style license found in the
    LICENSE file in the root directory of this source tree. 
*/

namespace AJToolbox\RouteActions\Traits;

use Ramsey\Uuid\Uuid;

trait withRamseyUUID
{
    protected function newUuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
