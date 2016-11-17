<?php

namespace oat\taoLom\test;

use oat\generis\model\OntologyAwareTrait;
use oat\tao\test\TaoPhpUnitTestRunner;

class OntologyTest extends TaoPhpUnitTestRunner
{
    use OntologyAwareTrait;
    
    public function testClasses()
    {
        // Get all LOM categories
        $categories = [];
        $categoryClasses = $this->getClass('http://www.tao.lu/Ontologies/TAOLom.rdf#LomCategory')->getInstances();
        foreach ($categoryClasses as $category) {
            $categories[$category->getLabel()] = [];
        }

        $lomCategoryProperty = $this->getProperty('http://www.tao.lu/Ontologies/TAOLom.rdf#lomCategoryProperty');

        // Get all LOM properties & sort them by category
        $lomProperties = $this->getClass('http://www.tao.lu/Ontologies/TAOLom.rdf#lomProperty')->getInstances();
        foreach ($lomProperties as $lomProperty) {
            $categories[$lomProperty->getUniquePropertyValue($lomCategoryProperty)->getLabel()][] = $this->getProperty($lomProperty);
        }

        // Display LOM properties by category
        foreach ($categories as $category => $properties) {
            echo PHP_EOL . 'Category : ' . $category . PHP_EOL;

            if (empty($properties)) {
                echo ' No LOM property associated to this category' . PHP_EOL;
                continue;
            }

            echo ' -- LOM properties -- ' . PHP_EOL;
            foreach ($properties as $property) {
                echo '   * uri   = ' . $property->getUri() . PHP_EOL;
                echo '   * label = ' . $property->getLabel() . PHP_EOL;
                echo '   * range = ' . reset($property->getRange()) . PHP_EOL;
                echo ' -- ' . PHP_EOL;
            }
        }
        
    }
}