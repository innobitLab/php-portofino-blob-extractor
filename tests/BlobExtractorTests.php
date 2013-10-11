<?php

require_once 'bootstrap.php';

class BlobExtractorTests extends PHPUnit_Framework_TestCase {

    public function test_can_read_properties_from_memory() {
        $content = '#Blob metadata
#Mon Jul 29 14:52:31 CEST 2013
filename=bianco del pradel_b.jpg
create.timestamp=2013-07-29T14\:52\:31.840+02\:00
size=87828
code=15r7d9lusfjua0pqv2nxbxr2h
content.type=image/jpeg';

        $propertiesProvider = new \PortofinoBlobExtractor\PropertiesProviders\InMemoryPropertiesProvider($content);
        $this->assertTestProperties($propertiesProvider);
    }

    public function test_can_read_properties_from_filesystem() {
        $file = __DIR__ . '/testData/blob-15r7d9lusfjua0pqv2nxbxr2h.properties';
        $propertiesProvider = new \PortofinoBlobExtractor\PropertiesProviders\FileSystemPropertiesProvider($file);
        $this->assertTestProperties($propertiesProvider);
    }

    private function assertTestProperties($propertiesProvider) {
        $this->assertEquals('bianco del pradel_b.jpg', $propertiesProvider->get('filename'));
        $this->assertEquals('2013-07-29T14\:52\:31.840+02\:00', $propertiesProvider->get('create.timestamp'));
        $this->assertEquals('87828', $propertiesProvider->get('size'));
        $this->assertEquals('15r7d9lusfjua0pqv2nxbxr2h', $propertiesProvider->get('code'));
        $this->assertEquals('image/jpeg', $propertiesProvider->get('content.type'));
    }

    public function test_can_extract_blob() {
        $blobExtractor = new \PortofinoBlobExtractor\BlobExtractor(__DIR__ . '/testData');
        $blobMetadata = $blobExtractor->getBlobMetadata('15r7d9lusfjua0pqv2nxbxr2h');

        $this->assertInstanceOf('\PortofinoBlobExtractor\BlobMetadata', $blobMetadata);
        $this->assertEquals('bianco del pradel_b.jpg', $blobMetadata->getFilename());
        $this->assertEquals('2013-07-29T14\:52\:31.840+02\:00', $blobMetadata->getCreateTimestamp());
        $this->assertEquals(87828, $blobMetadata->getSizeBytes());
        $this->assertEquals('15r7d9lusfjua0pqv2nxbxr2h', $blobMetadata->getCode());
        $this->assertEquals('image/jpeg', $blobMetadata->getContentType());
    }

    public function test_can_read_blob_data() {
        $blobExtractor = new \PortofinoBlobExtractor\BlobExtractor(__DIR__ . '/testData');
        $blobData = $blobExtractor->getBlobData('15r7d9lusfjua0pqv2nxbxr2h');
        $blobMetadata = $blobExtractor->getBlobMetadata('15r7d9lusfjua0pqv2nxbxr2h');
        $this->assertEquals($blobMetadata->getSizeBytes(), strlen($blobData));
    }

    /**
     * @expectedException \Exception
     */
    public function test_read_from_wrong_code() {
        $blobExtractor = new \PortofinoBlobExtractor\BlobExtractor(__DIR__ . '/testData');
        $blobData = $blobExtractor->getBlobData('you_cannot_find_me');
        $blobMetadata = $blobExtractor->getBlobMetadata('you_cannot_find_me');
    }

}
