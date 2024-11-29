<?php

declare(strict_types=1);

namespace Tests\Yaps\Game\Service;

use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Deck\ValueObject\Stack;
use Torunar\Yaps\Game\Factory\HandServiceFactory;
use Torunar\Yaps\Game\Service\HandService;
use Torunar\Yaps\Game\ValueObject\Hand;

final class HandServiceTest extends TestCase
{
    private HandService $handService;

    protected function setUp(): void
    {
        $this->handService = (new HandServiceFactory())->getService();
    }

    public function testRevealNextCardWhenHasStockAndEmptyWaste(): void
    {
        $talon = new Hand(
            new Stack(
                new Card(Suit::Clubs, Rank::Ace),
                new Card(Suit::Clubs, Rank::Two),
                new Card(Suit::Clubs, Rank::Three),
            ),
            new Stack(),
        );

        $this->assertEquals(
            new Hand(
                new Stack(
                    new Card(Suit::Clubs, Rank::Ace),
                    new Card(Suit::Clubs, Rank::Two),
                ),
                new Stack(
                    new Card(Suit::Clubs, Rank::Three),
                ),
            ),
            $this->handService->revealNextCard($talon),
        );
    }

    public function testRevealNextCardWhenHasStockAndNonEmptyWaste(): void
    {
        $talon = new Hand(
            new Stack(
                new Card(Suit::Clubs, Rank::Ace),
                new Card(Suit::Clubs, Rank::Two),
            ),
            new Stack(
                new Card(Suit::Clubs, Rank::Three),
            ),
        );

        $this->assertEquals(
            new Hand(
                new Stack(
                    new Card(Suit::Clubs, Rank::Ace),
                ),
                new Stack(
                    new Card(Suit::Clubs, Rank::Three),
                    new Card(Suit::Clubs, Rank::Two),
                ),
            ),
            $this->handService->revealNextCard($talon),
        );
    }

    public function testRevealNextCardWhenEmptyStockAndHasWaste(): void
    {
        $talon = new Hand(
            new Stack(),
            new Stack(
                new Card(Suit::Clubs, Rank::Three),
                new Card(Suit::Clubs, Rank::Two),
                new Card(Suit::Clubs, Rank::Ace),
            ),
        );

        $this->assertEquals(
            new Hand(
                new Stack(
                    new Card(Suit::Clubs, Rank::Ace),
                    new Card(Suit::Clubs, Rank::Two),
                    new Card(Suit::Clubs, Rank::Three),
                ),
                new Stack(),
            ),
            $this->handService->revealNextCard($talon),
        );
    }

    public function testRevealNextCardWhenEmptyStockAndEmptyWaste(): void
    {
        $talon = new Hand(
            new Stack(),
            new Stack(),
        );

        $this->assertEquals(
            new Hand(
                new Stack(),
                new Stack(),
            ),
            $this->handService->revealNextCard($talon),
        );
    }
}
