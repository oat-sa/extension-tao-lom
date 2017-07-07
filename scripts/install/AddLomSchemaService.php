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
use oat\taoLom\model\schema\LomSchemaService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Class InitMetadataService
 *
 * @package oat\taoQtiItem\scripts\install
 */
class AddLomSchemaService implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    /**
     * Register schemaService
     *
     * Check if taoLom/lom_schema_services config exists
     * If yes, get content of the config
     * Delete old metadataRegistry if exists
     * Create schemaService with oldConfig or config from params & register it
     *
     * @param $params
     *
     * @return \common_report_Report
     *
     * @throws \common_ext_ExtensionException
     */
    public function __invoke($params = [])
    {
        $schemaConfig = [];
        $extension = \common_ext_ExtensionsManager::singleton()
            ->getExtensionById(LomSchemaService::SERVICE_CONFIG_FILE_PATH);

        // Loading the old config.
        if ($extension->hasConfig(LomSchemaService::SERVICE_CONFIG_FILE_NAME)
        ) {
            /** @var LomSchemaService $schemaService */
            $schemaService = $extension->getConfig(LomSchemaService::SERVICE_CONFIG_FILE_NAME);
            $schemaConfig = $schemaService->getOptions();
        }
        $originalSchemaConfig = $schemaConfig;

        // Setting the new lom schema classes.
        foreach ($params as $offset => $classes) {
            if (is_array($classes) && LomSchemaService::isValidOffset($offset)) {
                if (empty($schemaConfig[$offset]) || !is_array($schemaConfig[$offset])) {
                    $schemaConfig[$offset] = [];
                }

                foreach ($classes as $class) {
                    if (!in_array($class, $schemaConfig[$offset], true)) {
                        $schemaConfig[$offset][] = $class;
                    }
                }
            }
        }

        // If there is a modification we change the config.
        if ($originalSchemaConfig !== $schemaConfig) {
            // Remove the old config.
            if ($extension->hasConfig(LomSchemaService::SERVICE_CONFIG_FILE_NAME)) {
                $extension->unsetConfig(LomSchemaService::SERVICE_CONFIG_FILE_NAME);
            }

            // Register the new service.
            $schemaService = $this->getServiceLocator()->build(LomSchemaService::class, $schemaConfig);
            $this->getServiceLocator()->register(LomSchemaService::SERVICE_ID, $schemaService);

            return \common_report_Report::createSuccess(__('Lom Schema service successfully registered.'));
        }

        return \common_report_Report::createSuccess(__('Lom Schema service already registered.'));
    }
}