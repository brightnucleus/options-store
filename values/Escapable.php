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

namespace BrightNucleus\Values;

/**
 * Interface Escapable.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface Escapable
{

    /**
     * Get a sanitized version of the value.
     *
     * @since 0.1.0
     *
     * @param string $target Optional. Escaping target to use. Defaults to HTML.
     *
     * @return mixed Sanitized version of the value.
     */
    public function escape(string $target = EscapeTarget::HTML);
}
