<?php

namespace Podrecznikomat\IsbnApi\Tests;

use PHPUnit\Framework\TestCase;
use Podrecznikomat\IsbnApi\Helpers\IsbnValidator;

final class ValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testSuccessValidation(): void
    {
        $this->assertTrue(IsbnValidator::isValid('978-3-16-148410-0'));
        $this->assertTrue(IsbnValidator::isValid('3-16-148410-X'));
        $this->assertTrue(IsbnValidator::isValid('316148410X'));
        $this->assertTrue(IsbnValidator::isValid('9783161484100'));
    }

    /**
     * @return void
     */
    public function testFailedValidation(): void
    {
        $this->assertFalse(IsbnValidator::isValid('978-3-16-148410-1'));
        $this->assertFalse(IsbnValidator::isValid('3-16-148410-1'));
        $this->assertFalse(IsbnValidator::isValid('3161484101'));
        $this->assertFalse(IsbnValidator::isValid('9783161484101'));
        $this->assertFalse(IsbnValidator::isValid('invalid-isbn'));
        $this->assertFalse(IsbnValidator::isValid('123456789'));
        $this->assertFalse(IsbnValidator::isValid('123456789012'));
    }
}