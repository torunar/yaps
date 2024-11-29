# YAPS: Yet Another PHP Solitaire

[![Build](https://github.com/torunar/yaps/actions/workflows/build.yml/badge.svg)](https://github.com/torunar/yaps/actions/workflows/build.yml)

## Running tests

```bash
composer test
```

## Checking code style

```bash
composer lint
```

## Terminology

Taken from [Important Solitaire Terms by Neal Taparia](https://solitaired.com/solitaire-terms).

* Suit - A set of thirteen cards identified by the same symbol: Clubs (♣), Spades (♠), Diamonds (♦), or Hearts (♥).
* Rank - Sequence or position of the cards within their respective suits.
* Foundations - A family is one term used to describe a “completed” foundation based upon the specific rules of the game mode. Most modes define a family as containing one of all 13 card values, starting with the low card Ace and ending with the King.
* Hand - The cards remaining after initially dealing out the columns, held face down and turned over one at a time to be put on either one of the seven columns, an Ace pile, or the waste pile.
* Stockpile - See Hand.
* Waste pile - The pile of cards which are drawn from the hand, but aren’t placed on either a column or Ace pile. They’re placed face-up; once a face-up card is covered, it can’t be played until any cards covering it are moved and put into play. When the hand is gone, the waste pile is turned over, and begins life again as a hand.
* Tableau - The seven columns of cards dealt at the start of the Solitaire game.

> [!NOTE]
> Even though Hand and Stockpile are the same thing, in the source code of this project the Hand is a container that combines Stockpile and Waste pile together.
