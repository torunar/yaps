<?php

declare(strict_types=1);

namespace Tests\Yaps\Deck\Factory;

use PHPUnit\Framework\TestCase;
use Torunar\Yaps\Deck\Factory\DeckFactory;

final class DeckFactoryTest extends TestCase
{
    private DeckFactory $deckFactory;

    protected function setUp(): void
    {
        $this->deckFactory = new DeckFactory();
    }

    public function testGetDeck(): void
    {
        $deck = $this->deckFactory->getDeck();
        $countBySuit = [];
        $countByRank = [];
        $countByColor = [];
        foreach ($deck->cards as $card) {
            $countByRank[$card->rank->name] = ($countByRank[$card->rank->name] ?? 0) + 1;
            $countBySuit[$card->suit->name] = ($countBySuit[$card->suit->name] ?? 0) + 1;
            $countByColor[$card->suit->getColor()->name] = ($countByColor[$card->suit->getColor()->name] ?? 0) + 1;
        }

        $this->assertEquals(52, $deck->getCardCount());

        $this->assertCount(4, $countBySuit);
        foreach ($countBySuit as $suitCount) {
            $this->assertEquals(13, $suitCount);
        }

        $this->assertCount(13, $countByRank);
        foreach ($countByRank as $rankCount) {
            $this->assertEquals(4, $rankCount);
        }

        $this->assertCount(2, $countByColor);
        foreach ($countByColor as $colorCount) {
            $this->assertEquals(26, $colorCount);
        }
    }
}
