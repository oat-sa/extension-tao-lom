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
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA
 *
 */

namespace oat\taoLom\model\schema;


use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\ontology\interfaces\LomGenericPathDefinitionInterface;
use oat\taoLom\model\ontology\interfaces\LomTaoPathDefinitionInterface;
use oat\taoLom\model\service\LomPathDefinitionService;

abstract class LomSchemaAbstract implements LomSchemaInterface
{
    /**
     * @var LomTaoPathDefinitionInterface
     */
    protected $taoPathDefinition;

    /**
     * @var LomGenericPathDefinitionInterface
     */
    protected $genericPathDefinition;

    /**
     * LomMetadataAbstract constructor.
     *
     * @throws \InvalidArgumentException If one of the argument contains an invalid value.
     * @throws \common_Exception
     */
    public function __construct()
    {
        /** @var LomPathDefinitionService $pathDefinitionService */
        $pathDefinitionService = ServiceManager::getServiceManager()->get(LomPathDefinitionService::SERVICE_ID);
        $this->taoPathDefinition = $pathDefinitionService->getLomTaoPathDefinition();
        $this->genericPathDefinition = $pathDefinitionService->getLomGenericPathDefinition();
    }

    /**
     * Get the node's absolute path.
     *
     * @return array
     */
    public function getNodeAbsolutePath()
    {
        return array_merge(
            $this->getBaseNodePath(),
            $this->getNodeRelativePath()
        );
    }
}