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
 * Class IntegerValue.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class IntegerValue extends AbstractValue
{

    /**
     * Instantiate a IntegerValue object.
     *
     * @since 0.1.0
     *
     * @param int $value Integer value.
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
