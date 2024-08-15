<?php

namespace Team\Members;

/**
 * Class BaseComponent
 * @package Team\Members
 */
abstract class BaseComponent
{
    public static function create_instance()
    {
        return (new static());
    }
}