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
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA;
 */

namespace oat\taoLom\test\import\guardian;

use oat\taoLom\model\import\guardian\LomGeneralIdentifierImportGuardian;
use oat\taoLom\model\ontology\interfaces\LomTaoPathDefinitionInterface;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;
use PHPUnit\Framework\TestCase;

class LomGeneralIdentifierImportGuardianTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockInstance;

    /**
     * Sets up the test mock object for each of the tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockInstance = $this->getMockBuilder(LomGeneralIdentifierImportGuardian::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTestClass', 'getTaoPathDefinition'])
            ->getMock()
        ;
    }

    /**
     * Test the guard method when there is no existing entry.
     */
    public function testGuardOnNonExists()
    {
        $resourceUriFixture = 'http://item#1234';
        $generalIdentifierUriFixture = 'http://lom#identifier';
        $valueFixture = '1234';

        // Mocking the TAO path definition instance.
        $taoPathDefinitionMock = $this->getMockBuilder(LomTaoPathDefinitionInterface::class)->getMockForAbstractClass();
        $taoPathDefinitionMock->expects($this->exactly(2))
            ->method('getGeneralIdentifier')
            ->will($this->returnValue($generalIdentifierUriFixture))
        ;

        $this->mockInstance->expects($this->exactly(2))
            ->method('getTaoPathDefinition')
            ->will($this->returnValue($taoPathDefinitionMock))
        ;

        // Mocking the test class instance.
        $testClassMock = $this->getMockBuilder(\core_kernel_classes_Class::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $testClassMock->expects($this->once())
            ->method('searchInstances')
            ->will($this->returnValue([]))
        ;

        $this->mockInstance->expects($this->once())
            ->method('getTestClass')
            ->willReturn($testClassMock);


        $metadataFixture = [
            new SimpleMetadataValue(
                $resourceUriFixture,
                [$generalIdentifierUriFixture],
                $valueFixture
            )
        ];

        $this->assertFalse($this->mockInstance->guard($metadataFixture));
    }

    /**
     * Test the guard method when there is an existing entry.
     */
    public function testGuardOnExists()
    {
        $resourceUriFixture = 'http://item#1234';
        $generalIdentifierUriFixture = 'http://lom#identifier';
        $valueFixture = '1234';

        // Mocking the TAO path definition instance.
        $taoPathDefinitionMock = $this->getMockBuilder(LomTaoPathDefinitionInterface::class)->getMockForAbstractClass();
        $taoPathDefinitionMock->expects($this->exactly(2))
            ->method('getGeneralIdentifier')
            ->willReturn($generalIdentifierUriFixture)
        ;

        $this->mockInstance->expects($this->exactly(2))
            ->method('getTaoPathDefinition')
            ->willReturn($taoPathDefinitionMock)
        ;

        // Mocking the test class instance.
        $resourceMock = $this->getMockBuilder(\core_kernel_classes_Resource::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOnePropertyValue'])
            ->getMock()
        ;
        $resourceMock->expects($this->once())
            ->method('getOnePropertyValue')
            ->willReturn($valueFixture)
        ;

        $testClassMock = $this->getMockBuilder(\core_kernel_classes_Class::class)
            ->disableOriginalConstructor()
            ->setMethods(['searchInstances'])
            ->getMock()
        ;
        $testClassMock->expects($this->once())
            ->method('searchInstances')
            ->willReturn([$resourceMock])
        ;

        $this->mockInstance->expects($this->once())
            ->method('getTestClass')
            ->willReturn($testClassMock);

        // Getting fake property mock for the assertion.
        $propertyMock = $this->getMockBuilder(\core_kernel_classes_Property::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Metadata for the guardian.
        $metadataFixture = [
            new SimpleMetadataValue(
                $resourceUriFixture,
                [$generalIdentifierUriFixture],
                $valueFixture
            )
        ];

        $this->assertEquals(
            $valueFixture,
            $this->mockInstance->guard($metadataFixture)->getOnePropertyValue($propertyMock)
        );
    }
}
