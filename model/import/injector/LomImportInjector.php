<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 */

namespace oat\taoLom\model\import\injector;

use oat\generis\model\OntologyAwareTrait;
use oat\taoLom\model\export\extractor\LomClassificationExportExtractor;
use oat\taoQtiItem\model\qti\metadata\MetadataInjectionException;
use oat\taoQtiItem\model\qti\metadata\MetadataInjector;
use oat\taoQtiItem\model\qti\metadata\MetadataValue;

class LomImportInjector implements MetadataInjector
{
    use OntologyAwareTrait;

    /**
     * Inject dynamically a metadata to an item property
     *
     * @param mixed $target
     * @param array $values
     * @throws MetadataInjectionException
     */
    public function inject($target, array $values)
    {
        if (!$target instanceof \core_kernel_classes_Resource) {
            throw new MetadataInjectionException('The given target is not an instance of core_kernel_classes_Resource.');
        }

        /** @var \core_kernel_classes_Class $targetClass */
        $types = $target->getTypes();
        $targetClass = reset($types);
        $classProperties = $targetClass->getProperties(true);

        $properties = [];
        /** @var \core_kernel_classes_Property $property */
        foreach ($classProperties as $property) {
            $properties[] = $property->getUri();
        }

        // Removing excluded properties.
        $properties = array_diff($properties, LomClassificationExportExtractor::$excludedProperties);

        foreach ($values as $metadataValues) {
            /** @var MetadataValue $metadataValue */
            foreach ((array)$metadataValues as $metadataValue) {
                $lang = $metadataValue->getLanguage() ?: DEFAULT_LANG;
                $path = $metadataValue->getPath();
                $valuePath = end($path);
                if (in_array($valuePath, $properties, true)) {
                    $target->setPropertyValueByLg($this->getProperty($valuePath), $metadataValue->getValue(), $lang);
                }
            }
        }
    }
}
