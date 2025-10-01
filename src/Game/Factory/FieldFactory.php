<?php

/**
 * This file is part of Boozt Platform
 * and belongs to Boozt Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Torunar\Yaps\Game\Factory;

use Torunar\Yaps\Deck\Service\StackService;
use Torunar\Yaps\Game\Service\FieldService;

readonly class FieldFactory
{
    private DeckServiceFactory $deckServiceFactory;
    private StackService $stackService;

    public function __construct(
        ?DeckServiceFactory $deckServiceFactory = null,
        ?StackService $stackService = null,
    ) {
        $this->deckServiceFactory = $deckServiceFactory ?? new DeckServiceFactory();
        $this->stackService = $stackService ?? new StackService();
    }

    public function getService(): FieldService
    {
        return new FieldService(
            $this->deckServiceFactory->getService(),
            $this->stackService,
        );
    }
}
