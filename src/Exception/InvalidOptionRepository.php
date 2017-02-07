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

use BrightNucleus\Config\ConfigInterface as Config;
use BrightNucleus\Exception\InvalidArgumentException;
use Exception;

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

    /**
     * Get a new exception based on an exception that was thrown during instantiation of a class.
     *
     * @since 0.1.4
     *
     * @param mixed     $class     Class that was tried to be instantiated.
     * @param Exception $exception Exception that was thrown during instantiation.
     *
     * @return static
     */
    public static function fromInstantiationException($class, Exception $exception)
    {
        $message = sprintf(
            'Could not instantiate OptionRepository of type "%1$s". Reason: %2$s',
            is_object($class)
                ? get_class($class)
                : gettype($class),
            $exception->getMessage()
        );

        return new static($message, 0, $exception);
    }

    /**
     * Get a new exception based on a Config that did not produce a valid repository.
     *
     * @since 0.1.0
     *
     * @param Config $config Config instance that was used.
     *
     * @return static
     */
    public static function fromConfig(Config $config)
    {
        $message = sprintf(
            'Could not instantiate OptionRepository from Config with starting key "%1$s".',
            empty($config->getKeys())
                ? '<none>'
                : $config->getKeys()[0]
        );

        return new static($message);
    }
}
