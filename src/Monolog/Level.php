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

use ReflectionClass;

/**
 * The Level class defines a set of standard logging levels that can be used to
 * control logging output.
 * The logging Level objects are ordered and are specified by ordered integers.
 * Enabling logging at a given level also enables logging at all higher levels.
 *
 * Clients should normally use the predefined Level such as Level::error().
 *
 * The levels in descending order are:
 *
 * EMERGENCY (highest value)
 * ALERT
 * ERROR
 * CRITICAL
 * WARNING
 * NOTICE
 * INFO
 * DEBUG (lowest value)
 *
 * @author Mathias STRASSER <contact@roukmoute.fr>
 */
class Level
{
    /**
     * Detailed debug information
     */
    public const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    public const INFO = 200;

    /**
     * Uncommon events
     */
    public const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    public const WARNING = 300;

    /**
     * Runtime errors
     */
    public const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    public const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    public const ALERT = 550;

    /**
     * Urgent alert.
     */
    public const EMERGENCY = 600;

    /** @var string */
    private $name;

    /** @var int */
    private $value;

    protected function __construct(string $name, int $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public static function debug(): self
    {
        return new self('DEBUG', self::DEBUG);
    }

    public static function info(): self
    {
        return new self('INFO', self::INFO);
    }

    public static function notice(): self
    {
        return new self('NOTICE', self::NOTICE);
    }

    public static function warning(): self
    {
        return new self('WARNING', self::WARNING);
    }

    public static function error(): self
    {
        return new self('ERROR', self::ERROR);
    }

    public static function critical(): self
    {
        return new self('CRITICAL', self::CRITICAL);
    }

    public static function alert(): self
    {
        return new self('ALERT', self::ALERT);
    }

    public static function emergency(): self
    {
        return new self('EMERGENCY', self::EMERGENCY);
    }

    /**
     * Parse a level name/value string into a Level.
     */
    public static function parse($name): self
    {
        $constants = (new ReflectionClass(__CLASS__))->getConstants();

        if (in_array($name, $constants)) {
            return new self((string) array_search($name, $constants), (int) $name);
        }

        if (in_array($name, array_keys($constants))) {
            return new self((string) $name, (int) $constants[$name]);
        }

        if (is_numeric($name)) {
            return new self((string) $name, (int) $name);
        }

        throw new \InvalidArgumentException(sprintf('Bad level "%s"', $name));
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
