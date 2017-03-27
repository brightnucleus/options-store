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

namespace BrightNucleus\OptionsStore\ValidationError;

use BrightNucleus\OptionsStore\Option;

/**
 * Class ValidationErrorTrait.
 *
 * @since   0.1.1
 *
 * @package BrightNucleus\Values\ValidationError
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
trait ValidationErrorTrait
{
    /**
     * Option that was not valid.
     *
     * @since 0.1.1
     *
     * @var string
     */
    private $option;

    /**
     * Message describing the requirement.
     *
     * @since 0.1.1
     *
     * @var string
     */
    private $message;

    /**
     * Instantiate a ValidationErrorTrait object.
     *
     * @since 0.1.0
     *
     * @param Option      $option  Option that was not valid.
     * @param string|null $message Optional. Message describing the requirement.
     */
    public function __construct(Option $option, string $message = null)
    {
        $this->option  = $option;
        $this->message = $message ?? $this->getDefaultMessage();
    }

    /**
     * Get the option that was not valid.
     *
     * @since 0.1.1
     *
     * @return string Option that was not valid.
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Get the message describing the requirement.
     *
     * @since 0.1.1
     *
     * @return string Message describing the requirement.
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the default validation requirement message.
     *
     * @since 0.1.1
     *
     * @return string Default validation requirement message.
     */
    private function getDefaultMessage()
    {
        return sprintf(
            'The value "%1$s" provided for option "%2$s" was not valid.',
            $this->option->getName(),
            $this->option->getKey()
        );
    }
}
