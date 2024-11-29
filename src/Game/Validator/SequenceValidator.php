<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Validator;

use Torunar\Yaps\Deck\ValueObject\Stack;

readonly class SequenceValidator
{
    public function __construct(
        private StackActionValidator $stackActionValidator,
    ) {
    }

    public function isValidSequence(Stack $stack): bool
    {
        if ($stack->isEmpty()) {
            return false;
        }

        if ($stack->getCardCount() === 1) {
            return true;
        }

        for ($i = $stack->getCardCount() - 1; $i > 0; $i--) {
            if (!$this->stackActionValidator->canBeStackedOn(
                $stack->cards[$i],
                $stack->cards[$i - 1],
            )) {
                return false;
            }
        }

        return true;
    }
}
