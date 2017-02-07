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
use BrightNucleus\OptionsStore\OptionRepository\AggregateOptionRepository;
use BrightNucleus\OptionsStore\OptionRepository\VolatileOptionRepository;

/**
 * Class AggregateOptionRepositoryTest.
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
class AggregateOptionRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instantiated AggregateOptionRepository.
     *
     * @since 0.1.0
     *
     * @var AggregateOptionRepository
     */
    private $repository;

    /**
     * Set up a testing store.
     *
     * @since 0.1.0
     */
    protected function setUp()
    {
        parent::setUp();

        $this->repository = new AggregateOptionRepository(
            [
                new VolatileOptionRepository(
                    [
                        new Option\StringOption('test_string_a', 'String Value A'),
                        new Option\IntegerOption('test_integer_a', 42),
                    ]
                ),
                new VolatileOptionRepository(
                    [
                        new Option\StringOption('test_string_b', 'String Value B'),
                        new Option\IntegerOption('test_integer_b', 123),
                    ]
                ),
            ]
        );
    }

    /**
     * Test whether the class can be properly instantiated.
     *
     * @since 0.1.0
     */
    public function testClassInstantiation()
    {
        $this->assertInstanceOf(AggregateOptionRepository::class, $this->repository);
    }

    /**
     * Test whether a string option can be retrieved.
     *
     * @since        0.1.0
     *
     * @dataProvider aggregateOptionsDataProvider
     */
    public function testGettingAggregateOptions($key, $expectedClass, $expectedValue)
    {
        $option = $this->repository->find($key);
        $this->assertInstanceOf(Option::class, $option);
        $this->assertInstanceOf($expectedClass, $option);
        $this->assertSame($expectedValue, $option->getValue());
    }

    /**
     * Data provider for the testGettingAggregateOptions() method.
     *
     * @since 0.1.0
     */
    public function aggregateOptionsDataProvider()
    {
        return [
            ['test_string_a', Option\StringOption::class, 'String Value A'],
            ['test_string_b', Option\StringOption::class, 'String Value B'],
            ['test_integer_a', Option\IntegerOption::class, 42],
            ['test_integer_b', Option\IntegerOption::class, 123],
        ];
    }

    /**
     * Test whether an option can be changed.
     *
     * @since 0.1.0
     */
    public function testChangingAnOption()
    {
        $optionA = $this->repository->find('test_string_a');
        $this->assertSame('String Value A', $optionA->getValue());

        $optionA->setValue('New String Value');
        $this->assertSame('New String Value', $optionA->getValue());

        $optionB = $this->repository->find('test_string_a');
        $this->assertSame('New String Value', $optionB->getValue());
    }

    /**
     * Test getting all options.
     *
     * @since 0.1.5
     */
    public function testGettingAllOptions()
    {
        $options = $this->repository->findAll();
        $this->assertInstanceOf(OptionCollection::class, $options);
        $this->assertCount(4, $options);
    }
}
