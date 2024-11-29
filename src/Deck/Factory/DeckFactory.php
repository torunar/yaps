<?php

declare(strict_types=1);

namespace Torunar\Yaps\Deck\Factory;

use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Deck\ValueObject\Stack;

readonly class DeckFactory
{
    public function getDeck(): Stack
    {
        $cards = [];
        foreach (Suit::cases() as $suit) {
            foreach (Rank::cases() as $rank) {
                $cards[] = new Card($suit, $rank);
            }
        }

        return new Stack(...$cards);
    }
}
