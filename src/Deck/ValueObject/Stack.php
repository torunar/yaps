<?php

declare(strict_types=1);

namespace Torunar\Yaps\Deck\ValueObject;

readonly class Stack
{
    /** @var Card[] */
    public array $cards;

    public function __construct(Card ...$cards)
    {
        $this->cards = $cards;
    }

    public function getCardCount(): int
    {
        return count($this->cards);
    }

    public function isEmpty(): bool
    {
        return $this->getCardCount() === 0;
    }
}
