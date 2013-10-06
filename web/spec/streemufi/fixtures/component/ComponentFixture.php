<?php
namespace spec\streemufi\fixtures\component;

use streemufi\web\StreemufiModule;
use watoki\curir\Response;
use watoki\factory\Factory;
use watoki\scrut\Fixture;
use watoki\scrut\Specification;

abstract class ComponentFixture extends Fixture {

    protected $model;

    protected $component;

    abstract protected function getComponentClass();

    public function __construct(Specification $spec, Factory $factory, StreemufiModule $root) {
        parent::__construct($spec, $factory);

        $this->component = $factory->getInstance($this->getComponentClass(), array(
            'parent' => $root
        ));
    }

    public function thenIShouldBeRedirectedTo($url) {
        $this->spec->assertNull($this->model);
        $this->spec->assertEquals($url,
            $this->component->getResponse()->getHeaders()->get(Response::HEADER_LOCATION));
    }

    public function thenIShouldNotBeRedirected() {
        $this->spec->assertFalse(
            $this->component->getResponse()->getHeaders()->has(Response::HEADER_LOCATION), 'Was redirected');
    }

    protected function getFieldIn($string, $field) {
        foreach (explode('/', $string) as $key) {
            if (!is_array($field) || !array_key_exists($key, $field)) {
                throw new \Exception("Could not find '$key' in " . json_encode($field));
            }
            $field = $field[$key];
        }
        return $field;
    }

    protected function getField($string) {
        return $this->getFieldIn($string, $this->model);
    }

} 