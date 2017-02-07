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

namespace BrightNucleus\OptionsStore\Test\TestClasses;

use BrightNucleus\OptionsStore\Option\IntegerOption;

/**
 * Class UserIDOption.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class UserIDOption extends IntegerOption
{

    const KEY     = 'user_id';
    const DEFAULT = 1;

    /**
     * Instantiate a UserIDOption object.
     *
     * @since 0.1.4
     */
    public function __construct()
    {
        parent::__construct(self::KEY, self::DEFAULT);
    }
}
