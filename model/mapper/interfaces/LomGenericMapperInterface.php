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

namespace oat\taoLom\model\mapper\interfaces;


interface LomGenericMapperInterface
{
    /**
     * LOM General details.
     */
    /**
     * Returns the LOM property namespace.
     *
     * @return string
     */
    public function getLomNameSpace();

    /**
     * Returns the LOM node property path.
     *
     * @return string
     */
    public function getLomPath();

    /**
     * Returns the LOM schema.
     *
     * @return string
     */
    public function getLomSchema();

    /**
     * Returns the LOM prefix.
     *
     * @return string
     */
    public function getLomPrefix();


    /**
     * The LOM generic node paths.
     */
    /**
     * Returns the LOM source node.
     *
     * @return string
     */
    public function getLomSourcePath();

    /**
     * Returns the LOM entry node.
     *
     * @return string
     */
    public function getLomEntryPath();

    /**
     * Returns the LOM string node.
     *
     * @return string
     */
    public function getLomStringPath();

    /**
     * Returns the LOM taxonpath node.
     *
     * @return string
     */
    public function getLomTaxonPathPath();

    /**
     * Returns the LOM taxon node.
     *
     * @return string
     */
    public function getTaxonPath();


    /**
     * General node paths.
     */
    /**
     * Returns the LOM general node.
     *
     * @return string
     */
    public function getLomGeneralPath();

    /**
     * Returns the LOM general identifier node.
     *
     * @return string
     */
    public function getLomIdentifierPath();

    /**
     * Returns the LOM general title node.
     *
     * @return string
     */
    public function getLomTitlePath();

    /**
     * Returns the LOM general language node.
     *
     * @return string
     */
    public function getLomLanguagePath();

    /**
     * Returns the LOM general description node.
     *
     * @return string
     */
    public function getLomDescriptionPath();

    /**
     * Returns the LOM general keyword node.
     *
     * @return string
     */
    public function getLomKeywordPath();

    /**
     * Returns the LOM general coverage node.
     *
     * @return string
     */
    public function getLomCoveragePath();


    /**
     * Classification node paths.
     */
    /**
     * Returns the LOM classification node.
     *
     * @return string
     */
    public function getLomClassificationPath();
}