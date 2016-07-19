<?php

namespace Fields;

class FieldFactory
{
    /**
     * Get field object by class name
     *
     * @param string $field_type field class name
     * @param array $options field options
     * @return AbstractField
     * @throws \WPKit\Exception\WpException
     */
    public static function create($type, $name = null, array $options = [])
    {
        $class_name = sprintf('Fields\\%s', ucfirst($type));

        if(class_exists($class_name)) {
            /** @var $object AbstractField */
            $object = new $class_name($name, $options);
            return $object;
        }

        throw new \Exception("Class $class_name does not exist.");
    }
}