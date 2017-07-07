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

namespace oat\taoLom\model\mapper;


use oat\taoLom\model\mapper\interfaces\LomGenericMapperInterface;

class LomGenericMapper implements LomGenericMapperInterface
{
    /**
     * LOM General details.
     */
    /**
     * Returns the LOM property namespace.
     *
     * @return string
     */
    public function getLomNameSpace()
    {
        return 'http://ltsc.ieee.org/xsd/LOM';
    }

    /**
     * Returns the LOM node property path.
     *
     * @return string
     */
    public function getLomPath()
    {
        return $this->getLomNameSpace() . '#lom';
    }

    /**
     * Returns the LOM schema.
     *
     * @return string
     */
    public function getLomSchema()
    {
        return 'https://standards.ieee.org/downloads/LOM/lomv1.0/xsd/lom.xsd';
    }

    /**
     * Returns the LOM prefix.
     *
     * @return string
     */
    public function getLomPrefix()
    {
        return 'lom';
    }


    /**
     * The LOM generic node paths.
     */
    /**
     * Returns the LOM source node.
     *
     * @return string
     */
    public function getLomSourcePath()
    {
        return $this->getLomNameSpace() . '#source';
    }

    /**
     * Returns the LOM entry node.
     *
     * @return string
     */
    public function getLomEntryPath()
    {
        return $this->getLomNameSpace() . '#entry';
    }

    /**
     * Returns the LOM string node.
     *
     * @return string
     */
    public function getLomStringPath()
    {
        return $this->getLomNameSpace() . '#string';
    }

    /**
     * Returns the LOM taxonpath node.
     *
     * @return string
     */
    public function getLomTaxonPathPath()
    {
        return $this->getLomNameSpace() . '#taxonPath';
    }

    /**
     * Returns the LOM taxon node.
     *
     * @return string
     */
    public function getTaxonPath()
    {
        return $this->getLomNameSpace() . '#taxon';
    }

    /**
     * General node paths.
     */
    /**
     * Returns the LOM general node.
     *
     * @return string
     */
    public function getLomGeneralPath()
    {
        return $this->getLomNameSpace() . '#general';
    }

    /**
     * Returns the LOM general identifier node.
     *
     * @return string
     */
    public function getLomIdentifierPath()
    {
        return $this->getLomNameSpace() . '#identifier';
    }

    /**
     * Returns the LOM general title node.
     *
     * @return string
     */
    public function getLomTitlePath()
    {
        return $this->getLomNameSpace() . '#title';
    }

    /**
     * Returns the LOM general language node.
     *
     * @return string
     */
    public function getLomLanguagePath()
    {
        return $this->getLomNameSpace() . '#language';
    }

    /**
     * Returns the LOM general description node.
     *
     * @return string
     */
    public function getLomDescriptionPath()
    {
        return $this->getLomNameSpace() . '#description';
    }

    /**
     * Returns the LOM general keyword node.
     *
     * @return string
     */
    public function getLomKeywordPath()
    {
        return $this->getLomNameSpace() . '#keyword';
    }

    /**
     * Returns the LOM general coverage node.
     *
     * @return string
     */
    public function getLomCoveragePath()
    {
        return $this->getLomNameSpace() . '#coverage';
    }


    /**
     * Classification node paths.
     */
    /**
     * Returns the LOM classification node.
     *
     * @return string
     */
    public function getLomClassificationPath()
    {
        return $this->getLomNameSpace() . '#classification';
    }
}
