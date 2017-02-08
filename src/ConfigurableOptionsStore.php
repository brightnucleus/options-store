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

use BrightNucleus\Config\ConfigInterface as Config;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Config\Exception\FailedToProcessConfigException;
use BrightNucleus\OptionsStore\Exception\InvalidOption;
use BrightNucleus\OptionsStore\Exception\InvalidOptionRepository;
use BrightNucleus\OptionsStore\OptionRepository\AggregateOptionRepository;
use BrightNucleus\OptionsStore\OptionRepository\Prefixable;
use Exception;

/**
 * Class ConfigurableOptionsStore.
 *
 * OptionsStore implementation that takes a Config file to set up its repository.
 *
 * @since   0.1.4
 *
 * @package BrightNucleus\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class ConfigurableOptionsStore extends OptionsStore
{

    use ConfigTrait;

    /**
     * Instantiate a ConfigurableOptionsStore object.
     *
     * @since 0.1.4
     *
     * @param Config $config Config instance to use to configure the repository.
     *
     * @throws FailedToProcessConfigException If the Config could not be processed.
     * @throws InvalidOptionRepository If the repository could not be configured.
     */
    public function __construct(Config $config)
    {
        $this->processConfig($config);
        $repository = $this->configureRepository($this->config);
        parent::__construct($repository);
    }

    /**
     * Configure a single repository from a Config file.
     *
     * This will automatically regroup an array of repositories into an AggregateOptionRepository.
     *
     * @since 0.1.4
     *
     * @param Config $config Config instance to use.
     *
     * @return OptionRepository Option repository that was built from the passed-in repository.
     * @throws InvalidOptionRepository If the repository could not be configured.
     * @throws InvalidOptionRepository If the repository could not be instantiated.
     */
    protected function configureRepository(Config $config): OptionRepository
    {
        $repositories = [];

        $prefix = '';

        foreach ($config->getAll() as $class => $optionsArray) {
            if ($class === OptionRepository::PREFIX) {
                $prefix = (string)$optionsArray;
                continue;
            }

            $options = $this->configureOptions((array)$optionsArray);

            try {
                $repositories[] = $this->isPrefixable($class)
                    ? new $class($prefix, $options->getValues())
                    : new $class($options->getValues());
            } catch (Exception $exception) {
                throw InvalidOptionRepository::fromInstantiationException($class, $exception);
            }
        }

        if (empty($repositories)) {
            throw InvalidOptionRepository::fromConfig($config);
        }

        if (1 === count($repositories)) {
            return $repositories[0];
        }

        return new AggregateOptionRepository($repositories);
    }

    /**
     * Build a collection of options from an array of Config values.
     *
     * @since 0.1.0
     *
     * @param array $optionsArray Array of config values that are used to build the options.
     *
     * @return OptionCollection Collection of instantiated options.
     */
    protected function configureOptions(array $optionsArray): OptionCollection
    {
        $options = new OptionCollection\ArrayOptionCollection();
        foreach ($optionsArray as $option) {
            if ($option instanceof Option) {
                $options->add($option);
                continue;
            }

            if (is_callable($option)) {
                $option = $option($this->config);
            }

            if (is_string($option)) {
                $option = new $option();
            }

            if (! $option instanceof Option) {
                throw InvalidOption::fromOption($option);
            }

            $options->add($option);
        }

        return $options;
    }

    /**
     * Check whether a FQCN or an object implements the Prefixable interface.
     *
     * @since 0.1.0
     *
     * @param OptionRepository|string $objectOrClassName Object instance or FQCN.
     *
     * @return bool Whether the passed-in argument is prefixable.
     */
    protected function isPrefixable($objectOrClassName): bool
    {
        if (is_string($objectOrClassName)) {
            return in_array(Prefixable::class, class_implements($objectOrClassName), true);
        }

        if (is_object($objectOrClassName)) {
            return $objectOrClassName instanceof Prefixable;
        }

        return false;
    }
}
