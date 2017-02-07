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
 * Interface OptionRepository.
 *
 * Persistence backend abstraction for options.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface OptionRepository
{

    /**
     * Check whether the repository contains a given key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to check for.
     *
     * @return bool Whether the repository contained the requested key.
     */
    public function has(string $key): bool;

    /**
     * Find the option for a given key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to look for.
     *
     * @return Option Option that matches the key.
     */
    public function find(string $key): Option;

    /**
     * Save a modified option.
     *
     * @since 0.1.0
     *
     * @param Option $option Option to save.
     *
     * @return bool Whether saving was successful.
     */
    public function save(Option $option): bool;

    /**
     * Persist eventual changes to the respective backend.
     *
     * @since 0.1.0
     *
     * @return bool Whether persisting was successful.
     */
    public function persist(): bool;
}