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
