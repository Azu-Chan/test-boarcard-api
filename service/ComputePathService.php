<?php

class ComputePathService
{
    /**
     * Permet d'ordonner des cartes d'embarquement sous forme de chemin en les triant par une
     * relation current->destination => next->départ
     * algo en O(n²)
     * 
     * @property BoardingCard[] $boardingCards
     * 
     * @throws \Exception Si une carte ne peut pas respecter la relation
     */
    public static function sortBoardingCards(array $boardingCards): array
    {
        if (count($boardingCards) === 0) return [];

        $orderedCards = [];
        $orderedCards[] = array_pop($boardingCards);

        do {
            $pushed = 0;
            foreach ($boardingCards as $key => $card) {
                $first = reset($orderedCards);
                $last = end($orderedCards);
                if ($first->getFromLocation() === $card->getDestination()) {
                    array_unshift($orderedCards, $card);
                    unset($boardingCards[$key]);
                    $pushed++;
                } elseif ($last->getDestination() === $card->getFromLocation()) {
                    $orderedCards[] = $card;
                    unset($boardingCards[$key]);
                    $pushed++;
                }
            }

            if ($pushed === 0) {
                throw new \Exception('One of the boarding cards cannot respect the sorting relationship.');
            }
        } while (count($boardingCards) > 0);

        return $orderedCards;
    }

    /**
     * Renvoie la représentation textuelle de chaque BoardingCard du tableau
     * passé en paramètre puis concatène au renvoi une phrase d'arrivée.
     * Si le tableau vide, une chaîne vide est renvoyée.
     * 
     * @property BoardingCard[] $boardingCards
     */
    public static function writePath(array $boardingCards): string
    {
        if (count($boardingCards) === 0) {
            return '';
        }

        $path = '';
        foreach ($boardingCards as $card) {
            $path .= $card->stringify() . PHP_EOL;
        }
        $path .= '* You have arrived at your final destination.';

        return $path;
    }
}