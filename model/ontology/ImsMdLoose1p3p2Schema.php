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
 * Copyright (c) 2017 Open Assessment Technologies SA
 *
 */

namespace oat\taoLom\model\ontology;


interface ImsMdLoose1p3p2Schema
{
    /**
     * LOM General details.
     */
    /**
     * The LOM property namespace.
     */
    const LOM_NAMESPACE = 'http://ltsc.ieee.org/xsd/LOM';
    /**
     * The LOM node property path.
     */
    const LOM_PATH = self::LOM_NAMESPACE . '#lom';
    /**
     * The LOM schema.
     */
    const LOM_SCHEMA = 'https://standards.ieee.org/downloads/LOM/lomv1.0/xsd/lom.xsd';
    /**
     * The LOM prefix.
     */
    const LOM_PREFIX = 'lom';


    /**
     * The LOM generic node paths.
     */
    /**
     * Source node.
     */
    const LOM_SOURCE_PATH = self::LOM_NAMESPACE . '#source';
    /**
     * Entry node.
     */
    const LOM_ENTRY_PATH = self::LOM_NAMESPACE . '#entry';
    /**
     * String node.
     */
    const LOM_STRING_PATH = self::LOM_NAMESPACE . '#string';


    /**
     * General node paths.
     */
    /**
     * General node.
     */
    const LOM_GENERAL_PATH = self::LOM_NAMESPACE . '#general';
    /**
     * Identifier node.
     */
    const LOM_IDENTIFIER_PATH = self::LOM_NAMESPACE . '#identifier';
    /**
     * Title node.
     */
    const LOM_TITLE_PATH = self::LOM_NAMESPACE . '#title';
    /**
     * Language node.
     */
    const LOM_LANGUAGE_PATH = self::LOM_NAMESPACE . '#language';
    /**
     * Description node.
     */
    const LOM_DESCRIPTION_PATH = self::LOM_NAMESPACE . '#description';
    /**
     * Keyword node.
     */
    const LOM_KEYWORD_PATH = self::LOM_NAMESPACE . '#keyword';
    /**
     * Coverage node.
     */
    const LOM_COVERAGE_PATH = self::LOM_NAMESPACE . '#coverage';


    /**
     * Classification node paths.
     */
    /**
     * Classification node.
     */
    const LOM_CLASSIFICATION_PATH = self::LOM_NAMESPACE . '#classification';
    /**
     * TaxonPath node.
     */
    const LOM_TAXONPATH_PATH = self::LOM_NAMESPACE . '#taxonPath';
    /**
     * Taxon node.
     */
    const LOM_TAXON_PATH = self::LOM_NAMESPACE . '#taxon';
}