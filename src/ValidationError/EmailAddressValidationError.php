<?php
/**
 * Bright Nucleus Values.
 *
 * Manipulate sanitizable and validatable values.
 *
 * @package   BrightNucleus\Values
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.brightnucleus.com/
 * @copyright 2017 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Values\ValidationError;

/**
 * Class EmailAddressValidationError.
 *
 * @since   0.1.1
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class EmailAddressValidationError {

    use ValidationErrorTrait;

    /**
     * Get the default validation requirement message.
     *
     * @since 0.1.1
     *
     * @return string Default validation requirement message.
     */
    private function getDefaultMessage()
    {
        return sprintf(
            'You need to provide a valid email address for option "%1$s".',
            $this->key
        );
    }
}
