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
use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationEntryMetadata;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationSourceMetadata;
use oat\taoLom\model\schema\imsglobal\LomSchemaServiceKeys;
use oat\taoLom\model\service\LomSchemaService;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;
use oat\taoQtiItem\model\qti\metadata\simple\NestedMetadataValue;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

class LomClassificationExportExtractor extends LomExportExtractorAbstract
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
     * @throws \InvalidArgumentException
     * @throws \common_Exception
     * @throws \common_exception_NotFound
     */
    public function extract($resource)
    {
        if (! $resource instanceof \core_kernel_classes_Resource) {
            throw new MetadataExtractionException(__('The given target is not an instance of core_kernel_classes_Resource'));
        }

        /** @var LomSchemaService $schemaService */
        $schemaService  = ServiceManager::getServiceManager()->get(LomSchemaService::SERVICE_ID);
        $schemaInstances = $schemaService->getCustomProcessableSchemaInstances();
        /** @var LomClassificationSourceMetadata $sourceSchema */
        $sourceSchema = $schemaInstances[LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_SOURCE];
        /** @var LomClassificationEntryMetadata $entrySchema */
        $entrySchema = $schemaInstances[LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_ENTRY];
        $metadata = [];

        $triples = $resource->getRdfTriples();
        /** @var \core_kernel_classes_Triple $triple */
        foreach ($triples->getIterator() as $triple) {
            /** @var \core_kernel_classes_Resource $property */
            $property = $this->getResource($triple->predicate);
            $value = $triple->object;

            if (!empty($value) && $property->isProperty() && ! in_array($property->getUri(), self::$excludedProperties)) {
                $metadata[] = new NestedMetadataValue(
                    $resource->getUri(),
                    $sourceSchema->getNodeRelativePath(),
                    $property->getUri(),
                    $this->getLanguageCode($resource),
                    $sourceSchema->getBaseNodePath(),
                    [
                        new SimpleMetadataValue(
                            $resource->getUri(),
                            $entrySchema->getNodeRelativePath(),
                            $value,
                            $this->getLanguageCode($resource)
                        ),
                    ]
                );
            }
        }

        return $this->getExtractOutput($resource, $metadata);
    }
}
