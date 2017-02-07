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

/**
 * Class WordPressOptionRepository.
 *
 * WordPress implementation for the OptionRepository, using WPDB as a backend.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\OptionRepository
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class WordPressOptionRepository extends AbstractOptionRepository implements Prefixable
{

    /**
     * Prefix to add to all option keys.
     *
     * @since 0.1.0
     *
     * @var string
     */
    private $prefix;

    /**
     * Instantiate a WordPressOptionRepository object.
     *
     * @since 0.1.0
     *
     * @param string $prefix  Optional. Prefix to add to all option keys. Defaults to an empty string (=> no prefix).
     * @param array  $options Optional. Array of Option instances that define available options and defaults.
     */
    public function __construct(string $prefix = '', array $options = [])
    {
        $this->prefix = $prefix;
        parent::__construct($options);
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
    protected function readOption(string $key, $fallback = null)
    {
        $value = get_option($this->prefix . $key, $fallback ?: false);
        if (false === $value) {
            throw UnknownOptionKey::fromKey($key);
        }

        return $value;
    }

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
    protected function writeOption(string $key, $value): bool
    {
        return $value === get_option($this->prefix . $key)
               || update_option($this->prefix . $key, $value);
    }
}
