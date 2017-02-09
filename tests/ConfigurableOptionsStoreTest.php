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

use BrightNucleus\Config\ConfigFactory;
use BrightNucleus\OptionsStore\OptionRepository\IdentityMap;
use BrightNucleus\OptionsStore\OptionRepository\VolatileOptionRepository;
use BrightNucleus\OptionsStore\Test\TestClasses\UserEmailOption;
use BrightNucleus\OptionsStore\Test\TestClasses\UserIDOption;

/**
 * Class ConfigurableOptionsStoreTest.
 *
 * @since  0.1.4
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
class ConfigurableOptionsStoreTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Purge existing data structures before each test.
     *
     * @since 0.1.4
     */
    public function setUp()
    {
        IdentityMap::getInstance()->purge();
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.4
     */
    public function testClassInstantiation()
    {
        $config  = ConfigFactory::createFromArray([
            VolatileOptionRepository::class => [],
        ]);
        $options = new ConfigurableOptionsStore($config);
        $this->assertInstanceOf(OptionsStore::class, $options);
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.4
     */
    public function testConfigurableOptions()
    {
        $config  = ConfigFactory::createFromArray([
            VolatileOptionRepository::class => [
                new Option\StringOption('test_string', 'Test Value'),
                new Option\IntegerOption('test_integer', 42),
            ],
        ]);
        $options = new ConfigurableOptionsStore($config);

        $this->assertInstanceOf(OptionsStore::class, $options);

        $testString = $options->get('test_string');
        $this->assertInstanceOf(Option\StringOption::class, $testString);
        $this->assertSame('Test Value', $testString->getValue());

        $testInteger = $options->get('test_integer');
        $this->assertInstanceOf(Option\IntegerOption::class, $testInteger);
        $this->assertSame(42, $testInteger->getValue());
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.4
     */
    public function testConfigurableClosures()
    {
        $config  = ConfigFactory::createFromArray([
            VolatileOptionRepository::class => [
                function () { return new Option\StringOption('test_string', 'Test Value'); },
                function () { return new Option\IntegerOption('test_integer', 42); },
            ],
        ]);
        $options = new ConfigurableOptionsStore($config);

        $this->assertInstanceOf(OptionsStore::class, $options);

        $testString = $options->get('test_string');
        $this->assertInstanceOf(Option\StringOption::class, $testString);
        $this->assertSame('Test Value', $testString->getValue());

        $testInteger = $options->get('test_integer');
        $this->assertInstanceOf(Option\IntegerOption::class, $testInteger);
        $this->assertSame(42, $testInteger->getValue());
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.4
     */
    public function testConfigurableClassStrings()
    {
        $config  = ConfigFactory::createFromArray([
            VolatileOptionRepository::class => [
                UserEmailOption::class,
                UserIDOption::class,
            ],
        ]);
        $options = new ConfigurableOptionsStore($config);

        $this->assertInstanceOf(OptionsStore::class, $options);

        $userEmail = $options->get(UserEmailOption::KEY);
        $this->assertInstanceOf(Option\StringOption::class, $userEmail);
        $this->assertInstanceOf(UserEmailOption::class, $userEmail);
        $this->assertSame('admin@example.com', $userEmail->getValue());

        $userID = $options->get(UserIDOption::KEY);
        $this->assertInstanceOf(Option\IntegerOption::class, $userID);
        $this->assertInstanceOf(UserIDOption::class, $userID);
        $this->assertSame(1, $userID->getValue());
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.4
     */
    public function testConfigurableAggregateRepository()
    {
        // We need to define an alias here, as PHP does not allow duplicate array keys.
        // In a real-world scenario, you would only use the aggregate repository with two different repository
        // implementations, as there's no point in splitting the options between two instances of the exact same
        // implementation.
        class_alias(VolatileOptionRepository::class, 'AnotherVolatileOptionRepository');

        $config  = ConfigFactory::createFromArray([
            VolatileOptionRepository::class   => [
                new Option\StringOption('test_string_a', 'Test Value A'),
                new Option\IntegerOption('test_integer_a', 42),
            ],
            'AnotherVolatileOptionRepository' => [
                new Option\StringOption('test_string_b', 'Test Value B'),
                new Option\IntegerOption('test_integer_b', 123),
            ],
        ]);
        $options = new ConfigurableOptionsStore($config);

        $this->assertInstanceOf(OptionsStore::class, $options);

        $testStringA = $options->get('test_string_a');
        $this->assertInstanceOf(Option\StringOption::class, $testStringA);
        $this->assertSame('Test Value A', $testStringA->getValue());

        $testIntegerA = $options->get('test_integer_a');
        $this->assertInstanceOf(Option\IntegerOption::class, $testIntegerA);
        $this->assertSame(42, $testIntegerA->getValue());

        $testStringB = $options->get('test_string_b');
        $this->assertInstanceOf(Option\StringOption::class, $testStringB);
        $this->assertSame('Test Value B', $testStringB->getValue());

        $testIntegerB = $options->get('test_integer_b');
        $this->assertInstanceOf(Option\IntegerOption::class, $testIntegerB);
        $this->assertSame(123, $testIntegerB->getValue());
    }
}
