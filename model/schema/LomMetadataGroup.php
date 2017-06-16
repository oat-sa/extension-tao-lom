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

namespace oat\taoLom\model\schema;


use oat\tao\model\metadata\exception\writer\MetadataWriterException;
use oat\taoQtiItem\model\qti\metadata\MetadataValue;


class LomMetadataGroup implements MetadataValue
{
    /**
     * @var MetadataValue
     */
    protected $source;

    /**
     * @var MetadataValue[]
     */
    protected $entries;

    /**
     * ClassificationMetadataValue constructor.
     *
     * @param MetadataValue $source
     * @param MetadataValue[] $entries
     *
     * @throws MetadataWriterException
     */
    public function __construct(MetadataValue $source, array $entries)
    {
        foreach ($entries as $entry) {
            if (! $entry instanceof MetadataValue) {
                throw new MetadataWriterException(__('MetadataValue entries have to be an instance of ClassificationEntryMetadataValue'));
            }
        }
        $this->source  = $source;
        $this->entries = $entries;
    }

    /**
     * Get all classification metadata entries
     *
     * @return MetadataValue[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Get source classification path
     *
     * @return array
     */
    public function getPath()
    {
        return $this->source->getPath();
    }

    /**
     * Get language classification source
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->source->getLanguage();
    }

    /**
     * Get resource identifier associated to classification source
     *
     * @return string
     */
    public function getResourceIdentifier()
    {
        return $this->source->getResourceIdentifier();
    }

    /**
     * Get the value of the classification source
     *
     * @return string
     */
    public function getValue()
    {
        return $this->source->getValue();
    }
}