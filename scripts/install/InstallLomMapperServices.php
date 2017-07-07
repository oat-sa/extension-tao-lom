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
 *
 *
 */

namespace oat\taoLom\scripts\install;


use oat\oatbox\action\Action;
use oat\oatbox\service\ServiceManagerAwareTrait;
use oat\taoLom\model\mapper\LomGenericMapper;
use oat\taoLom\model\mapper\LomTaoMapper;
use oat\taoLom\model\ontology\LomMapperService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class InstallLomMapperServices implements Action, ServiceLocatorAwareInterface
{
    use ServiceManagerAwareTrait;

    public function __invoke($params)
    {
        $lomMapperServices = new AddLomMapperServices();
        $lomMapperServices->setServiceLocator($this->getServiceManager());

        return $lomMapperServices([
            LomMapperService::LOM_TAO_MAPPER_KEY     => LomTaoMapper::class,
            LomMapperService::LOM_GENERIC_MAPPER_KEY => LomGenericMapper::class,
        ]);
    }
}