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
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationEntrySchema;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationSourceSchema;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralCoverageSchema;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralDescriptionSchema;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralIdentifierSchema;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralKeywordSchema;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralLanguageSchema;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralTitleSchema;
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
                LomGeneralIdentifierSchema::class,
                LomGeneralTitleSchema::class,
                LomGeneralLanguageSchema::class,
                LomGeneralDescriptionSchema::class,
                LomGeneralKeywordSchema::class,
                LomGeneralCoverageSchema::class,
            ],
            LomSchemaService::CUSTOM_PROCESSABLE_INSTANCES => [
                LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_SOURCE => LomClassificationSourceSchema::class,
                LomSchemaServiceKeys::SCHEMA_CLASSIFICATION_ENTRY  => LomClassificationEntrySchema::class,
            ],
        ]);
    }
}