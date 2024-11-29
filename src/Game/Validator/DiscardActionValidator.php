<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Validator;

use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\ValueObject\Card;

readonly class DiscardActionValidator
{
    public function canBeDiscardedOn(Card $topCard, ?Card $bottomCard = null): bool
    {
        if (!$bottomCard) {
            return $topCard->rank === Rank::Ace;
        }

        if ($topCard->suit !== $bottomCard->suit) {
            return false;
        }

        return $topCard->rank->value - $bottomCard->rank->value === 1;
    }
}
