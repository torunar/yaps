<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Service;

use Torunar\Yaps\Deck\Service\StackService;
use Torunar\Yaps\Deck\ValueObject\Stack;
use Torunar\Yaps\Game\ValueObject\Hand;

readonly class HandService
{
    public function __construct(
        private StackService $stackService,
    ) {
    }

    public function revealNextCard(Hand $talon): Hand
    {
        if ($talon->stockPile->isEmpty()) {
            return $this->rebuildTalon($talon);
        }

        $drawnCard = $this->stackService->getTopCard($talon->stockPile);
        $newStockPile = $this->stackService->getSubstackWithoutTopCard($talon->stockPile);
        $newWastePile = new Stack(...[...$talon->wastePile->cards, $drawnCard]);

        return new Hand(
            $newStockPile,
            $newWastePile,
        );
    }

    public function takeOutCard(Hand $talon): Hand
    {
        return new Hand(
            $talon->stockPile,
            $this->stackService->getSubstackWithoutTopCard($talon->wastePile),
        );
    }

    private function rebuildTalon(Hand $talon): Hand
    {
        return new Hand(
            new Stack(...array_reverse($talon->wastePile->cards)),
            new Stack(),
        );
    }
}
