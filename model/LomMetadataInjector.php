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
use oat\taoLom\model\LomOntology;
use oat\taoLom\model\ImsMdLoose1p3p2Schema;

class LomMetadataInjector extends OntologyMetadataInjector
{
    public function __construct()
    {
        parent::__construct();

        // LOM General Category Injection Rules.
        $this->addInjectionRule(
            array(
                ImsMdLoose1p3p2Schema::PATH_ROOT,
                ImsMdLoose1p3p2Schema::PATH_GENERAL,
                ImsMdLoose1p3p2Schema::PATH_IDENTIFIER,
                ImsMdLoose1p3p2Schema::PATH_ENTRY
            ),
            LomOntology::PROPERTY_IDENTFIER
        );

        $this->addInjectionRule(
            array(
                ImsMdLoose1p3p2Schema::PATH_ROOT,
                ImsMdLoose1p3p2Schema::PATH_GENERAL,
                ImsMdLoose1p3p2Schema::PATH_TITLE,
                ImsMdLoose1p3p2Schema::PATH_STRING,
            ),
            LomOntology::PROPERTY_TITLE
        );
    }
}
