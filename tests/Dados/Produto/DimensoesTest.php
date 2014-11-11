<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Tests\Dados\Produto;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Produto\Dimensoes;

class DimensoesTest extends TestCase
{
    protected $data;

    /**
     * Inicializa antes de cada teste.
     */
    public function setUp()
    {
        $this->data = new Dimensoes();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Rakuten\Dados\Produto\Dimensoes', $this->data);
    }

    public function dataProviderPeso()
    {
        return array(
            array(10.51, 10.51),
            array('10.51', 10.51),
            array('15.210,54', 15210.54),
            array('0.01', 0.01),
            array('0.1', 0.1),
            array('0', 0),
            array('a', 0),
        );
    }

    /**
     * @dataProvider dataProviderPeso
     */
    public function testPeso($peso, $expected)
    {
        $this->data->setPeso($peso);
        $this->assertEquals($expected, $this->data->getPeso());
        $this->assertInternalType('float', $this->data->getPeso());
    }

    public function dataProviderDimensao()
    {
        return array(
            array(1, 1),
            array('a', 0),
            array('99', 99),
        );
    }

    /**
     * @dataProvider dataProviderDimensao
     */
    public function testAltura($data, $expected)
    {
        $this->data->setAltura($data);
        $this->assertEquals($expected, $this->data->getAltura());
        $this->assertInternalType('integer', $this->data->getAltura());
    }

    /**
     * @dataProvider dataProviderDimensao
     */
    public function testLargura($data, $expected)
    {
        $this->data->setLargura($data);
        $this->assertEquals($expected, $this->data->getLargura());
        $this->assertInternalType('integer', $this->data->getLargura());
    }

    /**
     * @dataProvider dataProviderDimensao
     */
    public function testProfundidade($data, $expected)
    {
        $this->data->setProfundidade($data);
        $this->assertEquals($expected, $this->data->getProfundidade());
        $this->assertInternalType('integer', $this->data->getProfundidade());
    }
}
