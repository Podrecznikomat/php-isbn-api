<?php

namespace Podrecznikomat\IsbnApi\Tests;

use PHPUnit\Framework\TestCase;
use Podrecznikomat\IsbnApi\Exceptions\InvalidIsbnException;
use Podrecznikomat\IsbnApi\Helpers\IsbnFormatter;

final class FormatterTest extends TestCase
{
    /**
     * @return void
     * @throws InvalidIsbnException
     */
    public function testFormatting(): void
    {
        $this->assertEquals('978-3-1614-8410-0', IsbnFormatter::format('9783161484100'));
        $this->assertEquals('3-161-48410-X', IsbnFormatter::format('316148410X'));
    }

    /**
     * @return void
     * @throws InvalidIsbnException
     */
    public function testFailFormatting(): void
    {
        $this->expectException(InvalidIsbnException::class);
        IsbnFormatter::format('invalid-isbn');
        IsbnFormatter::format('123456789');
        IsbnFormatter::format('123456789012');
    }
}