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
use oat\taoLom\model\ontology\LomTaoSchema;
use oat\taoLom\model\schema\general\LomGeneralCoverageMetadata;
use oat\taoLom\model\schema\general\LomGeneralDescriptionMetadata;
use oat\taoLom\model\schema\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\general\LomGeneralKeywordMetadata;
use oat\taoLom\model\schema\general\LomGeneralLanguageMetadata;
use oat\taoLom\model\schema\general\LomGeneralTitleMetadata;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractionException;

class LomGeneralExportExtractor extends LomNodeExportExtractorAbstract
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
     * @throws \InvalidArgumentException
     */
    public function extract($resource)
    {
        if (! $resource instanceof \core_kernel_classes_Resource) {
            throw new MetadataExtractionException(__('The given target is not an instance of core_kernel_classes_Resource'));
        }

        // Adding identifier.
        $id = $resource->getOnePropertyValue($this->getProperty(LomTaoSchema::GENERAL_IDENTIFIER));
        if ($id !== null) {
            $metadata[] = new LomGeneralIdentifierMetadata($resource->getUri(), $id, $this->getLanguageCode());
        }

        // Adding title.
        $title = $resource->getOnePropertyValue($this->getProperty(LomTaoSchema::GENERAL_TITLE));
        if ($title !== null) {
            $metadata[] = new LomGeneralTitleMetadata($resource->getUri(), $title, $this->getLanguageCode());
        }

        // Adding language.
        $language = $resource->getOnePropertyValue($this->getProperty(LomTaoSchema::GENERAL_LANGUAGE));
        if ($language !== null) {
// @todo: which way should we store the language?
            // Language url
            $metadata[] = new LomGeneralLanguageMetadata($resource->getUri(), $language, $this->getLanguageCode());
//            // Language code
//            $metadata[] = new LomGeneralLanguageMetadata(
//                $resource->getUri(),
//                \tao_models_classes_LanguageService::singleton()->getCode($language)
//            );
        }

        // Adding description.
        $description = $resource->getOnePropertyValue($this->getProperty(LomTaoSchema::GENERAL_DESCRIPTION));
        if ($description !== null) {
            $metadata[] = new LomGeneralDescriptionMetadata($resource->getUri(), $description, $this->getLanguageCode());
        }

        // Adding keyword.
        $keyword = $resource->getOnePropertyValue($this->getProperty(LomTaoSchema::GENERAL_KEYWORD));
        if ($keyword !== null) {
            $metadata[] = new LomGeneralKeywordMetadata($resource->getUri(), $keyword, $this->getLanguageCode());
        }

        // Adding coverage.
        $coverage = $resource->getOnePropertyValue($this->getProperty(LomTaoSchema::GENERAL_COVERAGE));
        if ($coverage !== null) {
            $metadata[] = new LomGeneralCoverageMetadata($resource->getUri(), $coverage, $this->getLanguageCode());
        }

        return empty($metadata)
            ? []
            : $metadata;
    }

}