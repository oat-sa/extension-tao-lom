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

use oat\taoLom\scripts\install\AddMetadataExtractors;
use oat\taoLom\scripts\install\AddMetadataInjectors;

/**
 * Generated using taoDevTools 2.15.0
 */
return array(
    'name'        => 'taoLom',
    'label'       => 'Learning Object Metadata',
    'description' => 'An extension supporting the IMS Global Loose version of the Learning Object Metadata standard.',
    'license'     => 'GPL-2.0',
    'version'     => '1.0.2',
    'author'      => 'Open Assessment Technologies SA',
    'requires' => array(
        'tao' => '>=9.0.0',
        'taoQtiItem' => '>=6.4.0'
    ),
    'managementRole' => 'http://www.tao.lu/Ontologies/generis.rdf#taoLomManager',
    'acl' => array(
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#taoLomManager', array('ext'=>'taoLom')),
    ),
    'install' => array(
        'rdf' => array(
            dirname(__FILE__) . '/install/ontology/lom.rdf',
            dirname(__FILE__) . '/install/ontology/category.rdf',
            dirname(__FILE__) . '/install/ontology/general.rdf',
        ),
        'php' => array(
            AddMetadataExtractors::class,
            AddMetadataInjectors::class
		)
    ),
    'uninstall' => array(
    ),
    'routes' => array(
        '/taoLom' => 'oat\\taoLom\\controller'
    ),
    'update' => \oat\taoLom\scripts\update\Updater::class,
    'constants' => array(
        # views directory
        "DIR_VIEWS" => dirname(__FILE__).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR,
        
        #BASE URL (usually the domain root)
        'BASE_URL' => ROOT_URL.'taoLom/',
    ),
    'extra' => array(
        'structures' => dirname(__FILE__).DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'structures.xml',
    )
);
