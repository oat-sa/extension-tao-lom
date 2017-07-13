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
use oat\taoLom\model\schema\LomSchemaInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class LomSchemaService extends ConfigurableService
{
    /**
     * Service ID.
     */
    const SERVICE_ID = 'taoLom/lomSchemaService';

    /**
     * Service config file path. (package name)
     */
    const SERVICE_CONFIG_FILE_PATH = 'taoLom';

    /**
     * Service config file name.
     */
    const SERVICE_CONFIG_FILE_NAME = 'lomSchemaService';

    /** The offset for automatic processable schema instances. */
    const AUTOMATIC_PROCESSABLE_INSTANCES = 'automaticProcessableInstances';

    /** The offset for custom processable schema instances. */
    const CUSTOM_PROCESSABLE_INSTANCES = 'customProcessableInstances';

    /**
     * @var array Lom metadata schema instances.
     */
    protected static $optionOffsets = [
        self::AUTOMATIC_PROCESSABLE_INSTANCES,
        self::CUSTOM_PROCESSABLE_INSTANCES,
    ];

    /**
     * Allow to register, into the config, the current schema service
     *
     * @throws \common_Exception
     * @throws ServiceNotFoundException
     */
    protected function registerService()
    {
        if ($this->getServiceLocator()->has(self::SERVICE_ID)) {
            $schemaService = $this->getServiceLocator()->get(self::SERVICE_ID);
        } else {
            $schemaService = $this->getServiceManager()->build(self::class);
        }
        $this->getServiceManager()->register(self::SERVICE_ID, $schemaService);
    }

    /**
     * Returns the automatic processable schema instances.
     *
     * @return LomSchemaInterface[]
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws \common_exception_NotFound
     */
    public function getAutomaticProcessableSchemaInstances()
    {
        return $this->getSchemaInstances(self::AUTOMATIC_PROCESSABLE_INSTANCES);
    }

    /**
     * Returns the custom processable schema instances.
     *
     * @return LomSchemaInterface[]
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws \common_exception_NotFound
     */
    public function getCustomProcessableSchemaInstances()
    {
        return $this->getSchemaInstances(self::CUSTOM_PROCESSABLE_INSTANCES);
    }

    /**
     * Returns TRUE if the requested offset is allowed.
     *
     * @param $offset
     *
     * @return bool
     */
    public static function isValidOffset($offset)
    {
        return in_array($offset, static::$optionOffsets, true);
    }

    /**
     * Returns the lom schema instances.
     *
     * @param string $offset   The metadata schema offset.
     *
     * @return LomSchemaInterface[]
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws \common_exception_NotFound
     */
    protected function getSchemaInstances($offset)
    {
        if (!static::isValidOffset($offset)) {
            throw new \InvalidArgumentException(__('The requested LOM Metadata Schema offset is not allowed!'));
        }

        if (!$this->hasOption($offset)) {
            throw new \common_exception_NotFound(__('The requested LOM Metadata Schema offset does not exist!'));
        }

        $classes = $this->getOption($offset);
        if (empty($classes) || !is_array($classes)) {
            throw new \common_Exception(__('The requested LOM Metadata Schema offset is empty!'));
        }

        $instances = [];
        foreach ($classes as $classKey => $class) {
            if (!is_a($class, LomSchemaInterface::class, true)) {
                throw new \InvalidArgumentException(
                    __('The requested LOM Metadata Schema offset contains invalid schema classes!')
                );
            }

            if (is_numeric($classKey)) {
                $instances[] = new $class();
            }
            else {
                $instances[$classKey] = new $class();
            }
        }

        return $instances;
    }
}