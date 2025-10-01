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

    public function revealNextCard(Hand $hand): Hand
    {
        if ($hand->stockPile->isEmpty()) {
            return $this->rebuild($hand);
        }

        $drawnCard = $this->stackService->getTopCard($hand->stockPile);
        $newStockPile = $this->stackService->getSubstackWithoutTopCard($hand->stockPile);
        $newWastePile = new Stack(...[...$hand->wastePile->cards, $drawnCard]);

        return new Hand(
            $newStockPile,
            $newWastePile,
        );
    }

    public function takeOutCard(Hand $hand): Hand
    {
        return new Hand(
            $hand->stockPile,
            $this->stackService->getSubstackWithoutTopCard($hand->wastePile),
        );
    }

    private function rebuild(Hand $hand): Hand
    {
        return new Hand(
            new Stack(...array_reverse($hand->wastePile->cards)),
            new Stack(),
        );
    }
}
