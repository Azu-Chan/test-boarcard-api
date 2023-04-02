<?php

abstract class TestClass
{
    protected function assertEquals(mixed $expected, mixed $value)
    {
        if ($expected === $value) {
            return;
        }

        throw new \Exception('expected: ' . print_r($expected, true) . ' - got: ' . print_r($value, true));
    }

    protected function assertNotEquals(mixed $expected, mixed $value)
    {
        if ($expected !== $value) {
            return;
        }

        throw new \Exception('not expected: ' . print_r($expected, true) . ' - got: ' . print_r($value, true));
    }

    protected function assertEqualsArray(array $expected, array $value)
    {
        if (count($expected) === count($value)) {
            while(count($expected) > 0) {
                $itemE = array_pop($expected);
                $itemV = array_pop($value);
                if ($itemE != $itemV) {
                    break;
                }
            }
            return;
        }

        throw new \Exception('expected: ' . print_r($expected, true) . ' - got: ' . print_r($value, true));
    }

    protected function assertNotEqualsArray(array $expected, array $value)
    {
        if (count($expected) !== count($value)) {
            return;
        }

        while(count($expected) > 0) {
            $itemE = array_pop($expected);
            $itemV = array_pop($value);
            if ($itemE != $itemV) {
                return;
            }
        }

        throw new \Exception('not expected: ' . print_r($expected, true) . ' - got: ' . print_r($value, true));
    }
}