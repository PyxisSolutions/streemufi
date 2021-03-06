<?php
namespace spec\streemufi\artist;

use spec\streemufi\fixtures\component\artist\ArtistResourceFixture;
use spec\streemufi\fixtures\model\ArtistFixture;
use watoki\scrut\Specification;

/**
 * @property ArtistFixture artist <-
 * @property ArtistResourceFixture component <-
 */
class ArtistProfileTest extends Specification {

    function testNonExistingArtist() {
        $this->component->whenIOpenTheProfileOf('NotHere');
        $this->component->thenIShouldBeRedirectedTo('../artists');
    }

    function testExistingArtist() {
        $this->artist->givenTheArtist_WithTheKey('El Barto', 'Bart');
        $this->artist->given_HasThe_('Bart', 'location', 'Moritzplatz');
        $this->artist->given_HasThe_('Bart', 'text', 'Some text here can be whatever');
        $this->artist->given_HasThe_('Bart', 'contact', '0171 23456789');
        $this->artist->given_HasThe_('Bart', 'video', 'http://www.youtube.com/watch?v=oMyG0d');

        $this->component->whenIOpenTheProfileOf('Bart');

        $this->component->thenIShouldNotBeRedirected();
        $this->component->thenHisNameShouldBe('El Barto');
        $this->component->thenTheTextShouldBe('Some text here can be whatever');
        $this->component->thenTheContactShouldBeTheText('0171 23456789');
        $this->component->thenTheVideoUrlShouldBe('http://www.youtube.com/watch?v=oMyG0d');
    }

    function testEmbeddedVideo() {
        $this->artist->givenTheArtist_WithTheKey('El Barto', 'Bart');
        $this->artist->given_HasThe_('Bart', 'video', 'http://www.youtube.com/watch?v=oMyG0d');

        $this->component->whenIOpenTheProfileOf('Bart');

        $this->component->thenTheVideoShouldBeEmbeddedWith('https://www.youtube-nocookie.com/embed/oMyG0d?wmode=opaque');
    }

    function testUrlAsContact() {
        $this->artist->givenTheArtist_WithTheKey('El Barto', 'Bart');
        $this->artist->given_HasThe_('Bart', 'contact', 'http://example.com');

        $this->component->whenIOpenTheProfileOf('Bart');

        $this->component->thenTheContact_ShouldLinkTo('http://example.com', 'http://example.com');
    }

    function testEmailAsContact() {
        $this->artist->givenTheArtist_WithTheKey('El Barto', 'Bart');
        $this->artist->given_HasThe_('Bart', 'contact', 'bart@simpson.com');

        $this->component->whenIOpenTheProfileOf('Bart');

        $this->component->thenTheContact_ShouldLinkTo('bart@simpson.com', 'mailto:bart@simpson.com');
    }

} 