<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

declare(strict_types=1);

namespace Torunar\Yaps\Deck\Enum;

enum Suit
{
    case Hearts;

    case Clubs;

    case Diamonds;

    case Spades;

    public function getColor(): SuitColor
    {
        return match ($this) {
            self::Hearts, self::Diamonds => SuitColor::Red,
            self::Clubs, self::Spades => SuitColor::Black,
        };
    }
}
