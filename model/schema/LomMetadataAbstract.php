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


use oat\taoQtiItem\model\qti\metadata\simple\SimpleMetadataValue;

abstract class LomMetadataAbstract extends SimpleMetadataValue
{
    /**
     * ClassificationSourceMetadataValue constructor.
     *
     * @param string $resourceIdentifier
     * @param string $value
     * @param string $language
     */
    public function __construct($resourceIdentifier, $value, $language = DEFAULT_LANG)
    {
        parent::__construct($resourceIdentifier, static::getNodePath(), $value, $language);
    }

    /**
     * Get the node's path.
     */
    abstract public static function getNodePath();

    /**
     * Get the node's base path
     *
     * @return array
     */
    abstract public static function getBaseNodePath();

    /**
     * Get the node's relative path.
     *
     * @return array
     */
    abstract public static function getNodeRelativePath();


    /**
     * Get the node's absolute path.
     *
     * @return array
     */
    static public function getNodeAbsolutePath()
    {
        return array_merge(
            static::getBaseNodePath(),
            static::getNodeRelativePath()
        );
    }
}