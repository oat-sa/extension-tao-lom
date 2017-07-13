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
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA;
 *
 *
 */

namespace oat\taoLom\scripts\install;


use oat\oatbox\action\Action;
use oat\oatbox\service\ServiceManagerAwareTrait;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationEntryMetadata;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationSourceMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralCoverageMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralDescriptionMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralKeywordMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralLanguageMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralTitleMetadata;
use oat\taoLom\model\schema\imsglobal\LomSchemaServiceKeys;
use oat\taoLom\model\service\LomSchemaService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class InstallLomSchemaService implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    public function __invoke($params)
    {
        $lomSchemaService = new AddLomSchemaService();
        $lomSchemaService->setServiceLocator($this->getServiceManager());

        return $lomSchemaService([
            LomSchemaService::AUTOMATIC_PROCESSABLE_INSTANCES => [
                LomGeneralIdentifierMetadata::class,
                LomGeneralTitleMetadata::class,
                LomGeneralLanguageMetadata::class,
                LomGeneralDescriptionMetadata::class,
                LomGeneralKeywordMetadata::class,
                LomGeneralCoverageMetadata::class,
            ],
            LomSchemaService::CUSTOM_PROCESSABLE_INSTANCES => [
                LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_SOURCE => LomClassificationSourceMetadata::class,
                LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_ENTRY  => LomClassificationEntryMetadata::class,
            ],
        ]);
    }
}