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
use oat\taoLom\model\schema\LomMetadataInterface;
use oat\taoLom\model\schema\LomSchemaService;
use oat\taoQtiItem\model\qti\metadata\imsManifest\ImsManifestMetadataValue;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractor;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

class LomGeneralImportExtractor implements MetadataExtractor
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
     * @throws \common_exception_NotFound
     */
    public function extract($values)
    {
        /** @var LomSchemaService $schemaService */
        $schemaService  = ServiceManager::getServiceManager()->get(LomSchemaService::SERVICE_ID);
        $generalSchema  = $schemaService->getLomGeneralSchema();
        $valuesToImport = array();

        foreach ($values as $resourceIdentifier => $metadataValueCollection) {
            /** @var ImsManifestMetadataValue $metadataValue */
            foreach ($metadataValueCollection as $key => $metadataValue) {
                /** @var LomMetadataInterface $current */
                $path = '';
                foreach ($generalSchema as $current) {
                    if ($metadataValue->getPath() === $current->getNodeAbsolutePath()) {
                        $path = $current->getTaoPath();
                        break;
                    }
                }

                if (!empty($path)) {
                    $valuesToImport[$resourceIdentifier][] = new SimpleMetadataValue(
                        $resourceIdentifier,
                        [$path],
                        $metadataValue->getValue()
                    );
                }
            }
        }

        return $valuesToImport;
    }
}
