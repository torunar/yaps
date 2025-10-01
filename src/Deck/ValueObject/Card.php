<?php

declare(strict_types=1);

namespace Torunar\Yaps\Deck\ValueObject;

use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\State;
use Torunar\Yaps\Deck\Enum\Suit;

readonly class Card
{
    public function __construct(
        public Suit $suit,
        public Rank $rank,
        public State $state = State::Closed,
    ) {
    }

    public function getOpen(): self
    {
        return new self($this->suit, $this->rank, State::Open);
    }

    public function getClosed(): self
    {
        return new self($this->suit, $this->rank, State::Closed);
    }
}
