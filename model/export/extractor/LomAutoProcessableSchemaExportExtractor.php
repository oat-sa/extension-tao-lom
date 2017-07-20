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

use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\service\LomSchemaService;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

class LomAutoProcessableSchemaExportExtractor extends LomExportExtractorAbstract
{
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
        $schemaInstances = $schemaService->getAutomaticProcessableSchemaInstances();
        $metadata = [];

        foreach ($schemaInstances as $schemaInstance) {
            $value = $resource->getOnePropertyValue($this->getProperty($schemaInstance->getTaoPath()));
            if ($value !== null) {
                $metadata[] = new SimpleMetadataValue(
                    $resource->getUri(),
                    $schemaInstance->getNodePath(),
                    $value,
                    $this->getLanguageCode($resource)
                );
            }
        }

        return $this->getExtractOutput($resource, $metadata);
    }
}
