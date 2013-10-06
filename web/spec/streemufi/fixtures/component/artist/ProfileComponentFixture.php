<?php
namespace spec\streemufi\fixtures\component\artist;

use spec\streemufi\fixtures\component\ComponentFixture;
use streemufi\web\artist\ProfileComponent;

/**
 * @property ProfileComponent component
 * @property ProfileComponent component
 */
class ProfileComponentFixture extends ComponentFixture {

    public function whenIOpenTheProfileOf($key) {
        $this->model = $this->component->doGet($key);
    }

    public function thenHisNameShouldBe($string) {
        $this->spec->assertEquals($string, $this->getField('profile/name'));
    }

    public function thenTheTextShouldBe($string) {
        $this->spec->assertEquals($string, $this->getField('profile/text'));
    }

    public function thenTheContactShouldBeTheText($string) {
        $this->spec->assertEquals($string, $this->getField('profile/contact'));
    }

    public function thenTheVideoUrlShouldBe($string) {
        $this->spec->assertEquals($string, $this->getField('profile/video/url/_'));
        $this->spec->assertEquals($string, $this->getField('profile/video/url/href'));
    }

    protected function getComponentClass() {
        return ProfileComponent::$CLASS;
    }
}