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
use BrightNucleus\Values\Value\IntegerValue;

/**
 * Class IntegerOption.
 *
 * Option interface wrapped around an IntegerValue object.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class IntegerOption extends IntegerValue implements Option
{

    use OptionTrait;

    /**
     * Instantiate an IntegerOption object.
     *
     * @since 0.1.0
     *
     * @param string $key   Key of the option.
     * @param int    $value Default value of the option.
     * @param int    $flags Optional. Bitwise flags to define behaviour.
     */
    public function __construct(string $key, int $value, int $flags = 0)
    {
        $this->key = $key;
        parent::__construct($value, $flags);
    }
}
