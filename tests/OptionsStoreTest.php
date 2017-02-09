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

use BrightNucleus\OptionsStore\Option;
use BrightNucleus\OptionsStore\OptionRepository\IdentityMap;
use BrightNucleus\OptionsStore\OptionRepository\VolatileOptionRepository;

/**
 * Class OptionsStoreTest.
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
class OptionsStoreTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instantiated OptionStore.
     *
     * @since 0.1.0
     *
     * @var OptionsStore
     */
    private $store;

    /**
     * Set up a testing store.
     *
     * @since 0.1.0
     */
    protected function setUp()
    {
        parent::setUp();

        IdentityMap::getInstance()->purge();

        $this->store = new OptionsStore(
            new VolatileOptionRepository(
                [
                    new Option\StringOption('test_string', 'String Value'),
                    new Option\IntegerOption('test_integer', 42),
                ]
            )
        );
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.0
     */
    public function testClassInstantiation()
    {
        $this->assertInstanceOf(OptionsStore::class, $this->store);
    }

    /**
     * Test whether a string option can be retrieved.
     *
     * @since 0.1.0
     */
    public function testGettingAStringOption()
    {
        $option = $this->store->get('test_string');
        $this->assertInstanceOf(Option::class, $option);
        $this->assertInstanceOf(Option\StringOption::class, $option);
        $this->assertSame('String Value', $option->getValue());
    }

    /**
     * Test whether an integer option can be retrieved.
     *
     * @since 0.1.0
     */
    public function testGettingAnIntegerOption()
    {
        $option = $this->store->get('test_integer');
        $this->assertInstanceOf(Option::class, $option);
        $this->assertInstanceOf(Option\IntegerOption::class, $option);
        $this->assertSame(42, $option->getValue());
    }

    /**
     * Test whether an option can be retrieved from the OptionsStore.
     *
     * @since 0.1.0
     */
    public function testGettingOneOption()
    {
        $option = $this->store->get('test_string');
        $this->assertInstanceOf(Option::class, $option);
        $this->assertSame('String Value', $option->getValue());
    }

    /**
     * Test whether an option can be changed.
     *
     * @since 0.1.0
     */
    public function testChangingAnOption()
    {
        $optionA = $this->store->get('test_string');
        $this->assertSame('String Value', $optionA->getValue());

        $optionA->setValue('New String Value');
        $this->assertSame('New String Value', $optionA->getValue());

        $optionB = $this->store->get('test_string');
        $this->assertSame('New String Value', $optionB->getValue());
    }

    /**
     * Test getting all options.
     *
     * @since 0.1.5
     */
    public function testGettingAllOptions()
    {
        $options = $this->store->getAll();
        $this->assertInstanceOf(OptionCollection::class, $options);
        $this->assertCount(2, $options);
    }
}
