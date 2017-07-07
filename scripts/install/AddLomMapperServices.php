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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA;
 *
 */

namespace oat\taoLom\scripts\install;

use oat\oatbox\action\Action;
use oat\oatbox\service\ServiceManagerAwareTrait;
use oat\taoLom\model\mapper\interfaces\LomGenericMapperInterface;
use oat\taoLom\model\mapper\interfaces\LomTaoMapperInterface;
use oat\taoLom\model\ontology\LomMapperService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Class InitMetadataService
 *
 * @package oat\taoQtiItem\scripts\install
 */
class AddLomMapperServices implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    /**
     * Register mapperService
     *
     * Check if taoLom/lom_mapper_services config exists
     * If yes, get content of the config
     * Create mapperService with oldConfig or config from params & register it
     * Delete old metadataRegistry if exists
     *
     * @param $params
     *
     * @return \common_report_Report
     *
     * @throws \common_ext_ExtensionException
     */
    public function __invoke($params = [])
    {
        $mapperConfig = [];
        $extension = \common_ext_ExtensionsManager::singleton()
            ->getExtensionById(LomMapperService::SERVICE_CONFIG_FILE_PATH);

        // Loading the old config.
        if ($extension->hasConfig(LomMapperService::SERVICE_CONFIG_FILE_NAME)
        ) {
            /** @var LomMapperService $mapperService */
            $mapperService = $extension->getConfig(LomMapperService::SERVICE_CONFIG_FILE_NAME);
            $mapperConfig = $mapperService->getOptions();
        }
        $originalMapperConfig = $mapperConfig;

        // Setting the new lom tao mapper class.
        if (empty($mapperConfig[LomMapperService::LOM_TAO_MAPPER_KEY]) &&
            !empty($params[LomMapperService::LOM_TAO_MAPPER_KEY]) &&
            is_a($params[LomMapperService::LOM_TAO_MAPPER_KEY], LomTaoMapperInterface::class, true)
        ) {
            $mapperConfig[LomMapperService::LOM_TAO_MAPPER_KEY] = $params[LomMapperService::LOM_TAO_MAPPER_KEY];
        }

        // Setting the new lom generic mapper class.
        if (empty($mapperConfig[LomMapperService::LOM_GENERIC_MAPPER_KEY]) &&
            !empty($params[LomMapperService::LOM_GENERIC_MAPPER_KEY]) &&
            is_a($params[LomMapperService::LOM_GENERIC_MAPPER_KEY], LomGenericMapperInterface::class, true)
        ) {
            $mapperConfig[LomMapperService::LOM_GENERIC_MAPPER_KEY] = $params[LomMapperService::LOM_GENERIC_MAPPER_KEY];
        }

        // If there is a modification we change the config.
        if ($originalMapperConfig !== $mapperConfig) {
            // Remove the old config.
            if ($extension->hasConfig(LomMapperService::SERVICE_CONFIG_FILE_NAME)) {
                $extension->unsetConfig(LomMapperService::SERVICE_CONFIG_FILE_NAME);
            }

            // Register the new service.
            $mapperService = $this->getServiceLocator()->build(LomMapperService::class, $mapperConfig);
            $this->getServiceLocator()->register(LomMapperService::SERVICE_ID, $mapperService);

            return \common_report_Report::createSuccess(__('Lom Mapper service successfully registered.'));
        }

        return \common_report_Report::createSuccess(__('Lom Mapper service already registered.'));
    }
}