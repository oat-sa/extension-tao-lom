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
use oat\taoLom\model\ontology\LomTaoMetaData;
use oat\taoLom\model\schema\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\general\LomClassificationMetadataTrait;
use oat\taoLom\model\schema\general\LomGeneralTitleMetadata;
use oat\taoLom\model\schema\LomMetadataGroup;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\LomClassificationEntryMetadata;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationMetadataValue;
use oat\taoQtiItem\model\qti\metadata\imsManifest\classificationMetadata\ClassificationSourceMetadataValue;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractor;

class LomExportExtractor implements MetadataExtractor
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

        \common_Logger::d(
            var_export(
                $resource
                , true
            )
        );

        $identifier = \tao_helpers_Uri::getUniqueId($resource->getUri());
        $metadata = array($identifier => []);

        // Defining the language for the export.
        $language = $resource->getOnePropertyValue($this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-language'));
        $languageCode = \tao_helpers_translation_Utils::getDefaultLanguage();
        if ($language !== null) {
            $languageCode = \tao_models_classes_LanguageService::singleton()->getCode($language);
        }

        // Exporting general metadata.
        $generalExtractor = new LomGeneralExportExtractor($languageCode);
        $metadata[$identifier] = array_merge(
            $metadata[$identifier],
            $generalExtractor->extract($resource)
        );

        // Exporting classification metadata.
        $classificationExtractor = new LomClassificationExportExtractor($languageCode);
        $metadata[$identifier] = array_merge(
            $metadata[$identifier],
            $classificationExtractor->extract($resource)
        );

        return empty($metadata[$identifier])
            ? []
            : $metadata;
    }

}