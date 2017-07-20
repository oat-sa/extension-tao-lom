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
use oat\taoLom\model\export\extractor\LomAutoProcessableSchemaExportExtractor;
use oat\taoLom\model\export\extractor\LomClassificationExportExtractor;
use oat\taoLom\model\export\injector\LomExportInjector;
use oat\taoLom\model\import\extractor\LomAutoProcessableSchemaImportExtractor;
use oat\taoLom\model\import\extractor\LomClassificationImportExtractor;
use oat\taoLom\model\import\guardian\LomGeneralIdentifierImportGuardian;
use oat\taoLom\model\import\injector\LomImportInjector;
use oat\taoLom\model\ontology\LomGenericPathDefinition;
use oat\taoLom\model\ontology\LomTaoPathDefinition;
use oat\taoLom\model\service\LomPathDefinitionService;
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

            // Add LOM metadata path definition services.
            $lomPathDefinitionServices = new AddLomPathDefinitionService();
            $lomPathDefinitionServices->setServiceLocator($this->getServiceManager());
            $lomPathDefinitionServices([
                LomPathDefinitionService::LOM_TAO_PATH_DEFINITION_KEY     => LomTaoPathDefinition::class,
                LomPathDefinitionService::LOM_GENERIC_PATH_DEFINITION_KEY => LomGenericPathDefinition::class,
            ]);

            // Add LOM metadata export/import services.
            $lomMetadataServices = new AddLomMetadataService();
            $lomMetadataServices->setServiceLocator($this->getServiceManager());
            $lomMetadataServices([
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

            // Add LOM schema instances.
            $lomSchemaService = new AddLomSchemaService();
            $lomSchemaService->setServiceLocator($this->getServiceManager());
            $lomSchemaService([
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

            // Setting the version.
            $this->setVersion('2.0.0');
        }
    }
}
