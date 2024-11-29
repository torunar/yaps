<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Validator;

use Torunar\Yaps\Deck\ValueObject\Card;

readonly class StackActionValidator
{
    public function canBeStackedOn(Card $topCard, ?Card $bottomCard = null): bool
    {
        if (!$bottomCard) {
            return true;
        }

        if ($topCard->suit->getColor() === $bottomCard->suit->getColor()) {
            return false;
        }

        return $bottomCard->rank->value - $topCard->rank->value === 1;
    }
}
