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
 * Interface OptionsStore.
 *
 * Central access point for handling options.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class OptionsStore
{

    /**
     * OptionRepository instance to use.
     *
     * @since 0.1.0
     *
     * @var OptionRepository
     */
    protected $repository;

    /**
     * List of known option keys.
     *
     * @since 0.1.0
     *
     * @var array<string>
     */
    protected $keys = [];

    /**
     * Instantiate an OptionsStore object.
     *
     * @since 0.1.0
     *
     * @param OptionRepository $repository OptionRepository instance to use.
     */
    public function __construct(OptionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a specific option.
     *
     * @since 0.1.0
     *
     * @param string $key Option key to retrieve.
     *
     * @return Option Option object for the requested key.
     */
    public function get(string $key): Option
    {
        return $this->repository->find($key);
    }

    /**
     * Get all known options.
     *
     * @since 0.1.0
     *
     * @return OptionCollection Collection of Option objects.
     */
    public function getAll(): OptionCollection
    {
        $options = new OptionCollection\ArrayOptionCollection();
        foreach ($this->keys as $key) {
            $options->add($this->repository->find($key));
        }

        return $options;
    }

    /**
     * Update an existing option.
     *
     * @since 0.1.0
     *
     * @param Option $option Option with new value.
     *
     * @return bool Whether the update was successful.
     */
    public function update(Option $option): bool
    {
        return $this->repository->save($option);
    }

    /**
     * Set the value for a specific key.
     *
     * @since 0.1.0
     *
     * @param string $key   Option key to set the value of.
     * @param mixed  $value New value to set the option to.
     *
     * @return bool Whether the change of value was successful.
     */
    public function set(string $key, $value): bool
    {
        $option = $this->repository->find($key);

        return $this->update($option->setValue($value));
    }

    /**
     * Persist eventual changes to their respective repositories.
     *
     * @since 0.1.0
     *
     * @return bool Whether persisting was successful.
     */
    public function persist(): bool
    {
        return $this->repository->persist();
    }
}
