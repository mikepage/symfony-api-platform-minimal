<?php

namespace App\Doctrine;

trait PropertyHelperTrait
{
    protected function getProperties(array $params): array
    {
        $properties = [];

        foreach ($params as $property => $value) {
            $this->setPropertyFromPath($properties, $property, $value, '_');
        }

        return $properties;
    }

    protected function setPropertyFromPath(
        array &$properties,
        string $property,
        mixed $value,
        string $delimiter = '.'
    ): void {
        $propertiesRef = &$properties;
        $parts = explode($delimiter, $property);

        foreach ($parts as $part) {
            if (!isset($propertiesRef[$part])) {
                $propertiesRef[$part] = [];
            }
            $propertiesRef = &$propertiesRef[$part];
        }

        $propertiesRef = $value;
    }
}