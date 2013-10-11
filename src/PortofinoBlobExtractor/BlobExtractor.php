<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tondi
 * Date: 02/09/13
 * Time: 16:28
 */

namespace PortofinoBlobExtractor;


use PortofinoBlobExtractor\PropertiesProviders\FileSystemPropertiesProvider;

class BlobExtractor {

    // region -- CONSTANTS --
    // endregion

    // region -- MEMBERS --

    private $portofinoBlobsPath;

    // endregion

    // region -- GETTERS/SETTERS --
    // endregion

    // region -- METHODS --

    public function __construct($portofinoBlobsPath) {
        $this->portofinoBlobsPath = $portofinoBlobsPath;
    }

    public function getBlobMetadata($blobCode) {
        $propertiesProvider = new FileSystemPropertiesProvider($this->getBlobMetadataCompleteFilePath($blobCode));
        $metadata = new BlobMetadata();

        $metadata->setFilename($propertiesProvider->get('filename'));
        $metadata->setCode($propertiesProvider->get('code'));
        $metadata->setContentType($propertiesProvider->get('content.type'));
        $metadata->setCreateTimestamp($propertiesProvider->get('create.timestamp'));
        $metadata->setSizeBytes((int)$propertiesProvider->get('size'));

        return $metadata;
    }

    private function getBlobMetadataCompleteFilePath($blobCode) {
        return $this->portofinoBlobsPath . DIRECTORY_SEPARATOR . $this->getBlobMetadataCompleteFilename($blobCode);
    }

    private function getBlobMetadataCompleteFilename($blobCode) {
        return 'blob-' . $blobCode . '.properties';
    }

    public function getBlobData($blobCode) {
        $filename = $this->getBlobDataCompleteFilePath($blobCode);

        if (!file_exists($filename))
            throw new \Exception('file [' . $filename . '] does not exist or I cannot read it');

        $handle = fopen($filename, "rb");

        if (!$handle)
            throw new \Exception('Error opening file [' . $filename . ']');

        $contents = fread($handle, filesize($filename));
        fclose($handle);

        return $contents;
    }

    private function getBlobDataCompleteFilePath($blobCode) {
        return $this->portofinoBlobsPath . DIRECTORY_SEPARATOR . $this->getBlobDataCompleteFilename($blobCode);
    }

    private function getBlobDataCompleteFilename($blobCode) {
        return 'blob-' . $blobCode . '.data';
    }

    // endregion

}