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

namespace oat\taoLom\model\schema\imsglobal\classification;

use oat\taoLom\model\schema\LomSchemaAbstract;

class LomClassificationEntrySchema extends LomSchemaAbstract
{
    // Adding the getBaseNodePath method.
    use LomClassificationSchemaTrait;

    /**
     * Get the classification source node's extract path.
     *
     * @return array
     */
    public function getNodePath()
    {
        return $this->getNodeRelativePath();
    }

    /**
     * Get the classification source node's relative path.
     *
     * @return array
     */
    public function getNodeRelativePath()
    {
        return array(
            $this->genericPathDefinition->getTaxonPath(),
            $this->genericPathDefinition->getEntryPath(),
            $this->genericPathDefinition->getStringPath(),
        );
    }

    /**
     * @inheritdoc
     */
    public function getTaoPath()
    {
        return null;
    }
}
