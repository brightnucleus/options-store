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

namespace BrightNucleus\OptionsStore\OptionRepository;

use BrightNucleus\OptionsStore\Exception\InvalidOption;
use BrightNucleus\OptionsStore\Exception\UnknownOptionKey;
use BrightNucleus\OptionsStore\Option;
use BrightNucleus\OptionsStore\OptionCollection;
use BrightNucleus\OptionsStore\OptionRepository;

/**
 * Abstract class AbstractOptionRepository.
 *
 * Abstract base class for the OptionRepository interface.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\OptionRepository
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
abstract class AbstractOptionRepository implements OptionRepository
{

    /**
     * Schema representation.
     *
     * @since 0.1.0
     *
     * @var array<Option>
     */
    protected $schema = [];

    /**
     * Stored values that differ from the default.
     *
     * @since 0.1.0
     *
     * @var array
     */
    protected $values = [];

    /**
     * Identity map that keeps tracked of instantiated options.
     *
     * @var IdentityMap
     *
     * @since 0.1.0
     */
    protected $identityMap;

    /**
     * Instantiate a AbstractOptionRepository object.
     *
     * @since 0.1.0
     *
     * @param array $options Optional. Array of Option instances that define available options and defaults.
     */
    public function __construct(array $options = [])
    {
        $this->identityMap = IdentityMap::getInstance();
        $this->initialize($options);
    }

    /**
     * Initialize the internal state of the repository.
     *
     * @since 0.1.0
     *
     * @param array $options
     */
    protected function initialize(array $options)
    {
        foreach ($options as $option) {
            if (! $option instanceof Option) {
                throw InvalidOption::fromOption($option);
            }

            $option = $this->identityMap->put($option, $this);

            $this->schema[$option->getKey()] = $option;
        }
    }

    /**
     * Check whether the repository contains a given key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to check for.
     *
     * @return bool Whether the repository contained the requested key.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->schema);
    }

    /**
     * Find the option for a given key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to look for.
     *
     * @return Option Option that matches the key.
     * @throws UnknownOptionKey If the option key is not known.
     */
    public function find(string $key): Option
    {
        // Error out if option is not found in schema.
        if (! $this->has($key)) {
            throw UnknownOptionKey::fromKey($key);
        }

        // If we already had instantiated the option, we need to make sure to use the same reference, to keep all
        // consumers in sync.
        if (! $this->identityMap->has($key)) {
            // We don't have an instance in our identity map yet, so we clone one from our schema.
            $option = clone $this->schema[$key];
            $this->identityMap->put($option, $this);
        }
        $option = $this->identityMap->getOption($key);

        // Retrieve the value from persistence, while falling back to the default value if no persisted one was found.
        // Then, cache the value so that we only hit the persistent storage once.
        if (! isset($this->values[$key])) {
            $this->values[$key] = $this->readOption($key, $this->schema[$key]->getValue() ?? null);
        }

        // Keep the value of the option up-to-date with latest changes.
        if (isset($this->values[$key])
            && $option->getValue() !== $this->values[$key]
        ) {
            $option->setValue($this->values[$key], $persist = false);
        }

        return $option;
    }

    /**
     * Find all options known by the repository.
     *
     * @since 0.1.5
     *
     * @return OptionCollection Collection of all options.
     */
    public function findAll(): OptionCollection
    {
        $collection = new OptionCollection\ArrayOptionCollection();

        foreach ($this->schema as $key => $value) {
            $collection->add($this->find($key));
        }

        return $collection;
    }

    /**
     * Save a modified option.
     *
     * @since 0.1.0
     *
     * @param Option $option Option to save.
     *
     * @return bool Whether saving was successful.
     */
    public function save(Option $option): bool
    {
        $key = $option->getKey();

        if (! $this->has($key)) {
            throw UnknownOptionKey::fromKey($key);
        }

        $this->values[$key] = $option->sanitize();

        return $this->persist();
    }

    /**
     * Persist eventual changes to the respective backend.
     *
     * @since 0.1.0
     *
     * @return bool Whether persisting was successful.
     */
    public function persist(): bool
    {
        $success = true;
        foreach ($this->values as $key => $value) {
            $success &= $this->writeOption($key, $value);
        }

        return $success;
    }

    /**
     * Read a single option from the persistence mechanism.
     *
     * @since 0.1.0
     *
     * @param string $key      Key of the option to read.
     * @param mixed  $fallback Optional. Fallback value to use if the option was not found.
     *
     * @return mixed Value that was read.
     * @throws UnknownOptionKey If the value could not be retrieved.
     */
    abstract protected function readOption(string $key, $fallback = null);

    /**
     * Write a single option to the persistence mechanism.
     *
     * @since 0.1.0
     *
     * @param string $key   Key of the option to write.
     * @param mixed  $value Value to write.
     *
     * @return bool Whether the write operation was successful.
     */
    abstract protected function writeOption(string $key, $value): bool;
}
