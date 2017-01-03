<?php

namespace Dgame\Wrapper;

/**
 * Class StringConverter
 * @package Dgame\Wrapper
 */
final class StringConverter implements StringConvertInterface
{
    /**
     * @var StringWrapper
     */
    private $wrapper;

    /**
     * StringConverter constructor.
     *
     * @param StringWrapper $wrapper
     */
    public function __construct(StringWrapper $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * @return StringWrapper
     */
    public function underscored(): StringWrapper
    {
        return $this->wrapper->pregReplace('#\s+#', '')
                             ->pregReplace('#\B([A-Z])#', '_\1');
    }

    /**
     * @return StringWrapper
     */
    public function dasherize(): StringWrapper
    {
        return $this->wrapper->pregReplace('#\s+#', '')
                             ->pregReplace('#\B([A-Z])#', '-\1');
    }

    /**
     * @return StringWrapper
     */
    public function camelize(): StringWrapper
    {
        return $this->wrapper->trim()
                             ->trim('-_.')
                             ->pregReplace('#\s+#', '_')
                             ->pregReplaceCallback('#[-_\.]([a-z])#i', function (array $matches) {
                                 return ucfirst($matches[1][0]);
                             });
    }

    /**
     * @return StringWrapper
     */
    public function titelize(): StringWrapper
    {
        return $this->camelize()->toUpperCaseFirst();
    }

    /**
     * @param string $delimiter
     *
     * @return StringWrapper
     */
    public function slugify(string $delimiter = '-'): StringWrapper
    {
        return $this->wrapper->trim()
                             ->pregReplace('#[^a-z\d-]+#i', ' ')
                             ->pregReplace('#\s+#', $delimiter)
                             ->toLowerCase()
                             ->trim($delimiter);
    }
}