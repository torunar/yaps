<?php

declare(strict_types=1);

namespace Tests\Yaps\Game\Validator;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Game\Validator\StackActionValidator;

final class StackActionValidatorTest extends TestCase
{
    private StackActionValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new StackActionValidator();
    }

    #[DataProvider('getUnstackableCards')]
    public function testCanBeStackedOnWhenUnstackable(Card $topCard, Card $bottomCard): void
    {
        $this->assertFalse(
            $this->validator->canBeStackedOn($topCard, $bottomCard),
        );
    }

    #[DataProvider('getStackableCards')]
    public function testCanBeStackedOnWhenStackable(Card $topCard, ?Card $bottomCard): void
    {
        $this->assertTrue(
            $this->validator->canBeStackedOn($topCard, $bottomCard),
        );
    }

    public static function getUnstackableCards(): Generator
    {
        yield 'same suit' => [new Card(Suit::Clubs, Rank::Ace), new Card(Suit::Clubs, Rank::Ace)];
        yield 'same color suit' => [new Card(Suit::Clubs, Rank::Ace), new Card(Suit::Spades, Rank::Ace)];
        yield 'same rank' => [new Card(Suit::Clubs, Rank::Ace), new Card(Suit::Diamonds, Rank::Ace)];
        yield 'top has higher rank' => [new Card(Suit::Clubs, Rank::Two), new Card(Suit::Diamonds, Rank::Ace)];
        yield 'non-consecutive rank' => [new Card(Suit::Clubs, Rank::Two), new Card(Suit::Diamonds, Rank::Four)];
    }

    public static function getStackableCards(): Generator
    {
        yield [new Card(Suit::Clubs, Rank::Ace), null];
        yield [new Card(Suit::Clubs, Rank::Ace), new Card(Suit::Diamonds, Rank::Two)];
        yield [new Card(Suit::Clubs, Rank::Ace), new Card(Suit::Hearts, Rank::Two)];
        yield [new Card(Suit::Spades, Rank::Ace), new Card(Suit::Diamonds, Rank::Two)];
        yield [new Card(Suit::Spades, Rank::Ace), new Card(Suit::Hearts, Rank::Two)];
        yield [new Card(Suit::Diamonds, Rank::Ace), new Card(Suit::Clubs, Rank::Two)];
        yield [new Card(Suit::Diamonds, Rank::Ace), new Card(Suit::Spades, Rank::Two)];
        yield [new Card(Suit::Hearts, Rank::Ace), new Card(Suit::Clubs, Rank::Two)];
        yield [new Card(Suit::Hearts, Rank::Ace), new Card(Suit::Spades, Rank::Two)];
    }
}
