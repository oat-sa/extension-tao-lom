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

namespace oat\taoLom\model\export\extractor;

use oat\generis\model\OntologyAwareTrait;
use oat\oatbox\service\ServiceManager;
use oat\taoLom\model\ontology\interfaces\LomTaoPathDefinitionInterface;
use oat\taoLom\model\service\LomPathDefinitionService;
use oat\taoQtiItem\model\qti\metadata\MetadataExtractor;

abstract class LomExportExtractorAbstract implements MetadataExtractor
{
    use OntologyAwareTrait;

    /**
     * @var LomTaoPathDefinitionInterface
     */
    protected $taoPathDefinition;

    /**
     * @var string
     */
    private $languageCode;

    /**
     * LomExportExtractorAbstract constructor.
     *
     * @throws \common_Exception
     */
    public function __construct()
    {
        /** @var LomPathDefinitionService $pathDefinitionService */
        $pathDefinitionService = ServiceManager::getServiceManager()->get(LomPathDefinitionService::SERVICE_ID);
        $this->taoPathDefinition = $pathDefinitionService->getLomTaoPathDefinition();
    }

    /**
     * Returns the language code.
     *
     * @param \core_kernel_classes_Resource $resource
     *
     * @return string
     */
    public function getLanguageCode(\core_kernel_classes_Resource $resource)
    {
        if (empty($this->languageCode)) {
            // Defining the language for the export.
            $this->languageCode = $resource->getOnePropertyValue($this->getProperty($this->taoPathDefinition->getGeneralLanguage()));
            if (empty($this->languageCode) ||
                !\tao_models_classes_LanguageService::singleton()->isLanguageAvailable(
                    $this->languageCode,
                    new \core_kernel_classes_Resource(INSTANCE_LANGUAGE_USAGE_GUI)
                )
            ) {
                $this->languageCode = \tao_helpers_translation_Utils::getDefaultLanguage();
            }

        }

        return $this->languageCode;
    }

    /**
     * Returns the item identifier.
     *
     * @param \core_kernel_classes_Resource $resource
     *
     * @return string
     */
    public function getIdentifier($resource)
    {
        return \tao_helpers_Uri::getUniqueId($resource->getUri());
    }

    /**
     * Returns the restructured extract output.
     *
     * @param \core_kernel_classes_Resource $resource
     * @param array $metadata   The extracted metadata.
     *
     * @return array
     */
    public function getExtractOutput($resource, $metadata)
    {
        return [$this->getIdentifier($resource) => empty($metadata)
            ? []
            : $metadata
        ];
    }
}
