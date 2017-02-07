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

use BrightNucleus\Exception\OutOfRangeException;

/**
 * Class UnknownOptionKey.
 *
 * Thrown when an unknown key was requested from an OptionRepository.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class UnknownOptionKey extends OutOfRangeException implements OptionsStoreException
{

    /**
     * Get a new exception based on the key that was requested.
     *
     * @since 0.1.0
     *
     * @param string $key Key that was requested.
     *
     * @return static
     */
    public static function fromKey($key)
    {
        $message = sprintf(
            'Could not find unknown option "%1$s".',
            $key
        );

        return new static($message);
    }
}
