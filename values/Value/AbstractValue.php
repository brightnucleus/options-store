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

namespace BrightNucleus\Values\Value;

use BrightNucleus\Values\EscapeTarget;
use BrightNucleus\Values\Value;

/**
 * Class StringValue.
 *
 * Abstract representation of a single value.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Values
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
abstract class AbstractValue implements Value
{

    /**
     * Internal representation of the value.
     *
     * @since 0.1.0
     *
     * @var mixed
     */
    protected $value;

    /**
     * Get the raw value.
     *
     * @since 0.1.0
     *
     * @return mixed Current raw value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the raw value.
     *
     * @since 0.1.0
     *
     * @param mixed $value New raw value.
     *
     * @return Value Modified Value object. Can differ from the original one.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * "Execute" the value which is a shortcut for retrieving its raw value.
     *
     * If a context is passed, it is sanitized and/or escaped depending on this context.
     *
     * This is an alternative way for accessing values to allow for more elegant syntax.
     *
     * @since 0.1.0
     *
     * @return mixed
     */
    public function __invoke()
    {
        return $this->getValue();
    }

    /**
     * Return a string representation of the value.
     *
     * If a context is passed, it is sanitized and/or escaped depending on this context.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getValue();
    }

    /**
     * Get a sanitized version of the value.
     *
     * @since 0.1.0
     *
     * @param string $target Optional. Escaping target to use. Defaults to HTML.
     *
     * @return mixed Sanitized version of the value.
     */
    public function escape(string $target = EscapeTarget::HTML)
    {
        switch ($target) {
            case EscapeTarget::ATTRIBUTE:
                return $this->escapeAttribute();
            case EscapeTarget::JS:
                return $this->escapeJS();
            case EscapeTarget::HTML:
            default:
                return $this->escapeHTML();
        }
    }

    /**
     * Get a sanitized version of the value.
     *
     * @since 0.1.0
     *
     * @return mixed Sanitized version of the value.
     */
    public function sanitize()
    {
        return $this->value;
    }

    /**
     * Check whether the value is valid according to the attached validation rules.
     *
     * @since 0.1.0
     *
     * @return bool Whether the value is valid.
     */
    public function isValid(): bool
    {
        return true;
    }

    /**
     * Make sure the value is correctly encoded UTF-8.
     *
     * This prevents the so-called "Invalid Encoding Attack".
     *
     * @since 0.1.0
     *
     * @return string Valid UTF-8 encoded string.
     */
    protected function validateEncoding(): string
    {
        if (function_exists('mb_check_encoding')
            && mb_check_encoding($this->value, 'UTF-8')
        ) {
            return $this->value;
        }

        return function_exists('iconv')
            ? iconv('utf-8', 'utf-8', $this->value)
            : '';
    }

    /**
     * Escape the value for HTML output.
     *
     * @since 0.1.0
     *
     * @return string
     */
    protected function escapeHTML(): string
    {
        $value = $this->validateEncoding();

        return htmlspecialchars($value, ENT_QUOTES);
    }

    /**
     * Escape the value to be used as a HTML attribute.
     *
     * @since 0.1.0
     *
     * @return string
     */
    protected function escapeAttribute(): string
    {
        $value = $this->validateEncoding();
        $value = strip_tags($value);

        return htmlspecialchars($value, ENT_QUOTES);
    }

    /**
     * Escape the value to be used within JavaScript.
     *
     * @since 0.1.0
     *
     * @return string
     */
    protected function escapeJS(): string
    {
        $value = $this->validateEncoding();
        $value = htmlspecialchars($value, ENT_COMPAT);

        $value = preg_replace('/&#(x)?0*(?(1)27|39);?/i', '\'', stripslashes($value));
        $value = str_replace("\r", '', $value);

        return str_replace("\n", '\\n', addslashes($value));
    }
}
