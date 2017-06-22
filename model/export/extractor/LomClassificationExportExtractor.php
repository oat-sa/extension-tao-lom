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

namespace oat\taoLom\model\export\extractor;

use oat\generis\model\OntologyAwareTrait;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationMetadataValue;
use oat\taoLom\model\schema\classification\LomClassificationSourceMetadata;
use oat\taoLom\model\schema\classification\LomClassificationEntryMetadata;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;

class LomClassificationExportExtractor extends LomNodeExportExtractorAbstract
{
    use OntologyAwareTrait;

    public static $excludedProperties = [
        RDF_TYPE,
        RDFS_LABEL,
        \taoItems_models_classes_ItemsService::PROPERTY_ITEM_CONTENT,
        \taoItems_models_classes_ItemsService::PROPERTY_ITEM_MODEL,
        \taoTests_models_classes_TestsService::PROPERTY_TEST_TESTMODEL,
        \taoTests_models_classes_TestsService::TEST_TESTCONTENT_PROP,
    ];

    /**
     * Extract resource metadata and transform it to ClassificationMetadataValue
     *
     * @param \core_kernel_classes_Resource $resource
     *
     * @return array
     *
     * @throws MetadataExtractionException
     */
    public function extract($resource)
    {
        if (! $resource instanceof \core_kernel_classes_Resource) {
            throw new MetadataExtractionException(__('The given target is not an instance of core_kernel_classes_Resource'));
        }

        $triples = $resource->getRdfTriples();

        /** @var \core_kernel_classes_Triple $triple */
        foreach ($triples->getIterator() as $triple) {

            /** @var \core_kernel_classes_Resource $property */
            $property = $this->getResource($triple->predicate);
            $value = $triple->object;

            if (! empty($value) && $property->isProperty() && ! in_array($property->getUri(), self::$excludedProperties)) {
                $metadata[] = new ClassificationMetadataValue(
                    new LomClassificationSourceMetadata($resource->getUri(), $property->getUri(), $this->getLanguageCode()),
                    [new LomClassificationEntryMetadata($resource->getUri(), $value, $this->getLanguageCode())]
                );
            }
        }

        return empty($metadata)
            ? []
            : $metadata;
    }

}