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
use oat\taoLom\model\ontology\LomMapperService;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationEntryMetadata;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationSourceMetadata;
use oat\taoQtiItem\model\qti\metadata\imsManifest\ImsManifestMetadataValue;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractor;
use oat\taoQtiItem\model\qti\metadata\MetadataValue;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

class LomClassificationImportExtractor implements MetadataExtractor
{
    /**
     * @see ImsManifestDataExtractor::extract()
     *
     * @param array $values
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \common_Exception
     */
    public function extract($values)
    {
        /** @var LomMapperService $mappingService */
        $mappingService = ServiceManager::getServiceManager()->get(LomMapperService::SERVICE_ID);
        $mapper = $mappingService->getLomGenericMapper();

        $valuesToImport = array();

        foreach ($values as $resourceIdentifier => $metadataValueCollection) {

            /** @var ImsManifestMetadataValue $metadataValue */
            foreach ($metadataValueCollection as $key => $metadataValue) {

                // If metadata is not a source or is empty then skip
                if ($metadataValue->getValue() === '' || $metadataValue->getPath() !== LomClassificationSourceMetadata::getNodeAbsolutePath()) {
                    continue;
                }

                // If next metadata does not exist then skip
                if (!isset($metadataValueCollection[$key + 1])) {
                    continue;
                }

                /** @var MetadataValue $entryMetadata */
                $entryMetadata = $metadataValueCollection[$key + 1];

                // Handle metadata if it is an entry and is not empty
                if ($entryMetadata->getPath() === LomClassificationEntryMetadata::getNodeAbsolutePath() && $entryMetadata->getValue() !== '') {
                    $valuesToImport[$resourceIdentifier][] = new SimpleMetadataValue(
                        $resourceIdentifier,
                        array($mapper->getLomPath(), $metadataValue->getValue()),
                        $entryMetadata->getValue()
                    );
                }
            }
        }

        return $valuesToImport;
    }

}





