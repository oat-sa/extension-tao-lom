<?php
/**
 * This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; under version 2
 *  of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 *  Copyright (c) 2017 (original work) Open Assessment Technologies SA
 */

namespace oat\taoLom\model\ontology;

interface LomTaoMetaData
{
    const GENERAL_IDENTIFIER = 'http://www.taotesting.com/ontologies/lom.rdf#general-identifier';
    const GENERAL_TITLE = 'http://www.taotesting.com/ontologies/lom.rdf#general-title';
    const GENERAL_LANGUAGE = 'http://www.taotesting.com/ontologies/lom.rdf#general-language';
    const GENERAL_DESCRIPTION = 'http://www.taotesting.com/ontologies/lom.rdf#general-description';
    const GENERAL_KEYWORD = 'http://www.taotesting.com/ontologies/lom.rdf#general-keyword';
    const GENERAL_COVERAGE = 'http://www.taotesting.com/ontologies/lom.rdf#general-coverage';

    const PROPERTY_NCCER_TEST_CATEGORY      = 'http://www.nccer.org/testmodel#testCategory';
    const PROPERTY_NCCER_TEST_MODULE_NUMBER = 'http://www.nccer.org/testmodel#testModuleNumber';
    const PROPERTY_NCCER_TEST_PROFILE       = 'http://www.nccer.org/delivery#TestProfile';
}