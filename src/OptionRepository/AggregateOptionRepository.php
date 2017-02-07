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

use BrightNucleus\OptionsStore\Exception\InvalidOptionRepository;
use BrightNucleus\OptionsStore\Exception\UnknownOptionKey;
use BrightNucleus\OptionsStore\Option;
use BrightNucleus\OptionsStore\OptionCollection;
use BrightNucleus\OptionsStore\OptionRepository;

/**
 * Class AggregateOptionRepository.
 *
 * OptionsStore implementation that aggregates multiple OptionStorage implementations.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\OptionsStore\OptionsStore
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class AggregateOptionRepository implements OptionRepository
{

    /**
     * Array of OptionRepository instances.
     *
     * @since 0.1.0
     *
     * @var OptionRepository[]
     */
    private $repositories = [];

    /**
     * Instantiate an AggregateOptionRepository object.
     *
     * @since 0.1.0
     *
     * @param array $repositories Array of repositories to add.
     *
     * @throws InvalidOptionRepository If the $repositories array contained an invalid OptionRepository implementation.
     */
    public function __construct(array $repositories)
    {
        foreach ($repositories as $repository) {
            if (! $repository instanceof OptionRepository) {
                throw InvalidOptionRepository::fromRepository($repository);
            }
            $this->add($repository);
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
        foreach ($this->repositories as $repository) {
            if ($repository->has($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add an additional OptionRepository implementation.
     *
     * @since 0.1.0
     *
     * @param OptionRepository $repository Option repository to add.
     */
    public function add(OptionRepository $repository)
    {
        $this->repositories[] = $repository;
    }

    /**
     * Find the option for a given key.
     *
     * @since 0.1.0
     *
     * @param string $key Key to look for.
     *
     * @return Option Option that matches the key.
     * @throws UnknownOptionKey If the key could not be found.
     */
    public function find(string $key): Option
    {
        foreach ($this->repositories as $repository) {
            if ($repository->has($key)) {
                return $repository->find($key);
            }
        }

        throw UnknownOptionKey::fromKey($key);
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
        $options = [];

        foreach ($this->repositories as $repository) {
            array_push($options, ...$repository->findAll());
        }

        return new OptionCollection\ArrayOptionCollection($options);
    }

    /**
     * Save a modified option.
     *
     * @since 0.1.0
     *
     * @param Option $option Option to save.
     *
     * @return bool Whether saving was successful.
     * @throws UnknownOptionKey If the key could not be found.
     */
    public function save(Option $option): bool
    {
        $key = $option->getKey();

        foreach ($this->repositories as $repository) {
            if ($repository->has($key)) {
                return $repository->save($option);
            }
        }

        throw UnknownOptionKey::fromKey($key);
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
        foreach ($this->repositories as $repository) {
            $success &= $repository->persist();
        }

        return $success;
    }
}
