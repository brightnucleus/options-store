<?php
/**
 * Bright Nucleus Values.
 *
 * Manipulate sanitizable and validatable values.
 *
 * @package   BrightNucleus\Values
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.brightnucleus.com/
 * @copyright 2017 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Values\ValidationError;

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
     * Key of the option that was not valid.
     *
     * @since 0.1.1
     *
     * @var string
     */
    private $key;

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
     * @param string      $key     Key of the option that was not valid.
     * @param string|null $message Optional. Message describing the requirement.
     */
    public function __construct(string $key, string $message = null)
    {
        $this->key     = $key;
        $this->message = $message ?? $this->getDefaultMessage();
    }

    /**
     * Get the key of the option that was not valid.
     *
     * @since 0.1.1
     *
     * @return string Message describing the requirement.
     */
    public function getKey()
    {
        return $this->key;
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
            'The value provided for option "%1$s" was not valid.',
            $this->key
        );
    }
}
