<?php

declare(strict_types=1);

namespace Tests\Yaps\Game\Validator;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Game\Validator\DiscardActionValidator;

final class DiscardActionValidatorTest extends TestCase
{
    private DiscardActionValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new DiscardActionValidator();
    }

    #[DataProvider('getUndiscardableCards')]
    public function testCanBeDiscardedOnWhenUndiscardable(Card $topCard, ?Card $bottomCard): void
    {
        $this->assertFalse(
            $this->validator->canBeDiscardedOn($topCard, $bottomCard),
        );
    }

    #[DataProvider('getDiscardableCards')]
    public function testCanBeDiscardedOnWhenDiscardable(Card $topCard, ?Card $bottomCard): void
    {
        $this->assertTrue(
            $this->validator->canBeDiscardedOn($topCard, $bottomCard),
        );
    }

    public static function getUndiscardableCards(): Generator
    {
        yield 'non-ace on empty spot' => [new Card(Suit::Clubs, Rank::Two), null];
        yield 'different suits' => [new Card(Suit::Clubs, Rank::Two), new Card(Suit::Spades, Rank::Ace)];
        yield 'top has lower rank' => [new Card(Suit::Clubs, Rank::Ace), new Card(Suit::Clubs, Rank::Two)];
        yield 'non-consecutive rank' => [new Card(Suit::Clubs, Rank::Four), new Card(Suit::Clubs, Rank::Two)];
    }

    public static function getDiscardableCards(): Generator
    {
        yield [new Card(Suit::Clubs, Rank::Ace), null];
        yield [new Card(Suit::Clubs, Rank::Two), new Card(Suit::Clubs, Rank::Ace)];
        yield [new Card(Suit::Clubs, Rank::Three), new Card(Suit::Clubs, Rank::Two)];
        yield [new Card(Suit::Clubs, Rank::Four), new Card(Suit::Clubs, Rank::Three)];
        yield [new Card(Suit::Clubs, Rank::Five), new Card(Suit::Clubs, Rank::Four)];
        yield [new Card(Suit::Clubs, Rank::Six), new Card(Suit::Clubs, Rank::Five)];
        yield [new Card(Suit::Clubs, Rank::Seven), new Card(Suit::Clubs, Rank::Six)];
        yield [new Card(Suit::Clubs, Rank::Eight), new Card(Suit::Clubs, Rank::Seven)];
        yield [new Card(Suit::Clubs, Rank::Nine), new Card(Suit::Clubs, Rank::Eight)];
        yield [new Card(Suit::Clubs, Rank::Ten), new Card(Suit::Clubs, Rank::Nine)];
        yield [new Card(Suit::Clubs, Rank::Jack), new Card(Suit::Clubs, Rank::Ten)];
        yield [new Card(Suit::Clubs, Rank::Queen), new Card(Suit::Clubs, Rank::Jack)];
        yield [new Card(Suit::Clubs, Rank::King), new Card(Suit::Clubs, Rank::Queen)];
    }
}
