<?php
/**  
 * Copyright (c) 2015-2016 (original work) Open Assessment Technologies;
 */
namespace oat\taoLom\model;

use oat\taoQtiItem\model\qti\metadata\ontology\OntologyMetadataInjector;

class LomMetadataInjector extends OntologyMetadataInjector
{
    public function __construct()
    {
        parent::__construct();

        // Make sure that constants are REALLY loaded in the current execution context.
        \common_ext_ExtensionsManager::singleton()->getExtensionById('taoLom')->load();

        // LOM General Category Injection Rules.
        $this->addInjectionRule(
            array(
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_ROOT,
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_GENERAL,
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_IDENTIFIER,
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_ENTRY
            ),
            TAOLOM_PROPERTY_IDENTFIER
        );

        $this->addInjectionRule(
            array(
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_ROOT,
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_GENERAL,
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_TITLE,
                TAOLOM_IMSMD_LOOSE_1P3P2_PATH_STRING,
            ),
            TAOLOM_PROPERTY_TITLE
        );
    }
}
