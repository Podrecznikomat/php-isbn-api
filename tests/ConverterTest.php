<?php

namespace Podrecznikomat\IsbnApi\Tests;

use PHPUnit\Framework\TestCase;
use Podrecznikomat\IsbnApi\Exceptions\InvalidIsbnException;
use Podrecznikomat\IsbnApi\Helpers\IsbnConverter;

final class ConverterTest extends TestCase
{
    /**
     * @return void
     * @throws InvalidIsbnException
     */
    public function testSuccessConversion(): void
    {
        $this->assertEquals('9783161484100', IsbnConverter::isbn10to13('316148410X'));
        $this->assertEquals('316148410X', IsbnConverter::isbn13to10('9783161484100'));
    }

    /**
     * @return void
     * @throws InvalidIsbnException
     */
    public function testFailedConversion(): void
    {
        $this->expectException(InvalidIsbnException::class);
        $this->assertNull(IsbnConverter::isbn10to13('invalid-isbn'));
        $this->assertNull(IsbnConverter::isbn13to10('invalid-isbn'));
        $this->assertNull(IsbnConverter::isbn10to13('123456789'));
        $this->assertNull(IsbnConverter::isbn13to10('123456789012'));
    }
}