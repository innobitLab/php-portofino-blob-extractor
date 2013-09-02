<?php

namespace PortofinoBlobExtractor\PropertiesProviders;


class InMemoryPropertiesProvider extends TextPropertiesProvider {

    // region -- CONSTANTS --
    // endregion

    // region -- MEMBERS --

    private $itsContent;

    // endregion

    // region -- GETTERS/SETTERS --
    // endregion

    // region -- METHODS --

    public function __construct($content) {
        $this->itsContent = $content;
    }

    public function getContent() {
        return $this->itsContent;
    }

    // endregion

}