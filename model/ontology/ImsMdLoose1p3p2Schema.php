<?php
/**
 * Created by PhpStorm.
 * User: vilmos
 * Date: 22/06/17
 * Time: 13:55
 */

namespace oat\taoLom\model\ontology;


interface ImsMdLoose1p3p2Schema
{
    /**
     * The LOM property namespace.
     */
    const LOM_NAMESPACE = 'http://ltsc.ieee.org/xsd/LOM';

    /**
     * The LOM node property path.
     */
    const LOM_PATH = self::LOM_NAMESPACE . '#lom';


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