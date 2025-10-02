<?php

declare(strict_types=1);

namespace Torunar\Yaps\Deck\Service;

use Torunar\Yaps\Deck\Exception\GetCardFromStackException;
use Torunar\Yaps\Deck\Exception\GetSubstackException;
use Torunar\Yaps\Deck\Exception\StackCardIndexException;
use Torunar\Yaps\Deck\Exception\StackLengthException;
use Torunar\Yaps\Deck\ValueObject\Card;
use Torunar\Yaps\Deck\ValueObject\Stack;

readonly class StackService
{
    /**
     * @throws GetCardFromStackException
     * @throws StackCardIndexException
     */
    public function getNthFromTail(Stack $stack, int $n): Card
    {
        if ($n < 0) {
            throw new StackCardIndexException();
        }

        $cards = array_reverse($stack->cards);
        if (!isset($cards[$n])) {
            throw new GetCardFromStackException();
        }

        return $cards[$n];
    }

    /**
     * @throws GetCardFromStackException
     * @throws StackCardIndexException
     */
    public function getTopCard(Stack $stack): Card
    {
        return $this->getNthFromTail($stack, 0);
    }

    /**
     * @throws GetSubstackException
     * @throws StackLengthException
     */
    public function getSubstack(Stack $stack, int $length): Stack
    {
        if ($length < 0) {
            throw new StackLengthException();
        }

        if ($length === 0) {
            return new Stack();
        }

        if ($stack->getCardCount() < $length) {
            throw new GetSubstackException();
        }

        return new Stack(...array_slice($stack->cards, $stack->getCardCount() - $length, $length));
    }

    /**
     * @throws GetSubstackException
     */
    public function getSubstackWithoutTopCard(Stack $stack): Stack
    {
        if ($stack->getCardCount() < 1) {
            throw new GetSubstackException();
        }

        return new Stack(...array_slice($stack->cards, 0, $stack->getCardCount() - 1));
    }

    public function addCard(Stack $stack, Card $card): Stack
    {
        return new Stack(...[...$stack->cards, $card]);
    }
}
