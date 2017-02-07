<?php
/**
 * Bright Nucleus Options Store.
 *
 * Abstract options store that allows for exchangeable persistence mechanisms.
 *
 * @package   BrightNucleus\OptionsStore
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.brightnucleus.com/
 * @copyright 2017 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\OptionsStore\OptionRepository;

use BrightNucleus\OptionsStore\Exception\UnknownOptionKey;
use BrightNucleus\OptionsStore\Option;

/**
 * Class VolatileOptionRepository.
 *
 * Volatile implementation for the OptionRepository, getting the options through the constructor and storing them in
 * memory.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\OptionRepository
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class VolatileOptionRepository extends AbstractOptionRepository
{

    /**
     * Associative array that represent the options storage.
     *
     * @since 0.1.0
     *
     * @var array
     */
    private static $storage = [];

    /**
     * Read a single option from the persistence mechanism.
     *
     * @since 0.1.0
     *
     * @param string $key      Key of the option to read.
     * @param mixed  $fallback Optional. Fallback value to use if the option was not found.
     *
     * @return mixed Value that was read.
     * @throws UnknownOptionKey If the value could not be retrieved.
     */
    protected function readOption(string $key, $fallback = null)
    {
        return static::$storage[$key] ?? $fallback;
    }

    /**
     * Write a single option to the persistence mechanism.
     *
     * @since 0.1.0
     *
     * @param string $key   Key of the option to write.
     * @param mixed  $value Value to write.
     *
     * @return bool Whether the write operation was successful.
     */
    protected function writeOption(string $key, $value): bool
    {
        static::$storage[$key] = $value;

        return true;
    }
}
