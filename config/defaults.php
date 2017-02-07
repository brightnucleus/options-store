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

/*
 * Configuration for Bright Nucleus Options Store.
 */
$configuration = [
];

/*
 * Return the configuration with a vendor/package prefix.
 */
return [
    'BrightNucleus' => [
        'OptionsStore' => $configuration,
    ],
];
