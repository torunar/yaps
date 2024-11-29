<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Service;

use Closure;
use Torunar\Yaps\Deck\Factory\DeckFactory;
use Torunar\Yaps\Deck\ValueObject\Stack;

readonly class DeckService
{
    public function __construct(
        private DeckFactory $deckFactory,
        private Closure $deckShuffler,
    ) {
    }

    public function getShuffledDeck(): Stack
    {
        $orderedDeck = $this->deckFactory->getDeck();

        return ($this->deckShuffler)($orderedDeck);
    }
}
