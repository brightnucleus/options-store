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

namespace BrightNucleus\OptionsStore\Exception;

use BrightNucleus\Exception\InvalidArgumentException;

/**
 * Class InvalidOption.
 *
 * Thrown when an invalid Option implementation is tried to be added to an option repository.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class InvalidOption extends InvalidArgumentException implements OptionsStoreException
{

    /**
     * Get a new exception based on the type of an invalid option.
     *
     * @since 0.1.0
     *
     * @param mixed $option Option that was tried to be added.
     *
     * @return static
     */
    public static function fromOption($option)
    {
        $message = sprintf(
            'Could not add invalid Option of type "%1$s" to option repository.',
            is_object($option)
                ? get_class($option)
                : gettype($option)
        );

        return new static($message);
    }
}
