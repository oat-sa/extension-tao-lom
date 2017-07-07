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

use oat\tao\scripts\update\OntologyUpdater;
use oat\taoLom\model\export\extractor\LomExportExtractor;
use oat\taoLom\model\export\injector\LomExportInjector;
use oat\taoLom\model\import\extractor\LomAutomaticProcessableSchemaImportExtractor;
use oat\taoLom\model\import\extractor\LomClassificationImportExtractor;
use oat\taoLom\model\import\extractor\LomImportExtractor;
use oat\taoLom\model\import\guardian\LomGeneralImportGuardian;
use oat\taoLom\model\import\injector\LomImportInjector;
use oat\taoLom\model\mapper\LomGenericMapper;
use oat\taoLom\model\mapper\LomTaoMapper;
use oat\taoLom\model\ontology\LomMapperService;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationEntryMetadata;
use oat\taoLom\model\schema\imsglobal\classification\LomClassificationSourceMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralCoverageMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralDescriptionMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralIdentifierMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralKeywordMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralLanguageMetadata;
use oat\taoLom\model\schema\imsglobal\general\LomGeneralTitleMetadata;
use oat\taoLom\model\schema\LomSchemaService;
use oat\taoLom\scripts\install\AddLomMapperServices;
use oat\taoLom\scripts\install\AddLomMetadataServices;
use oat\taoLom\scripts\install\AddLomSchemaService;
use oat\taoLom\scripts\install\AddMetadataExtractors;
use oat\taoLom\scripts\install\AddMetadataInjectors;
use oat\taoQtiItem\model\qti\metadata\exporter\MetadataExporter;
use oat\taoQtiItem\model\qti\metadata\importer\MetadataImporter;
use oat\taoQtiItem\model\qti\metadata\MetadataService;

class Updater extends \common_ext_ExtensionUpdater
{
    public function update($initialVersion)
    {
        $this->setVersion('0.0.1');

        if ($this->isVersion('0.0.1')) {
            OntologyUpdater::syncModels();
            $this->setVersion('0.1.0');
        }
        
        if ($this->isVersion('0.1.0')) {
            $extractors = new AddMetadataExtractors();
            $extractors([]);
            
            $injectors = new AddMetadataInjectors();
            $injectors([]);
            
            $this->setVersion('0.2.0');
        }

        $this->skip('0.2.0', '1.0.0');

        if ($this->isVersion('1.0.0')) {
            // Updating the ontology.
            OntologyUpdater::syncModels();

            // Add LOM metadata mapper services.
            $lomMapperServices = new AddLomMapperServices();
            $lomMapperServices->setServiceLocator($this->getServiceManager());
            $lomMapperServices([
                LomMapperService::LOM_TAO_MAPPER_KEY     => LomTaoMapper::class,
                LomMapperService::LOM_GENERIC_MAPPER_KEY => LomGenericMapper::class,
            ]);

            // Add LOM metadata export/import services.
            $lomMetadataServices = new AddLomMetadataServices();
            $lomMetadataServices->setServiceLocator($this->getServiceManager());
            $lomMetadataServices([
                MetadataService::IMPORTER_KEY => [
                    MetadataImporter::INJECTOR_KEY => [
                        LomImportInjector::class,
                    ],
                    MetadataImporter::EXTRACTOR_KEY => [
                        LomAutomaticProcessableSchemaImportExtractor::class,
                        LomClassificationImportExtractor::class,
                    ],
                    MetadataImporter::GUARDIAN_KEY => [
                        LomGeneralImportGuardian::class,
                    ],
                ],
                MetadataService::EXPORTER_KEY => [
                    MetadataExporter::INJECTOR_KEY => [
                        LomExportInjector::class,
                    ],
                    MetadataExporter::EXTRACTOR_KEY => [
                        LomExportExtractor::class
                    ],
                ],
            ]);

            $lomSchemaService = new AddLomSchemaService();
            $lomSchemaService->setServiceLocator($this->getServiceManager());
            $lomSchemaService([
                LomSchemaService::AUTOMATIC_PROCESSABLE_INSTANCES => [
                    LomGeneralIdentifierMetadata::class,
                    LomGeneralTitleMetadata::class,
                    LomGeneralLanguageMetadata::class,
                    LomGeneralDescriptionMetadata::class,
                    LomGeneralKeywordMetadata::class,
                    LomGeneralCoverageMetadata::class,
                ],
                LomSchemaService::CUSTOM_PROCESSABLE_INSTANCES => [
                    LomClassificationImportExtractor::SCHEMA_CLASSIFICATION_SOURCE => LomClassificationSourceMetadata::class,
                    LomClassificationImportExtractor::SCHEMA_CLASSIFICATION_ENTRY  => LomClassificationEntryMetadata::class,
                ],
            ]);

            // Setting the version.
            $this->setVersion('1.0.0');
//            $this->setVersion('2.0.0');
        }
    }
}
