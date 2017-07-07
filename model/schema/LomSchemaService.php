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

namespace oat\taoLom\model\schema;


use oat\oatbox\service\ConfigurableService;
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

    /** The offset for general schema instances. */
    const LOM_SCHEMA_GENERAL = 'general';

    /** The offset for classification schema instances. */
    const LOM_SCHEMA_CLASSIFICATION = 'classification';

    /**
     * @var array Lom metadata schema instances.
     */
    protected static $optionOffsets = [
        self::LOM_SCHEMA_GENERAL,
        self::LOM_SCHEMA_CLASSIFICATION,
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
     * Returns the lom general schema instances.
     *
     * @return LomMetadataInterface[]
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws \common_exception_NotFound
     */
    public function getLomGeneralSchema()
    {
        return $this->getSchema(self::LOM_SCHEMA_GENERAL);
    }

    /**
     * Returns the lom classification schema instances.
     *
     * @return LomMetadataInterface[]
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws \common_exception_NotFound
     */
    public function getLomClassificationSchema()
    {
        return $this->getSchema(self::LOM_SCHEMA_CLASSIFICATION);
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
     * @return LomMetadataInterface[]
     *
     * @throws \common_Exception
     * @throws \InvalidArgumentException
     * @throws \common_exception_NotFound
     */
    protected function getSchema($offset)
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
        foreach ($classes as $class) {
            if (!is_a($class, LomMetadataInterface::class, true)) {
                throw new \InvalidArgumentException(
                    __('The requested LOM Metadata Schema offset contains invalid schema classes!')
                );
            }
            $instances[] = new $class();
        }

        return $instances;
    }
}
