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
 * Interface Value.
 *
 * Abstract representation of a single value.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface Value extends Validatable, Sanitizable, Escapable
{

    /**
     * Get the raw value.
     *
     * @since 0.1.0
     *
     * @return mixed Current raw value.
     */
    public function getValue();

    /**
     * Set the raw value.
     *
     * @since 0.1.0
     *
     * @param mixed $value New raw value.
     *
     * @return Value Modified Value object. Can differ from the original one.
     */
    public function setValue($value);

    /**
     * "Execute" the value which is a shortcut for retrieving its raw value.
     *
     * If a context is passed, it is sanitized and/or escaped depending on this context.
     *
     * This is an alternative way for accessing values to allow for more elegant syntax.
     *
     * @since 0.1.0
     *
     * @return mixed
     */
    public function __invoke();

    /**
     * Return a string representation of the value.
     *
     * If a context is passed, it is sanitized and/or escaped depending on this context.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function __toString(): string;
}
