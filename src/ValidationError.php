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
 * Interface ValidationError.
 *
 * @since   0.1.1
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface ValidationError {

	/**
	 * Get the option that was not valid.
	 *
	 * @since 0.1.1
	 *
	 * @return Value Option that was not valid.
	 */
	public function getOption();

	/**
	 * Get the message describing the requirement.
	 *
	 * @since 0.1.1
	 *
	 * @return string Message describing the requirement.
	 */
	public function getMessage();
}
