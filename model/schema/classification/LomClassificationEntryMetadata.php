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

namespace oat\taoLom\model\schema\classification;

use oat\taoLom\model\ontology\ImsMdLoose1p3p2Schema;
use oat\taoLom\model\schema\LomMetadataAbstract;

class LomClassificationEntryMetadata extends LomMetadataAbstract
{
    // Adding the getBaseNodePath method.
    use LomClassificationMetadataTrait;

    /**
     * Get the classification source node's extract path.
     *
     * @return array
     */
    public static function getNodePath()
    {
        return static::getNodeRelativePath();
    }

    /**
     * Get the classification source node's relative path.
     *
     * @return array
     */
    static public function getNodeRelativePath()
    {
        return array(
            ImsMdLoose1p3p2Schema::LOM_TAXON_PATH,
            ImsMdLoose1p3p2Schema::LOM_ENTRY_PATH,
            ImsMdLoose1p3p2Schema::LOM_STRING_PATH,
        );
    }
}