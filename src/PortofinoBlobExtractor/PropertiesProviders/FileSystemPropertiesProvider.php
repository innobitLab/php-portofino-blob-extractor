<?php

namespace PortofinoBlobExtractor\PropertiesProviders;


class FileSystemPropertiesProvider extends TextPropertiesProvider {

    // region -- CONSTANTS --
    // endregion

    // region -- MEMBERS --

    protected $itsFilename;

    // endregion

    // region -- GETTERS/SETTERS --
    // endregion

    // region -- METHODS --

    public function __construct($filename) {
        $this->itsFilename = $filename;
    }

    protected function getContent() {
        return file_get_contents($this->itsFilename);
    }

    // endregion

}