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
use BrightNucleus\Values\Value\StringValue;

/**
 * Class StringOption.
 *
 * Option interface wrapped around a StringValue object.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class StringOption extends StringValue implements Option
{

    use OptionTrait;

    /**
     * Instantiate a StringOption object.
     *
     * @since 0.1.0
     *
     * @param string $key   Key of the option.
     * @param string $value Default value of the option.
     */
    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        parent::__construct($value);
    }
}
