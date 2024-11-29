<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Factory;

use Torunar\Yaps\Deck\Service\StackService;
use Torunar\Yaps\Game\Service\HandService;

readonly class HandServiceFactory
{
    public function getService(): HandService
    {
        return new HandService(new StackService());
    }
}
