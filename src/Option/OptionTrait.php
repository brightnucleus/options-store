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
use BrightNucleus\OptionsStore\OptionRepository\IdentityMap;

/**
 * Trait OptionTrait.
 *
 * This adds a retrievable key to an option.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
trait OptionTrait
{

    /**
     * Option key that this option is attributed to.
     *
     * @since 0.1.0
     *
     * @var string
     */
    protected $key;

    /**
     * Get the identifier key of the option.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set the raw value.
     *
     * @since 0.1.0
     *
     * @param mixed $value New raw value.
     *
     * @return Option Modified Option object. Can differ from the original one.
     */
    public function setValue($value)
    {
        $this->value = $value;
        $repository  = IdentityMap::getInstance()->getRepository($this->key);
        $repository->save($this);

        return $this;
    }
}
