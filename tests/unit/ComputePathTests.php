<?php

class ComputePathTests extends TestClass
{
    public function testComputeEmpty()
    {
        $this->assertEquals('', ComputePath::compute('[]'));
    }

    public function testComputeBadDecodedFirstLayer()
    {
        try {
            ComputePath::compute('aaaaaa');

            throw new Exception('Unit test failed');
        } catch (Exception $e) {
            $this->assertEquals('The input data is not an expected correct JSON format.', $e->getMessage());
        }
    }

    public function testComputeBadDecodedSecondLayer()
    {
        try {
            ComputePath::compute('{"prop":"val"}');

            throw new Exception('Unit test failed');
        } catch (Exception $e) {
            $this->assertEquals('One of the sub-items of the input data is not expected correct JSON format.', $e->getMessage());
        }
    }

    public function testComputeBadArray()
    {
        try {
            ComputePath::compute('[{"prop":"val"},{"foo":"bar"}]');

            throw new Exception('Unit test failed');
        } catch (Exception $e) {
            $this->assertEquals('bad array', $e->getMessage());
        }
    }

    public function testComputeValidateError()
    {
        try {
            ComputePath::compute('[{"transport":"BAD","transport-number":"SK22",' .
                '"from":"Stockholm","to":"New York JFC","seat":"7B","gate":"22","bagage-management":"automatic"}]'
            );

            throw new Exception('Unit test failed');
        } catch (Exception $e) {
            $this->assertEquals("transport must be in ['train', 'airport bus', 'flight']", $e->getMessage());
        }
    }

    public function testCompute()
    {
        $datas = file_get_contents(dirname(__DIR__).'\..\resource\boarding-data.json');

        $this->assertEquals('* Take train 78A from Madrid to Barcelona. seat 45B.' . PHP_EOL
        .'* Take airport bus from Barcelona to Gerona Airport. No seat assignment.' . PHP_EOL
        .'* Take flight SK455 from Gerona Airport to Stockholm. Gate 45B seat 3A. Bagage drop at ticket counter 344.' . PHP_EOL
        .'* Take flight SK22 from Stockholm to New York JFC. Gate 22 seat 7B. Baggage will we automatically transferred from your last leg.' . PHP_EOL
        .'* You have arrived at your final destination.', ComputePath::compute($datas));
    }
}