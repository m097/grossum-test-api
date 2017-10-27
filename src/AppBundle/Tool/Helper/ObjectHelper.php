<?php

namespace AppBundle\Tool\Helper;

use Symfony\Component\PropertyAccess\PropertyAccess;

class ObjectHelper
{
    private static $_instance;

    private $accessor;

    private function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public static function create() : ObjectHelper
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function merge($obj1, $obj2)
    {
        if (!is_object($obj1) || !is_object($obj2) || get_class($obj1) != get_class($obj2)) {
            throw new \InvalidArgumentException('Invalid objects');
        }

        $ref = new \ReflectionClass($obj1);
        foreach ($ref->getProperties() as $property) {
            try {
                $this->accessor->setValue(
                    $obj1,
                    $property->getName(),
                    $this->accessor->getValue($obj2, $property->getName())
                );
            } catch (\Exception $e) {

            }

        }
    }
}
