<?php

declare(strict_types=1);

namespace Tests\Yaps\Game\Validator;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Deck\ValueObject\Stack;
use Torunar\Yaps\Game\Factory\SequenceValidatorFactory;
use Torunar\Yaps\Game\Validator\SequenceValidator;

class SequenceValidatorTest extends TestCase
{
    private SequenceValidator $sequenceValidator;

    protected function setUp(): void
    {
        $this->sequenceValidator = (new SequenceValidatorFactory())->getValidator();
    }

    #[DataProvider('getInvalidSequences')]
    public function testIsValidSequenceWhenInvalid(Stack $stack): void
    {
        $this->assertFalse(
            $this->sequenceValidator->isValidSequence($stack),
        );
    }

    #[DataProvider('getValidSequences')]
    public function testIsValidSequenceWhenValid(Stack $stack): void
    {
        $this->assertTrue(
            $this->sequenceValidator->isValidSequence($stack),
        );
    }

    public static function getInvalidSequences(): Generator
    {
        yield 'empty stack' => [new Stack()];

        yield 'wrong order of suits' => [
            new Stack(
                new Card(Suit::Clubs, Rank::Two),
                new Card(Suit::Spades, Rank::Ace),
            ),
        ];

        yield 'wrong order of ranks' => [
            new Stack(
                new Card(Suit::Clubs, Rank::Two),
                new Card(Suit::Hearts, Rank::Jack),
            ),
        ];
    }

    public static function getValidSequences(): Generator
    {
        yield 'one-card stack' => [
            new Stack(
                new Card(Suit::Clubs, Rank::Two),
            ),
        ];

        yield 'multi-card stack' => [
            new Stack(
                new Card(Suit::Spades, Rank::Four),
                new Card(Suit::Diamonds, Rank::Three),
                new Card(Suit::Clubs, Rank::Two),
                new Card(Suit::Hearts, Rank::Ace),
            ),
        ];
    }
}
