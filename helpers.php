<?php
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @param string $type
 *
 * @return string|null
 */
function get_class_by_type($type)
{
    $class = array_get(Relation::morphMap(), $type, $type);

    if (! class_exists($class)) {
        return;
    }

    return $class;
}

/**
 * @param string $class
 *
 * @return string
 */
function get_morph_type($class)
{
    if(is_object($class)) {
        $class = get_class($class);
    }

    return array_search($class, Relation::morphMap()) ?: $class;
}