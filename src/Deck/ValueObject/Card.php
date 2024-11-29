<?php

declare(strict_types=1);

namespace Torunar\Yaps\Deck\ValueObject;

use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;

readonly class Card
{
    public function __construct(
        public Suit $suit,
        public Rank $rank,
    ) {
    }
}
