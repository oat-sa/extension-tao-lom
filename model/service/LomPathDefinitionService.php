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

namespace oat\taoLom\model\service;


use oat\oatbox\service\ConfigurableService;
use oat\taoLom\model\ontology\interfaces\LomGenericPathDefinitionInterface;
use oat\taoLom\model\ontology\interfaces\LomTaoPathDefinitionInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class LomPathDefinitionService extends ConfigurableService
{
    /**
     * Service ID.
     */
    const SERVICE_ID = 'taoLom/lomPathDefinitionService';

    /**
     * Service config file path. (package name)
     */
    const SERVICE_CONFIG_FILE_PATH = 'taoLom';

    /**
     * Service config file name.
     */
    const SERVICE_CONFIG_FILE_NAME = 'lomPathDefinitionService';

    /**
     * LOM path definition instance which defines the lom paths in the TAO system.
     */
    const LOM_TAO_PATH_DEFINITION_KEY = 'lomTaoPathDefinition';

    /**
     * LOM path definition which defines the lom standard paths.
     *
     * @example IMS Global path definitions.
     */
    const LOM_GENERIC_PATH_DEFINITION_KEY = 'lomGenericPathDefinition';

    /**
     * @var array Instances of the path definitions.
     */
    protected $instances;

    /**
     * Register an instance of LomTaoPathDefinition, LomGenericPathDefinition
     *
     * @param $key
     * @param $name
     *
     * @return bool
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws ServiceNotFoundException
     */
    public function register($key, $name)
    {
        if (empty($key) || empty($name)) {
            throw new \InvalidArgumentException(__('Register method expects $key and $name parameters.'));
        }

        if (is_object($name)) {
            $name = get_class($name);
        }

        switch ($key) {
            case self::LOM_TAO_PATH_DEFINITION_KEY:
                $this->registerInstance(self::LOM_GENERIC_PATH_DEFINITION_KEY, $name, LomTaoPathDefinitionInterface::class);
                break;
            case self::LOM_GENERIC_PATH_DEFINITION_KEY:
                $this->registerInstance(self::LOM_TAO_PATH_DEFINITION_KEY, $name, LomGenericPathDefinitionInterface::class);
                break;
            default:
                throw new \common_Exception(__('Unknown $key to register LomPathDefinitionService instance'));
        }

        return true;
    }

    /**
     * Unregister an instance of LomTaoPathDefinition, LomGenericPathDefinition
     *
     * @param string $key
     * @param string $name
     *
     * @return bool
     *
     * @throws \common_Exception
     * @throws ServiceNotFoundException
     */
    public function unregister($key, $name)
    {
        if (empty($key) || empty($name)) {
            throw new \common_Exception(__('Unregister method expects $key and $name parameters.'));
        }

        if (is_object($name)) {
            $name = get_class($name);
        }

        switch ($key) {
            case self::LOM_TAO_PATH_DEFINITION_KEY:
            case self::LOM_GENERIC_PATH_DEFINITION_KEY:
                $this->unregisterInstance($key, $name);
                break;
            default:
                throw new \common_Exception(__('Unknown $key to unregister LomPathDefinitionService instance'));
        }

        return true;
    }

    /**
     * Allow to register, into the config, the current path definition service
     *
     * @throws \common_Exception
     * @throws ServiceNotFoundException
     */
    protected function registerService()
    {
        if ($this->getServiceLocator()->has(self::SERVICE_ID)) {
            $metadataService = $this->getServiceLocator()->get(self::SERVICE_ID);
        } else {
            $metadataService = $this->getServiceManager()->build(self::class);
        }
        $this->getServiceManager()->register(self::SERVICE_ID, $metadataService);
    }

    /**
     * Register a $name instance into $key config $key class has to implements $interface
     *
     * @param $key
     * @param $name
     * @param $interface
     *
     * @throws \common_Exception
     * @throws ServiceNotFoundException
     */
    protected function registerInstance($key, $name, $interface)
    {
        if (is_a($name, $interface, true)) {
            $instances = $this->getOption($key);
            if (!in_array($name, $instances, false)) {
                $instances[] = $name;
                $this->setOption($key, $instances);
                $this->registerService();
            }
        }
    }

    /**
     * Unregister a $name instance into $key config
     *
     * @param $key
     * @param $name
     *
     * @throws \common_Exception
     * @throws ServiceNotFoundException
     */
    protected function unregisterInstance($key, $name)
    {
        if ($this->hasOption($key)) {
            $instances = $this->getOption($key);

            if (($index = array_search($name, $instances, false)) !== false) {
                unset($instances[$index]);
                $this->setOption($key, $instances);
                $this->registerService();
            }
        }
    }

    /**
     * Return the LomTaoPathDefinition stored into config
     *
     * @return LomTaoPathDefinitionInterface
     *
     * @throws \common_Exception
     */
    public function getLomTaoPathDefinition()
    {
        return $this->getInstance(self::LOM_TAO_PATH_DEFINITION_KEY, LomTaoPathDefinitionInterface::class);
    }

    /**
     * Return the LomGenericPathDefinition stored into config
     *
     * @return LomGenericPathDefinitionInterface
     *
     * @throws \common_Exception
     */
    public function getLomGenericPathDefinition()
    {
        return $this->getInstance(self::LOM_GENERIC_PATH_DEFINITION_KEY, LomGenericPathDefinitionInterface::class);
    }

    /**
     * Return config instances
     *
     * Retrieve instances stored into config
     * Config $key is scan to take only instances with given $interface
     *
     * @param $id
     * @param $interface
     *
     * @return mixed
     *
     * @throws \common_Exception
     */
    protected function getInstance($id, $interface)
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!$this->hasOption($id)) {
            throw new \common_Exception(__('Unknown %s to get LOM path definition instance', $id));
        }

        $instance = $this->getOption($id);
        if (!is_a($instance, $interface, true)) {
            throw new \common_Exception(__('The registered service under the offset \'%s\' must be a path definition (%s) instance!', $id, $interface));
        }

        $this->instances[$id] = new $instance();

        return $this->instances[$id];
    }
}
