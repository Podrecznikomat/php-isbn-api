<?php

namespace Podrecznikomat\IsbnApi\Tests;

use PHPUnit\Framework\TestCase;
use Podrecznikomat\IsbnApi\Helpers\IsbnNormalizer;

final class NormalizerTest extends TestCase
{
    /**
     * @return void
     */
    public function testNormalization(): void
    {
        $this->assertEquals('9783161484100', IsbnNormalizer::normalize('978-3-16-148410-0'));
        $this->assertEquals('316148410X', IsbnNormalizer::normalize('3-16-148410-X'));
        $this->assertEquals('316148410X', IsbnNormalizer::normalize('316148410X'));
        $this->assertEquals('9783161484100', IsbnNormalizer::normalize('9783161484100'));
    }
}