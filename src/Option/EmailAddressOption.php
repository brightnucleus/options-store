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

namespace BrightNucleus\OptionsStore\Option;

use BrightNucleus\OptionsStore\Option;
use BrightNucleus\OptionsStore\ValidationError;
use BrightNucleus\OptionsStore\ValidationError\EmailAddressValidationError;
use BrightNucleus\Values\Value\EmailAddressValue;

/**
 * Class EmailAddressOption.
 *
 * Option interface wrapped around an EmailAddressValue object.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class EmailAddressOption extends EmailAddressValue implements Option
{

    use OptionTrait;

    /**
     * Instantiate a EmailAddressOption object.
     *
     * @since 0.1.0
     *
     * @param string $key   Key of the option.
     * @param string $value Default value of the option.
     * @param int    $flags Optional. Bitwise flags to define behaviour.
     */
    public function __construct(string $key, string $value, int $flags = 0)
    {
        $this->key = $key;
        parent::__construct($value, $flags);
    }

    /**
     * Return the validated form of the value.
     *
     * Returns null if the value could not be validated.
     *
     * @since 0.1.11
     *
     * @param mixed $value Value to validate.
     *
     * @return mixed|ValidationError Validated value. ValidationError instance if validation failed.
     */
    public function validate($value)
    {
        $result = parent::validate($value);
        return null === $result
            ? new EmailAddressValidationError($this)
            : $result;
    }
}
