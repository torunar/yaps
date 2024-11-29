<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Factory;

use Torunar\Yaps\Deck\Factory\DeckFactory;
use Torunar\Yaps\Deck\ValueObject\Stack;
use Torunar\Yaps\Game\Service\DeckService;

readonly class DeckServiceFactory
{
    public function getService(): DeckService
    {
        $deckFactory = new DeckFactory();
        $deckShuffler = static function (Stack $stack): Stack {
            $cards = $stack->cards;
            shuffle($cards);

            return new Stack(...$cards);
        };

        return new DeckService($deckFactory, $deckShuffler);
    }
}
