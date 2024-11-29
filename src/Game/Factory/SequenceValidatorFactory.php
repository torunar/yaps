<?php

declare(strict_types=1);

namespace Torunar\Yaps\Game\Factory;

use Torunar\Yaps\Game\Validator\SequenceValidator;
use Torunar\Yaps\Game\Validator\StackActionValidator;

readonly class SequenceValidatorFactory
{
    private StackActionValidator $stackActionValidator;

    public function __construct(StackActionValidator $stackActionValidator = null)
    {
        $this->stackActionValidator = $stackActionValidator ?? new StackActionValidator();
    }

    public function getValidator(): SequenceValidator
    {
        return new SequenceValidator(
            $this->stackActionValidator,
        );
    }
}
