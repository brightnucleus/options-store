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

use BrightNucleus\OptionsStore\Exception\UnknownOptionKey;
use BrightNucleus\OptionsStore\Option;
use BrightNucleus\OptionsStore\OptionRepository;

/**
 * Class IdentityMap.
 *
 * The Identity Map contains a map of all instantiated objects, so that only one single instance of each option can
 * ever be circulating. This avoids having one consumer update a value and another one then using the old, stale value.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\OptionRepository
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class IdentityMap
{

    const SUBKEY_OPTION     = 'option';
    const SUBKEY_REPOSITORY = 'repository';

    /**
     * Internal mapping state.
     *
     * @var array
     *
     * @since 0.1.0
     */
    private $map = [];

    /**
     * Shared instance of the identity map.
     *
     * @since 0.1.0
     *
     * @var IdentityMap
     */
    private static $instance;

    /**
     * Get the shared instance of the identity map.
     *
     * @since 0.1.0
     *
     * @return IdentityMap Shared instance of the identity map.
     */
    public static function getInstance()
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     * Check whether the identity map has a given key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to check for.
     *
     * @return bool Whether the key was found.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->map);
    }

    /**
     * Get the associated option for a specific key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to fetch the option for.
     *
     * @return Option The option that is associated with the requested key.
     */
    public function getOption(string $key): Option
    {
        if (! $this->has($key)) {
            throw UnknownOptionKey::fromKey($key);
        }

        return $this->map[$key][self::SUBKEY_OPTION];
    }

    /**
     * Get the associated repository for a specific key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to fetch the repository for.
     *
     * @return OptionRepository The repository that is associated with the requested key.
     */
    public function getRepository(string $key): OptionRepository
    {
        if (! $this->has($key)) {
            throw UnknownOptionKey::fromKey($key);
        }

        return $this->map[$key][self::SUBKEY_REPOSITORY];
    }

    /**
     * Put a new association into the identity map.
     *
     * @since 0.1.0
     *
     * @param Option           $option     Option to store for the given key.
     * @param OptionRepository $repository Repository to store for the given key.
     *
     * @return Option $option Option that was stored in the identity map. This might differ from the passed-in $option.
     */
    public function put(Option $option, OptionRepository $repository): Option
    {
        $this->map[$option->getKey()] = [
            self::SUBKEY_OPTION     => $option,
            self::SUBKEY_REPOSITORY => $repository,
        ];

        return $option;
    }
}
