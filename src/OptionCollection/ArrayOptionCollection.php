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

namespace BrightNucleus\OptionsStore\OptionCollection;

use BrightNucleus\OptionsStore\OptionCollection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ArrayOptionCollection.
 *
 * OptionCollection implementation that uses Doctrine ArrayCollection as backend.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\OptionCollection
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class ArrayOptionCollection extends ArrayCollection implements OptionCollection
{

}
