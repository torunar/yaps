<?php

declare(strict_types=1);

namespace Tests\Yaps\Game\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\Factory\DeckFactory;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Deck\ValueObject\Stack;
use Torunar\Yaps\Game\Service\DeckService;

final class DeckServiceTest extends TestCase
{
    private DeckFactory&MockObject $deckFactoryMock;

    private DeckService $deckService;

    protected function setUp(): void
    {
        $this->deckFactoryMock = $this->createMock(DeckFactory::class);
        $deckShuffler = static function (Stack $stack): Stack {
            $cards = array_reverse($stack->cards);

            return new Stack(...$cards);
        };

        $this->deckService = new DeckService($this->deckFactoryMock, $deckShuffler);
    }

    public function testGetShuffledDeck(): void
    {
        $this->deckFactoryMock->expects($this->once())
            ->method('getDeck')
            ->willReturn(
                new Stack(
                    new Card(Suit::Spades, Rank::Ace),
                    new Card(Suit::Spades, Rank::Two),
                    new Card(Suit::Spades, Rank::Three),
                ),
            );

        $this->assertEquals(
            new Stack(
                new Card(Suit::Spades, Rank::Three),
                new Card(Suit::Spades, Rank::Two),
                new Card(Suit::Spades, Rank::Ace),
            ),
            $this->deckService->getShuffledDeck(),
        );
    }
}
