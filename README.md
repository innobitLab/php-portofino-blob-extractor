php-portofino-blob-extractor
============================
A simple php library for access Portofino 4 blob files and metadata

## Installation ##

### Composer ###

You can install `innobitlab/php-portofino-blob-extractor` using [composer](http://getcomposer.org/) Dependency Manager.

If you need information about installing composer: [http://getcomposer.org/doc/00-intro.md#installation-nix](http://getcomposer.org/doc/00-intro.md#installation-nix)

Add this to your composer.json file:

	{
    	"require": {
        	"innobitlab/php-portofino-blob-extractor": "dev-master"
    	}
	}

## Usage ##

    use \PortofinoBlobExtractor\BlobExtractor;

    $blobExtractor = new BlobExtractor('path/to/portofino/blobs/dir');

    // get the blob data bytes
    $blobData = $blobExtractor->getBlobData('blobcode');

    // get the blob metadata in a easy to use BlobMetadata object
    $blobMetadata = $blobExtractor->getBlobMetadata('blobcode');