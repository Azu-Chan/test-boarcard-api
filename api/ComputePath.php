<?php

/**
 * API interne pour avoir la représentation textuelle ordonnée des cartes 
 * à partir d'une représentation json non ordonnée visible dans resource/boarding-template.json
 */
class ComputePath
{
    /**
     * @property string $data données encodées en json (voir resource/boarding-template.json)
     * pour la description
     * 
     * @return string liste formatée ou chaîne vide si données d'entrée vides
     * 
     * @throws \Exception en cas d'erreur pendant le process
     */
    public static function compute(string $data): string
    {
        $decoded = json_decode($data, true);

        if (! is_array($decoded)) {
            throw new \Exception('The input data is not an expected correct JSON format.');
        }
        
        if ($decoded === []) {
            return '';
        }

        $dataList = [];

        foreach ($decoded as $element) {
            if (! is_array($element)) {
                throw new \Exception('One of the sub-items of the input data is not expected correct JSON format.');
            }

            $card = BoardingCard::fromArray($element);
            $card->validate();
            $dataList[] = $card;
        }

        $dataList = ComputePathService::sortBoardingCards($dataList);

        return ComputePathService::writePath($dataList);
    }
}