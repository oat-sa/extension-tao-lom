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
use oat\oatbox\service\ServiceManager;
use oat\oatbox\service\ServiceManagerAwareTrait;
use oat\oatbox\service\ServiceNotFoundException;
use oat\taoQtiItem\model\qti\metadata\exporter\MetadataExporter;
use oat\taoQtiItem\model\qti\metadata\importer\MetadataImporter;
use oat\taoQtiItem\model\qti\metadata\MetadataService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Class InitMetadataService
 *
 * @package oat\taoQtiItem\scripts\install
 */
class AddLomMetadataServices implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    /**
     * Register metadataService
     *
     * Check if taoQtiItem/metadata_registry config exists
     * If yes, get content of the config
     * Create metadataService with oldConfig or default config & register it
     * Delete old metadataRegistry if exists
     *
     * @param $params
     *
     * @return \common_report_Report
     *
     * @throws \InvalidArgumentException
     * @throws \common_Exception
     * @throws ServiceNotFoundException
     */
    public function __invoke($params = [])
    {
        /** @var MetadataService $metaDataService */
        $metaDataService = ServiceManager::getServiceManager()->get(MetadataService::SERVICE_ID);
        $importer = $metaDataService->getImporter();
        $exporter = $metaDataService->getExporter();

        /** IMPORT */
        // Register ImportInjectors.
        $this->registerServices($importer, $params, MetadataService::IMPORTER_KEY, MetadataImporter::INJECTOR_KEY);
        // Register ImportExtractors.
        $this->registerServices($importer, $params, MetadataService::IMPORTER_KEY, MetadataImporter::EXTRACTOR_KEY);
        // Register ImportGuardians.
        $this->registerServices($importer, $params, MetadataService::IMPORTER_KEY, MetadataImporter::GUARDIAN_KEY);
        // Register ImportClassLookups.
        $this->registerServices($importer, $params, MetadataService::IMPORTER_KEY, MetadataImporter::CLASS_LOOKUP_KEY);

        /** EXPORT */
        // Register ExportInjectors.
        $this->registerServices($exporter, $params, MetadataService::EXPORTER_KEY, MetadataExporter::INJECTOR_KEY);
        // Register ExportExtractors.
        $this->registerServices($exporter, $params, MetadataService::EXPORTER_KEY, MetadataExporter::EXTRACTOR_KEY);

        return \common_report_Report::createSuccess(__('Metadata service successfully registered.'));
    }

    /**
     * @param MetadataImporter|MetadataExporter $service
     * @param array $params
     * @param string $key
     * @param string $subKey
     *
     * @return bool
     */
    private function registerServices($service, $params, $key, $subKey)
    {
        if (!empty($params[$key][$subKey]) && is_array($params[$key][$subKey])) {
            foreach ($params[$key][$subKey] as $classPath) {
                $service->register($subKey, $classPath);
            }
        }
    }
}