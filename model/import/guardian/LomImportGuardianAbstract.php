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


use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\ontology\interfaces\LomTaoPathDefinitionInterface;
use oat\taoLom\model\service\LomPathDefinitionService;
use oat\taoQtiItem\model\qti\metadata\MetadataGuardian;

abstract class LomImportGuardianAbstract implements MetadataGuardian
{
    /**
     * @var LomTaoPathDefinitionInterface
     */
    protected $taoPathDefinition;

    /**
     * LomImportGuardianAbstract constructor.
     *
     * @throws \common_Exception
     */
    public function __construct()
    {
        /** @var LomPathDefinitionService $pathDefinitionService */
        $pathDefinitionService = ServiceManager::getServiceManager()->get(LomPathDefinitionService::SERVICE_ID);
        $this->taoPathDefinition = $pathDefinitionService->getLomTaoPathDefinition();
    }

    /**
     * Returns the LOM TAO path definitions.
     *
     * @return LomTaoPathDefinitionInterface
     */
    public function getTaoPathDefinition()
    {
        return $this->taoPathDefinition;
    }

    /**
     * Sets the LOM TAO path definitions.
     *
     * @param LomTaoPathDefinitionInterface $taoPathDefinition
     */
    public function setTaoPathDefinition($taoPathDefinition)
    {
        $this->taoPathDefinition = $taoPathDefinition;
    }
}