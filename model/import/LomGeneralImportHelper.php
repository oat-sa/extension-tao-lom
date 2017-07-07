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

namespace oat\taoLom\model\import;

use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\ontology\LomMapperService;
use oat\taoLom\model\schema\general\LomGeneralCoverageMetadata;
use oat\taoLom\model\schema\general\LomGeneralDescriptionMetadata;
use oat\taoLom\model\schema\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\general\LomGeneralKeywordMetadata;
use oat\taoLom\model\schema\general\LomGeneralLanguageMetadata;
use oat\taoLom\model\schema\general\LomGeneralTitleMetadata;
use oat\taoQtiItem\model\qti\metadata\MetadataValue;

class LomGeneralImportHelper
{
    /**
     * Returns the given metadata's TAO specific mapping.
     *
     * @param MetadataValue $metaData
     *
     * @return string   The mapped property url.
     *
     * @throws \common_Exception
     */
    public static function getMappedUrl($metaData)
    {
        /** @var LomMapperService $mappingService */
        $mappingService = ServiceManager::getServiceManager()->get(LomMapperService::SERVICE_ID);
        $taoMapper = $mappingService->getLomTaoMapper();

        switch ($metaData->getPath()) {
            case LomGeneralIdentifierMetadata::getNodeAbsolutePath():
                return $taoMapper->getGeneralIdentifier();
                break;
            case LomGeneralTitleMetadata::getNodeAbsolutePath():
                return $taoMapper->getGeneralTitle();
                break;
            case LomGeneralLanguageMetadata::getNodeAbsolutePath():
                return $taoMapper->getGeneralLanguage();
                break;
            case LomGeneralDescriptionMetadata::getNodeAbsolutePath():
                return $taoMapper->getGeneralDescription();
                break;
            case LomGeneralKeywordMetadata::getNodeAbsolutePath():
                return $taoMapper->getGeneralKeyWord();
                break;
            case LomGeneralCoverageMetadata::getNodeAbsolutePath():
                return $taoMapper->getGeneralCoverage();
                break;
            default:
                return '';
        }
    }
}





