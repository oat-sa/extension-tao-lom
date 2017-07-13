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
use oat\taoLom\model\export\extractor\LomAutoProcessableSchemaExportExtractor;
use oat\taoLom\model\export\extractor\LomClassificationExportExtractor;
use oat\taoLom\model\export\injector\LomExportInjector;
use oat\taoLom\model\import\extractor\LomAutoProcessableSchemaImportExtractor;
use oat\taoLom\model\import\extractor\LomClassificationImportExtractor;
use oat\taoLom\model\import\guardian\LomGeneralIdentifierImportGuardian;
use oat\taoLom\model\import\injector\LomImportInjector;
use oat\taoLom\scripts\update\AddLomMetadataService;
use oat\taoQtiItem\model\qti\metadata\exporter\MetadataExporter;
use oat\taoQtiItem\model\qti\metadata\importer\MetadataImporter;
use oat\taoQtiItem\model\qti\metadata\MetadataService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class InstallLomMetadataService implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    public function __invoke($params)
    {
        $lomMetadataServices = new AddLomMetadataService();
        $lomMetadataServices->setServiceLocator($this->getServiceManager());

        return $lomMetadataServices([
            MetadataService::IMPORTER_KEY => [
                MetadataImporter::INJECTOR_KEY => [
                    LomImportInjector::class,
                ],
                MetadataImporter::EXTRACTOR_KEY => [
                    LomAutoProcessableSchemaImportExtractor::class,
                    LomClassificationImportExtractor::class,
                ],
                MetadataImporter::GUARDIAN_KEY => [
                    LomGeneralIdentifierImportGuardian::class,
                ],
            ],
            MetadataService::EXPORTER_KEY => [
                MetadataExporter::INJECTOR_KEY => [
                    LomExportInjector::class,
                ],
                MetadataExporter::EXTRACTOR_KEY => [
                    LomAutoProcessableSchemaExportExtractor::class,
                    LomClassificationExportExtractor::class,
                ],
            ],
        ]);
    }
}