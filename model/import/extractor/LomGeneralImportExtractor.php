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

use oat\taoLom\model\ontology\LomTaoSchema;
use oat\taoLom\model\schema\general\LomGeneralCoverageMetadata;
use oat\taoLom\model\schema\general\LomGeneralDescriptionMetadata;
use oat\taoLom\model\schema\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\general\LomGeneralKeywordMetadata;
use oat\taoLom\model\schema\general\LomGeneralLanguageMetadata;
use oat\taoLom\model\schema\general\LomGeneralTitleMetadata;
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
     */
    public function extract($values)
    {
        $valuesToImport = array();

        foreach ($values as $resourceIdentifier => $metadataValueCollection) {

            /** @var ImsManifestMetadataValue $metadataValue */
            foreach ($metadataValueCollection as $key => $metadataValue) {
                switch ($metadataValue->getPath()) {
                    case LomGeneralIdentifierMetadata::getNodeAbsolutePath():
                        $path = LomTaoSchema::GENERAL_IDENTIFIER;
                        break;
                    case LomGeneralTitleMetadata::getNodeAbsolutePath():
                        $path = LomTaoSchema::GENERAL_TITLE;
                        break;
                    case LomGeneralLanguageMetadata::getNodeAbsolutePath():
                        $path = LomTaoSchema::GENERAL_LANGUAGE;
                        break;
                    case LomGeneralDescriptionMetadata::getNodeAbsolutePath():
                        $path = LomTaoSchema::GENERAL_DESCRIPTION;
                        break;
                    case LomGeneralKeywordMetadata::getNodeAbsolutePath():
                        $path = LomTaoSchema::GENERAL_KEYWORD;
                        break;
                    case LomGeneralCoverageMetadata::getNodeAbsolutePath():
                        $path = LomTaoSchema::GENERAL_COVERAGE;
                        break;
                    default:
                        $path = '';
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





