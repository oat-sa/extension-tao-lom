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


use oat\taoLom\model\mapper\interfaces\LomTaoMapperInterface;

class LomTaoMapper implements LomTaoMapperInterface
{
    /**
     * @inheritdoc
     */
    public function getGeneralIdentifier()
    {
        return 'http://www.taotesting.com/ontologies/lom.rdf#general-identifier';
    }

    /**
     * @inheritdoc
     */
    public function getGeneralTitle()
    {
        return 'http://www.taotesting.com/ontologies/lom.rdf#general-title';
    }

    /**
     * @inheritdoc
     */
    public function getGeneralLanguage()
    {
        return 'http://www.taotesting.com/ontologies/lom.rdf#general-language';
    }

    /**
     * @inheritdoc
     */
    public function getGeneralDescription()
    {
        return 'http://www.taotesting.com/ontologies/lom.rdf#general-description';
    }

    /**
     * @inheritdoc
     */
    public function getGeneralKeyWord()
    {
        return 'http://www.taotesting.com/ontologies/lom.rdf#general-keyword';
    }

    /**
     * @inheritdoc
     */
    public function getGeneralCoverage()
    {
        return 'http://www.taotesting.com/ontologies/lom.rdf#general-coverage';
    }
}
