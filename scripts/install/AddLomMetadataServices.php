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
use oat\oatbox\extension\InstallAction;
use oat\oatbox\service\ServiceManager;
use oat\oatbox\service\ServiceManagerAwareTrait;
use oat\taoLom\model\export\extractor\LomExportExtractor;
use oat\taoLom\model\export\injector\LomExportInjector;
use oat\taoLom\model\import\extractor\LomImportExtractor;
use oat\taoLom\model\import\injector\LomImportInjector;
use oat\taoQtiItem\model\qti\metadata\exporter\MetadataExporter;
use oat\taoQtiItem\model\qti\metadata\importer\MetadataImporter;
use oat\taoQtiItem\model\qti\metadata\MetadataService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class InitMetadataService
 *
 * @package oat\taoQtiItem\scripts\install
 */
class AddLomMetadataServices implements Action, ServiceLocatorAwareInterface
{
    /**
     * Register metadataService
     *
     * Check if taoQtiItem/metadata_registry config exists
     * If yes, get content of the config
     * Create metadataService with oldConfig or default config & register it
     * Delete old metadataRegistry if exists
     *
     * @param $params
     * @return \common_report_Report
     */
    public function __invoke($params = [])
    {
        $metaDataService = ServiceManager::getServiceManager()->get(MetadataService::SERVICE_ID);
        $importer = $metaDataService->getImporter();
        $exporter = $metaDataService->getExporter();

        // Register ImportInjectors.
        $importer->register(
            MetadataImporter::INJECTOR_KEY,
            LomImportInjector::class
        );

        // Register ImportExtractors.
        $importer->register(
            MetadataImporter::EXTRACTOR_KEY,
            LomImportExtractor::class
        );

        // Register ExportInjectors.
        $exporter->register(
            MetadataExporter::INJECTOR_KEY,
            LomExportInjector::class
        );

        // Register ExportExtractors.
        $exporter->register(
            MetadataExporter::EXTRACTOR_KEY,
            LomExportExtractor::class
        );

        return \common_report_Report::createSuccess(__('Metadata service successfully registered.'));
    }
}