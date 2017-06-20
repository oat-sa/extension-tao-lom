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
use oat\taoLom\model\schema\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\general\LomGeneralTitleMetadata;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationMetadataValue;
use oat\taoLom\model\schema\classification\LomClassificationSourceMetadata;
use oat\taoLom\model\schema\classification\LomClassificationEntryMetadata;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractor;

class LomGeneralExportExtractor implements MetadataExtractor
{
    use OntologyAwareTrait;

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

        // Adding identifier.
        $id = $resource->getOnePropertyValue($this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-identifier'));
        if ($id !== null) {
            $metadata[] = new LomGeneralIdentifierMetadata($resource->getUri(), $id);
        }

        // Adding title.
        $title = $resource->getOnePropertyValue($this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-title'));
        if ($title !== null) {
            $metadata[] = new LomGeneralTitleMetadata($resource->getUri(), $title);
        }

        // Adding title.
        $title = $resource->getOnePropertyValue($this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-title'));
        if ($title !== null) {
            $metadata[] = new LomGeneralTitleMetadata($resource->getUri(), $title);
        }

        return empty($metadata)
            ? []
            : $metadata;
    }

}