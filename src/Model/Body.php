<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model;

/**
 * Class Body
 *
 * @author Nate Brunette <n@tebru.net>
 */
class Body
{
    /**
     * @var array
     */
    private $body;

    /**
     * Add a line to the body
     *
     * @param string $line A php string
     * @param mixed $_ Arguments to add to vsprintf
     * @return $this
     */
    public function add($line, $_ = null)
    {
        $this->body[] = vsprintf($line, array_slice(func_get_args(), 1));

        return $this;
    }

    /**
     * Convert the body arguments to a string
     *
     * @return string
     */
    public function __toString()
    {
        return implode($this->body);
    }
}
