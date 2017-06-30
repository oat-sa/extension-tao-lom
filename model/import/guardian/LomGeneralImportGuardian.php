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

namespace oat\taoLom\model\import\guardian;


use oat\taoLom\model\ontology\LomTaoSchema;
use oat\taoQtiItem\model\qti\metadata\MetadataGuardian;
use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

class LomGeneralImportGuardian implements MetadataGuardian
{
    /**
     * @inheritdoc
     */
    public function guard(array $metadataValues)
    {
        /** @var SimpleMetadataValue $metadataValue */
        foreach($metadataValues as $metadataValue) {
            if ($metadataValue->getPath() === array(LomTaoSchema::GENERAL_IDENTIFIER)) {
                \common_Logger::i('Guarding Lom General identifier...');
                $class = new \core_kernel_classes_Class(TAO_TEST_CLASS);
                $instances = $class->searchInstances(
                    array(LomTaoSchema::GENERAL_IDENTIFIER => $metadataValue->getValue()),
                    array('like' => false, 'recursive' => true)
                );

                if (count($instances) > 0) {
                    //var_dump($instances);
                    return reset($instances);
                }
            }
        }

        return false;
    }
}