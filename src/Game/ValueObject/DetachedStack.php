<?php declare(strict_types=1);

namespace Torunar\Yaps\Game\ValueObject;

use Torunar\Yaps\Deck\ValueObject\Stack;

final readonly class DetachedStack
{
    public function __construct(
        public int $tableuColumnIndex,
        public Stack $stack,
    ) { }
}
