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
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA
 *
 */

namespace oat\taoLom\model\export\extractor;

use oat\generis\model\OntologyAwareTrait;
use oat\taoLom\model\ontology\TestMetaData;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationEntryMetadataValue;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationMetadataValue;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationSourceMetadataValue;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractor;

class NccerTestCategoryExtractor implements MetadataExtractor
{
    use OntologyAwareTrait;

    /**
     * Extract resource metadata and transform it to ClassificationMetadataValue
     *
     * @param \core_kernel_classes_Resource $resource
     * @return array
     * @throws MetadataExtractionException
     */
    public function extract($resource)
    {
        if (! $resource instanceof \core_kernel_classes_Resource) {
            throw new MetadataExtractionException(__('The given target is not an instance of core_kernel_classes_Resource'));
        }

        $identifier = \tao_helpers_Uri::getUniqueId($resource->getUri());
        $metadata = array($identifier => []);

        /** @var \core_kernel_classes_Resource $category */
        $category = $resource->getOnePropertyValue($this->getProperty(TestMetaData::PROPERTY_NCCER_TEST_CATEGORY));
        if (! is_null($category) && ! $category instanceof \core_kernel_classes_Literal) {
            $metadata[$identifier][] = new ClassificationMetadataValue(
                new ClassificationSourceMetadataValue($resource->getUri(), 'Test Category'),
                [
                    new ClassificationEntryMetadataValue($resource->getUri(), $category->getLabel()),
                ]
            );
        }

        /** @var \core_kernel_classes_Resource $profile */
        $profile = $resource->getOnePropertyValue($this->getProperty(TestMetaData::PROPERTY_NCCER_TEST_PROFILE));
        if (! is_null($profile) && ! $profile instanceof \core_kernel_classes_Literal) {
            $metadata[$identifier][] = new ClassificationMetadataValue(
                new ClassificationSourceMetadataValue($resource->getUri(), 'Profile'),
                [
                    new ClassificationEntryMetadataValue($resource->getUri(), $profile->getLabel()),
                ]
            );
        }

        /** @var \core_kernel_classes_Literal $moduleNumber */
        $moduleNumber = $resource->getOnePropertyValue($this->getProperty(TestMetaData::PROPERTY_NCCER_TEST_MODULE_NUMBER));
        if (! is_null($moduleNumber)) {
            $metadata[$identifier][] = new ClassificationMetadataValue(
                new ClassificationSourceMetadataValue($resource->getUri(), 'Module Number'),
                [
                    new ClassificationEntryMetadataValue($resource->getUri(), $moduleNumber->literal),
                ]
            );
        }

\common_Logger::d(
    var_export(
        $this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-identifier')->getRdfTriples()
        , true
    )
);

        /** @var \core_kernel_classes_Resource $profile */
        $profile = $resource->getOnePropertyValue($this->getProperty('http://clean.dev#i1497437397380667'));
        if (! is_null($profile)) {
            $metadata[$identifier][] = new ClassificationMetadataValue(
                new ClassificationSourceMetadataValue($resource->getUri(), 'GeneralIdentifier'),
                [
                    new ClassificationEntryMetadataValue($resource->getUri(), $profile->literal),
                ]
            );
        }

        \common_Logger::d(
            var_export(
                $metadata
                , true
            )
        );

        if (empty($metadata[$identifier])) {
            return [];
        }

        return $metadata;
    }

}