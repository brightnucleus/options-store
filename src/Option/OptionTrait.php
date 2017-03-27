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
use BrightNucleus\Values\Exception\FailedToValidate;
use BrightNucleus\Values\Value;

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
     * Option name that is displayed to the user.
     *
     * @since 0.1.11
     *
     * @var string
     */
    protected $name;

    /**
     * Internal representation of the value.
     *
     * @since 0.1.11
     *
     * @var mixed
     */
    protected $value;

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
     * @param mixed $value   New raw value.
     * @param bool  $persist Optional. Whether to immediately persist the value.
     *
     * @return Option Modified Option object. Can differ from the original one.
     */
    public function setValue($value, $persist = true)
    {
        if ($this->isEmpty($value) && ! $this->flags & Value::CAN_BE_EMPTY) {
            throw FailedToValidate::fromValue($value, $this);
        }

        if (! $this->isEmpty($value)) {
            $value = $this->validate($value);
        }

        if (null === $value) {
            throw FailedToValidate::fromValue($value, $this);
        }

        $this->value = $value;

        if (! $persist ) {
            return $this;
        }

        $repository  = IdentityMap::getInstance()->getRepository($this->key);
        $repository->save($this);

        return $this;
    }
}
