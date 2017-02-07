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

namespace BrightNucleus\Values\Value;

/**
 * Class StringValue.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class StringValue extends AbstractValue
{

    /**
     * Instantiate a StringValue object.
     *
     * @since 0.1.0
     *
     * @param string $value String value.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
