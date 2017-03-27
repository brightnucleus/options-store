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

/**
 * Interface ValidationError.
 *
 * @since   0.1.11
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface ValidationError
{

    /**
     * Get the option that was not valid.
     *
     * @since 0.1.11
     *
     * @return Option Option that was not valid.
     */
    public function getOption();

    /**
     * Get the message describing the requirement.
     *
     * @since 0.1.11
     *
     * @return string Message describing the requirement.
     */
    public function getMessage();
}
