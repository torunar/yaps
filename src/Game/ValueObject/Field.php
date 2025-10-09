<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\ValueObject;

use Torunar\Yaps\Deck\ValueObject\Stack;

readonly class Field
{
    public function __construct(
        public Hand $hand,
        public Stack $heartsFoundation,
        public Stack $clubsFoundation,
        public Stack $diamondsFoundation,
        public Stack $spadesFoundation,
        /** @var Stack[] */
        public array $tableu,
        public DetachedStack $detachedStack,
    ) {
    }
}
