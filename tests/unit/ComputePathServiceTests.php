<?php

class ComputePathServiceTests extends TestClass
{
    public function testSortBoardingCards()
    {
        $datas = json_decode(file_get_contents(join(DIRECTORY_SEPARATOR, [dirname(__DIR__), '..', 'resource', 'boarding-data.json'])), true);
        $cardListForComp = array_map(function($element) {
            return BoardingCard::fromArray($element);
        }, $datas);

        $reversed = array_reverse($datas);

        $this->assertNotEqualsArray($datas, $reversed);

        $cardListReversed = array_map(function($element) {
            return BoardingCard::fromArray($element);
        }, $reversed);

        $sortedCardList = ComputePathService::sortBoardingCards($cardListReversed);

        $this->assertNotEqualsArray($cardListForComp, $cardListReversed);
        $this->assertEqualsArray($cardListForComp, $sortedCardList);
    }

    public function testSortBoardingCardsEmpty()
    {
        $text = ComputePathService::writePath([]);

        $this->assertEquals('', $text);
    }

    public function testSortBoardingCardsException()
    {
        $datas = json_decode(file_get_contents(join(DIRECTORY_SEPARATOR, [dirname(__DIR__), '..', 'resource', 'boarding-data.json'])), true);
        $cardList = array_map(function($element) {
            return BoardingCard::fromArray($element);
        }, $datas);

        unset($cardList[1]);

        try {
            ComputePathService::sortBoardingCards($cardList);

            throw new Exception('Unit test failed');
        } catch (Exception $e) {
            $this->assertEquals('One of the boarding cards cannot respect the sorting relationship.', $e->getMessage());
        }
    }

    public function testWritePath()
    {
        $datas = json_decode(file_get_contents(join(DIRECTORY_SEPARATOR, [dirname(__DIR__), '..', 'resource', 'boarding-data.json'])), true);
        $cardList = array_map(function($element) {
            return BoardingCard::fromArray($element);
        }, $datas);

        $text = ComputePathService::writePath($cardList);

        $this->assertEquals('* Take train 78A from Madrid to Barcelona. seat 45B.' . PHP_EOL
        .'* Take airport bus from Barcelona to Gerona Airport. No seat assignment.' . PHP_EOL
        .'* Take flight SK455 from Gerona Airport to Stockholm. Gate 45B seat 3A. Bagage drop at ticket counter 344.' . PHP_EOL
        .'* Take flight SK22 from Stockholm to New York JFC. Gate 22 seat 7B. Baggage will we automatically transferred from your last leg.' . PHP_EOL
        .'* You have arrived at your final destination.', $text);
    }

    public function testWritePathEmpty()
    {
        $text = ComputePathService::writePath([]);

        $this->assertEquals('', $text);
    }
}