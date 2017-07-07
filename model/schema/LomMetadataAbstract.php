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
use oat\taoLom\model\mapper\interfaces\LomGenericMapperInterface;
use oat\taoLom\model\mapper\interfaces\LomTaoMapperInterface;
use oat\taoLom\model\ontology\LomMapperService;

abstract class LomMetadataAbstract implements LomMetadataInterface
{
    /**
     * @var LomTaoMapperInterface
     */
    protected $taoMapper;

    /**
     * @var LomGenericMapperInterface
     */
    protected $genericMapper;

    /**
     * LomMetadataAbstract constructor.
     *
     * @throws \InvalidArgumentException If one of the argument contains an invalid value.
     * @throws \common_Exception
     */
    public function __construct()
    {
        /** @var LomMapperService $mappingService */
        $mappingService = ServiceManager::getServiceManager()->get(LomMapperService::SERVICE_ID);
        $this->taoMapper = $mappingService->getLomTaoMapper();
        $this->genericMapper = $mappingService->getLomGenericMapper();
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