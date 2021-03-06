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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ValidationErrorCollection.
 *
 * @since   0.1.11
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class ValidationErrorCollection extends ArrayCollection
{

}
