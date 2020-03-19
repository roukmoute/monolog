<?php

declare(strict_types=1);

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog;

use PHPUnit\Framework\TestCase;

/**
 * @author Mathias STRASSER <contact@roukmoute.fr>
 */
class LevelTest extends TestCase
{
    public function testConstructor()
    {
        $mock = new MockLevel('level1', 1);
        $this->assertEquals('level1', $mock->name());
        $this->assertEquals(1, $mock->value());
    }

    public function testConstructorWithEmptyName()
    {
        $mock = new MockLevel('', 1);
        $this->assertEquals('', $mock->name());
        $this->assertEquals(1, $mock->value());
    }

    public function testParseInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);

        Level::parse('dEBUG');
    }

    public function testParsePredefinedConstStrings(): void
    {
        $this->assertEquals(Level::debug(), Level::parse('DEBUG'));
        $this->assertEquals(Level::info(), Level::parse('INFO'));
        $this->assertEquals(Level::notice(), Level::parse('NOTICE'));
        $this->assertEquals(Level::warning(), Level::parse('WARNING'));
        $this->assertEquals(Level::error(), Level::parse('ERROR'));
        $this->assertEquals(Level::critical(), Level::parse('CRITICAL'));
        $this->assertEquals(Level::alert(), Level::parse('ALERT'));
        $this->assertEquals(Level::emergency(), Level::parse('EMERGENCY'));
    }

    public function testParsePredefinedNumber()
    {
        $this->assertEquals(Level::debug(), Level::parse(Level::DEBUG));
        $this->assertEquals(Level::info(), Level::parse((string) Level::INFO));
        $this->assertEquals(Level::notice(), Level::parse(Level::NOTICE));
        $this->assertEquals(Level::warning(), Level::parse((string) Level::WARNING));
        $this->assertEquals(Level::error(), Level::parse(Level::ERROR));
        $this->assertEquals(Level::critical(), Level::parse((string) Level::CRITICAL));
        $this->assertEquals(Level::alert(), Level::parse(Level::ALERT));
        $this->assertEquals(Level::emergency(), Level::parse((string) Level::EMERGENCY));
    }

    public function testParseUndefinedNumber()
    {
        $mock = Level::parse('0');
        $this->assertEquals('0', $mock->name());
        $this->assertEquals(0, $mock->value());
    }

    public function testParseNegativeNumber()
    {
        $mock = Level::parse('-4');
        $this->assertEquals('-4', $mock->name());
        $this->assertEquals(-4, $mock->value());
    }
}

/**
 * This Mock is used to expose the protected constructor.
 */
class MockLevel extends Level
{
    public function __construct(string $name, int $value)
    {
        parent::__construct($name, $value);
    }
}
