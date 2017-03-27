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

namespace BrightNucleus\OptionsStore\ValidationError;

use BrightNucleus\OptionsStore\ValidationError;

/**
 * Class IntegerValidationError.
 *
 * @since   0.1.11
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class IntegerValidationError implements ValidationError
{

    use ValidationErrorTrait;

    /**
     * Get the default validation requirement message.
     *
     * @since 0.1.11
     *
     * @return string Default validation requirement message.
     */
    private function getDefaultMessage()
    {
        return sprintf(
            'You need to provide a valid integer number for option "%1$s".',
            $this->option->getKey()
        );
    }
}
