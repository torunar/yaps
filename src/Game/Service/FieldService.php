<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Torunar\Yaps\Game\Service;

use Torunar\Yaps\Deck\Service\StackService;
use Torunar\Yaps\Deck\ValueObject\Stack;
use Torunar\Yaps\Game\ValueObject\Field;
use Torunar\Yaps\Game\ValueObject\Hand;

readonly class FieldService
{
    private const int TABLEU_COLUMN_COUNT = 7;

    public function __construct(
        private DeckService $deckService,
        private StackService $stackService,
    ) {
    }

    public function initField(): Field
    {
        $deck = $this->deckService->getShuffledDeck();

        for ($columnIndex = 0; $columnIndex < self::TABLEU_COLUMN_COUNT; $columnIndex++) {
            $tableu[$columnIndex] = new Stack();
            for ($closedCardCount = 0; $closedCardCount < $columnIndex; $closedCardCount++) {
                $closedCard = $this->stackService->getTopCard($deck)->getClosed();
                $deck = $this->stackService->getSubstackWithoutTopCard($deck);
                $tableu[$columnIndex] = $this->stackService->addCard(
                    $tableu[$columnIndex],
                    $closedCard,
                );
            }

            $openCard = $this->stackService->getTopCard($deck)->getOpen();
            $deck = $this->stackService->getSubstackWithoutTopCard($deck);
            $tableu[$columnIndex] = $this->stackService->addCard(
                $tableu[$columnIndex],
                $openCard,
            );
        }

        $hand = new Hand(
            stockPile: $deck,
            wastePile: new Stack(),
        );

        return new Field(
            hand: $hand,
            heartsFoundation: new Stack(),
            clubsFoundation: new Stack(),
            diamondsFoundation: new Stack(),
            spadesFoundation: new Stack(),
            tableu: $tableu,
        );
    }
}
