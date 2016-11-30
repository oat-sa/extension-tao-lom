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
namespace oat\taoLom\test;

use oat\generis\model\OntologyAwareTrait;
use oat\tao\test\TaoPhpUnitTestRunner;

class OntologyTest extends TaoPhpUnitTestRunner
{
    use OntologyAwareTrait;
    
    public function testGeneralOntologyClass()
    {
        $categoryClass = $this->getClass('http://www.taotesting.com/ontologies/lom.rdf#LomCategory');
        $this->assertTrue($categoryClass->exists());

        $generalCategoryProperty = $this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#General');
        $this->assertTrue($generalCategoryProperty->exists());

        $lomProperty = $this->getClass('http://www.taotesting.com/ontologies/lom.rdf#lomProperty');
        $this->assertTrue($lomProperty->exists());

        $lomCategoryProperty = $this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#lomCategoryProperty');
        $this->assertTrue($lomCategoryProperty->exists());

        $identifierProperty = $this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-identifier');
        $this->assertTrue($identifierProperty->exists());
        $this->assertEquals(
            $generalCategoryProperty,
            $this->getProperty($identifierProperty->getUniquePropertyValue($lomCategoryProperty))
        );

        $titleProperty = $this->getProperty('http://www.taotesting.com/ontologies/lom.rdf#general-title');
        $this->assertTrue($titleProperty->exists());
        $this->assertEquals(
            $generalCategoryProperty,
            $this->getProperty($titleProperty->getUniquePropertyValue($lomCategoryProperty))
        );
    }
}
