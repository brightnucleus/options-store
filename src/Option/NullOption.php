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
use BrightNucleus\Values\Value\NullValue;

/**
 * Class NullOption.
 *
 * Option interface wrapped around a NullValue object.
 *
 * @since   0.1.11
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class NullOption extends NullValue implements Option
{

    /**
     * Key of the option.
     *
     * @since 0.1.11
     *
     * @var string
     */
    protected $key;

    /**
     * Instantiate a NullOption object.
     *
     * @since 0.1.11
     *
     * @param string $key Key of the option.
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Get the identifier key of the option.
     *
     * @since 0.1.11
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
