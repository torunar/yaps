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

use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\Exception\GetCardFromStackException;
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
        $heartsFoundation = new Stack();
        $clubsFoundation = new Stack();
        $diamondsFoundation = new Stack();
        $spadesFoundation = new Stack();

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
            while ($openCard?->rank === Rank::Ace) {
                match ($openCard->suit) {
                    Suit::Hearts => $heartsFoundation = $this->stackService->addCard($heartsFoundation, $openCard),
                    Suit::Clubs => $clubsFoundation = $this->stackService->addCard($clubsFoundation, $openCard),
                    Suit::Diamonds => $diamondsFoundation = $this->stackService->addCard($diamondsFoundation, $openCard),
                    Suit::Spades => $spadesFoundation = $this->stackService->addCard($spadesFoundation, $openCard),
                };
                try {
                    $openCard = $this->stackService->getTopCard($tableu[$columnIndex])->getOpen();
                    $tableu[$columnIndex] = $this->stackService->getSubstackWithoutTopCard($tableu[$columnIndex]);
                } catch (GetCardFromStackException) {
                    $openCard = null;
                }
            }
            if ($openCard) {
                $tableu[$columnIndex] = $this->stackService->addCard(
                    $tableu[$columnIndex],
                    $openCard,
                );
            }
        }

        $hand = new Hand(
            stockPile: $deck,
            wastePile: new Stack(),
        );

        return new Field(
            hand: $hand,
            heartsFoundation: $heartsFoundation,
            clubsFoundation: $clubsFoundation,
            diamondsFoundation: $diamondsFoundation,
            spadesFoundation: $spadesFoundation,
            tableu: $tableu,
        );
    }
}
