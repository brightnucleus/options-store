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

namespace BrightNucleus\OptionsStore\Exception;

use BrightNucleus\Exception\InvalidArgumentException;

/**
 * Class InvalidOptionRepository.
 *
 * Thrown when an invalid OptionRepository implementation is tried to be added to the AggregateOptionRepository.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class InvalidOptionRepository extends InvalidArgumentException implements OptionsStoreException
{

    /**
     * Get a new exception based on the type of an invalid repository.
     *
     * @since 0.1.0
     *
     * @param mixed $repository Repository that was tried to be added.
     *
     * @return static
     */
    public static function fromRepository($repository)
    {
        $message = sprintf(
            'Could not add invalid OptionRepository of type "%1$s" to AggregateOptionRepository.',
            is_object($repository)
                ? get_class($repository)
                : gettype($repository)
        );

        return new static($message);
    }
}
