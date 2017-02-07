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

namespace BrightNucleus\OptionsStore;

use BrightNucleus\Values\Value;

/**
 * Interface Option.
 *
 * This represents a single option that was returned from the options store.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface Option extends Value
{

    /**
     * Get the identifier key of the option.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Set the raw value.
     *
     * @since 0.1.0
     *
     * @param mixed $value New raw value.
     *
     * @return Option Modified Option object. Can differ from the original one.
     */
    public function setValue($value);
}
