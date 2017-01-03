<?php

namespace Dgame\Wrapper;

/**
 * Class StringConverter
 * @package Dgame\Wrapper
 */
interface StringConvertInterface
{
    /**
     * @return StringWrapper
     */
    public function underscored(): StringWrapper;

    /**
     * @return StringWrapper
     */
    public function dasherize(): StringWrapper;

    /**
     * @return StringWrapper
     */
    public function camelize(): StringWrapper;

    /**
     * @return StringWrapper
     */
    public function titelize(): StringWrapper;

    /**
     * @param string $delimiter
     *
     * @return StringWrapper
     */
    public function slugify(string $delimiter = '-'): StringWrapper;
}