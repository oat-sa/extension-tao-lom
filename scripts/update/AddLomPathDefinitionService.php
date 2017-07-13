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

namespace oat\taoLom\scripts\update;

use oat\oatbox\action\Action;
use oat\oatbox\service\ServiceManagerAwareTrait;
use oat\taoLom\model\ontology\interfaces\LomGenericPathDefinitionInterface;
use oat\taoLom\model\ontology\interfaces\LomTaoPathDefinitionInterface;
use oat\taoLom\model\service\LomPathDefinitionService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Class AddLomPathDefinitionServices
 *
 * @package oat\taoQtiItem\scripts\install
 */
class AddLomPathDefinitionService implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    /**
     * Register pathDefinitionService
     *
     * Check if taoLom/lom_path_definition_services config exists
     * If yes, get content of the config
     * Create pathDefinitionService with oldConfig or config from params & register it
     * Delete old config if exists
     *
     * @param $params
     *
     * @return \common_report_Report
     *
     * @throws \common_ext_ExtensionException
     */
    public function __invoke($params = [])
    {
        $pathDefinitionConfig = [];
        $extension = \common_ext_ExtensionsManager::singleton()
            ->getExtensionById(LomPathDefinitionService::SERVICE_CONFIG_FILE_PATH);

        // Loading the old config.
        if ($extension->hasConfig(LomPathDefinitionService::SERVICE_CONFIG_FILE_NAME)
        ) {
            /** @var LomPathDefinitionService $pathDefinitionService */
            $pathDefinitionService = $extension->getConfig(LomPathDefinitionService::SERVICE_CONFIG_FILE_NAME);
            $pathDefinitionConfig = $pathDefinitionService->getOptions();
        }
        $originalPathDefinitionConfig = $pathDefinitionConfig;

        // Setting the new lom tao path definition class.
        if (empty($pathDefinitionConfig[LomPathDefinitionService::LOM_TAO_PATH_DEFINITION_KEY]) &&
            !empty($params[LomPathDefinitionService::LOM_TAO_PATH_DEFINITION_KEY]) &&
            is_a($params[LomPathDefinitionService::LOM_TAO_PATH_DEFINITION_KEY], LomTaoPathDefinitionInterface::class, true)
        ) {
            $pathDefinitionConfig[LomPathDefinitionService::LOM_TAO_PATH_DEFINITION_KEY] = $params[LomPathDefinitionService::LOM_TAO_PATH_DEFINITION_KEY];
        }

        // Setting the new lom generic path definition class.
        if (empty($pathDefinitionConfig[LomPathDefinitionService::LOM_GENERIC_PATH_DEFINITION_KEY]) &&
            !empty($params[LomPathDefinitionService::LOM_GENERIC_PATH_DEFINITION_KEY]) &&
            is_a($params[LomPathDefinitionService::LOM_GENERIC_PATH_DEFINITION_KEY], LomGenericPathDefinitionInterface::class, true)
        ) {
            $pathDefinitionConfig[LomPathDefinitionService::LOM_GENERIC_PATH_DEFINITION_KEY] = $params[LomPathDefinitionService::LOM_GENERIC_PATH_DEFINITION_KEY];
        }

        // If there is a modification we change the config.
        if ($originalPathDefinitionConfig !== $pathDefinitionConfig) {
            // Remove the old config.
            if ($extension->hasConfig(LomPathDefinitionService::SERVICE_CONFIG_FILE_NAME)) {
                $extension->unsetConfig(LomPathDefinitionService::SERVICE_CONFIG_FILE_NAME);
            }

            // Register the new service.
            $pathDefinitionService = $this->getServiceLocator()->build(LomPathDefinitionService::class, $pathDefinitionConfig);
            $this->getServiceLocator()->register(LomPathDefinitionService::SERVICE_ID, $pathDefinitionService);

            return \common_report_Report::createSuccess(__('LomPathDefinition service successfully registered.'));
        }

        return \common_report_Report::createSuccess(__('LomPathDefinition service already registered.'));
    }
}