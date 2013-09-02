<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tondi
 * Date: 02/09/13
 * Time: 16:36
 */

namespace PortofinoBlobExtractor;


class BlobMetadata {

    private $filename;
    private $createTimestamp;
    private $sizeBytes;
    private $code;
    private $contentType;

    public function getCode() {
        return $this->code;
    }

    public function getContentType() {
        return $this->contentType;
    }

    public function getCreateTimestamp() {
        return $this->createTimestamp;
    }

    public function getFilename() {
        return $this->filename;
    }

    public function getSizeBytes() {
        return $this->sizeBytes;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    public function setCreateTimestamp($createDateTime) {
        $this->createTimestamp = $createDateTime;
    }

    public function setFilename($filename) {
        $this->filename = $filename;
    }

    public function setSizeBytes($sizeBytes) {
        $this->sizeBytes = $sizeBytes;
    }

}