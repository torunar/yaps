<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\ValueObject;

use Torunar\Yaps\Deck\ValueObject\Stack;

readonly class Hand
{
    public function __construct(
        public Stack $stockPile,
        public Stack $wastePile,
    ) {
    }
}
