<?php

declare(strict_types=1);

namespace Tests\Yaps\Deck\Service;

use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Enum\Rank;
use Torunar\Yaps\Deck\Enum\Suit;
use Torunar\Yaps\Deck\Exception\GetCardFromStackException;
use Torunar\Yaps\Deck\Exception\GetSubstackException;
use Torunar\Yaps\Deck\Exception\StackCardIndexException;
use Torunar\Yaps\Deck\Exception\StackLengthException;
use Torunar\Yaps\Deck\Service\StackService;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Deck\ValueObject\Stack;

final class StackServiceTest extends TestCase
{
    private Stack $nonEmptyStack;

    private Stack $emptyStack;

    private StackService $stackService;

    protected function setUp(): void
    {
        $this->nonEmptyStack = new Stack(
            new Card(Suit::Clubs, Rank::Five),
            new Card(Suit::Diamonds, Rank::Four),
            new Card(Suit::Clubs, Rank::Three),
            new Card(Suit::Diamonds, Rank::Two),
            new Card(Suit::Clubs, Rank::Ace),
        );
        $this->emptyStack = new Stack();
        $this->stackService = new StackService();
    }

    public function testGetNthFromTailFailureWhenWrongIndex(): void
    {
        $this->expectException(StackCardIndexException::class);
        $this->stackService->getNthFromTail($this->nonEmptyStack, -1);
    }

    public function testGetNthFromTailFailureWhenEmptyStack(): void
    {
        $this->expectException(GetCardFromStackException::class);
        $this->stackService->getNthFromTail($this->emptyStack, 1);
    }

    public function testGetNthFromTailFailureWhenNoCard(): void
    {
        $this->expectException(GetCardFromStackException::class);
        $this->stackService->getNthFromTail($this->nonEmptyStack, 15);
    }

    public function testGetNthFromTailSuccess(): void
    {
        $this->assertEquals(
            new Card(Suit::Clubs, Rank::Ace),
            $this->stackService->getNthFromTail($this->nonEmptyStack, 0),
        );
    }

    public function testGetSubstackFailureWhenWrongLength(): void
    {
        $this->expectException(StackLengthException::class);
        $this->stackService->getSubstack($this->nonEmptyStack, -1);
    }

    public function testGetSubstackFailureWhenEmptyStack(): void
    {
        $this->expectException(GetSubstackException::class);
        $this->stackService->getSubstack($this->emptyStack, 1);
    }

    public function testGetSubstackFailureWhenNoSubstack(): void
    {
        $this->expectException(GetSubstackException::class);
        $this->stackService->getSubstack($this->nonEmptyStack, 15);
    }

    public function testGetSubstackSuccess(): void
    {
        $this->assertEquals(
            new Stack(
                new Card(Suit::Clubs, Rank::Three),
                new Card(Suit::Diamonds, Rank::Two),
                new Card(Suit::Clubs, Rank::Ace),
            ),
            $this->stackService->getSubstack($this->nonEmptyStack, 3),
        );
    }

    public function testGetTopCardWhenEmpty(): void
    {
        $this->expectException(GetCardFromStackException::class);
        $this->stackService->getTopCard($this->emptyStack);
    }

    public function testGetTopCardWhenNonEmpty(): void
    {
        $this->assertEquals(
            new Card(Suit::Clubs, Rank::Ace),
            $this->stackService->getTopCard($this->nonEmptyStack),
        );
    }
}
