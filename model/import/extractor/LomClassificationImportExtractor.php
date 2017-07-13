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

namespace oat\taoLom\model\import\extractor;

use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\service\LomPathDefinitionService;
use oat\taoLom\model\schema\imsglobal\LomSchemaServiceKeys;
use oat\taoLom\model\service\LomSchemaService;
use oat\taoQtiItem\model\qti\metadata\imsManifest\ImsManifestMetadataExtractor;
use oat\taoQtiItem\model\qti\metadata\imsManifest\ImsManifestMetadataValue;
use oat\taoQtiItem\model\qti\metadata\MetadataValue;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

class LomClassificationImportExtractor extends ImsManifestMetadataExtractor
{
    /**
     * @see ImsManifestDataExtractor::extract()
     *
     * @param mixed $manifest
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \common_Exception
     * @throws \common_exception_NotFound
     */
    public function extract($manifest)
    {
        $values = parent::extract($manifest);

        /** @var LomPathDefinitionService $pathDefinitionService */
        $pathDefinitionService = ServiceManager::getServiceManager()->get(LomPathDefinitionService::SERVICE_ID);
        $genericPathDefinition = $pathDefinitionService->getLomGenericPathDefinition();

        /** @var LomSchemaService $schemaService */
        $schemaService  = ServiceManager::getServiceManager()->get(LomSchemaService::SERVICE_ID);
        $schemaInstances = $schemaService->getCustomProcessableSchemaInstances();

        if (empty($schemaInstances[LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_SOURCE]) ||
            empty($schemaInstances[LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_ENTRY])
        ) {
            throw new \common_exception_NotFound(__('The necessary LOM classification schema instances are missing!'));
        }

        $sourceSchema = $schemaInstances[LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_SOURCE];
        $entrySchema = $schemaInstances[LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_ENTRY];

        $valuesToImport = array();

        foreach ($values as $resourceIdentifier => $metadataValueCollection) {
            /** @var ImsManifestMetadataValue $metadataValue */
            foreach ((array)$metadataValueCollection as $key => $metadataValue) {
                // If metadata is not a source or is empty then skip
                if ($metadataValue->getValue() === '' || $metadataValue->getPath() !== $sourceSchema->getNodeAbsolutePath()) {
                    continue;
                }

                // If next metadata does not exist then skip
                if (!isset($metadataValueCollection[$key + 1])) {
                    continue;
                }

                /** @var MetadataValue $entryMetadata */
                $entryMetadata = $metadataValueCollection[$key + 1];

                // Handle metadata if it is an entry and is not empty
                if (
                    $entryMetadata->getValue() !== '' &&
                    $entryMetadata->getPath() === $entrySchema->getNodeAbsolutePath()
                ) {
                    $valuesToImport[$resourceIdentifier][] = new SimpleMetadataValue(
                        $resourceIdentifier,
                        array($genericPathDefinition->getLomPath(), $metadataValue->getValue()),
                        $entryMetadata->getValue()
                    );
                }
            }
        }

        return $valuesToImport;
    }

}





