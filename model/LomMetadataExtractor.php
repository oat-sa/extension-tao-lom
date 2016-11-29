<?php

namespace oat\taoLom\Model;

use oat\taoQtiItem\model\qti\metadata\imsManifest\ImsManifestMetadataExtractor;

class LomMetadataExtractor extends ImsManifestMetadataExtractor
{
    public function extract($manifest)
    {
        // Load constants.
        \common_ext_ExtensionsManager::singleton()->getExtensionById('taoLom')->load();

        // @todo specific behaviours to deal with LOM Taxon (key/value hack).
        return parent::extract($manifest);
    }
}
