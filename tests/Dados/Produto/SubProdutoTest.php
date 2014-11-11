<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Tests\Dados\Produto;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Produto\SubProduto;

class SubProdutoTest extends TestCase
{

    protected $data;

    /**
     * Inicializa antes de cada teste.
     */
    public function setUp()
    {
        $this->data = new SubProduto();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Rakuten\Dados\Produto\SubProduto', $this->data);
    }

    public function testIdentificador1()
    {
        $this->data->setIdentificador('1');
        $this->assertEquals(1, $this->data->getIdentificador());
        $this->assertInternalType('int', $this->data->getIdentificador());
    }

    public function testIdentificador2()
    {
        $this->data->setIdentificador(2);
        $this->assertEquals(2, $this->data->getIdentificador());
        $this->assertInternalType('int', $this->data->getIdentificador());
    }

    public function testIdentificador3()
    {
        $this->data->setIdentificador('3');
        $this->assertEquals(3, $this->data->getIdentificador());
        $this->assertInternalType('int', $this->data->getIdentificador());
    }

    public function dataProviderCodigo()
    {
        return array(
            array(str_pad('codigo', 26, '-')),
            array('12&34'),
            array('12 34'),
            array('12?34'),
        );
    }

    /**
     * @dataProvider dataProviderCodigo
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Código Interno do Produto deve ter no máximo 25 caracteres
     */
    public function testCodigoException($codigo)
    {
        $this->data->setCodigo($codigo);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Identificador deve ser um valor entre 1 e 3
     */
    public function testidentificadorException()
    {
        $this->data->setIdentificador('4');
    }

    public function dataProviderPreco()
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
     * @dataProvider dataProviderPreco
     */
    public function testPreco($preco, $expected)
    {
        $this->data->setPreco($preco);
        $this->assertEquals($expected, $this->data->getPreco());
        $this->assertInternalType('float', $this->data->getPreco());
    }

    /**
     * @dataProvider dataProviderPreco
     */
    public function testPrecoPromocional($preco, $expected)
    {
        $this->data->setPrecoPromocional($preco);
        $this->assertEquals($expected, $this->data->getPrecoPromocional());
        $this->assertInternalType('float', $this->data->getPrecoPromocional());
    }

    public function dataProviderEstoque()
    {
        return array(
            array('1', 1),
            array(2, 2),
            array(2000, 2000),
            array('999999999', 999999999),
        );
    }

    /**
     * @dataProvider dataProviderEstoque
     */
    public function testEstoque($data, $expected)
    {
        $this->data->setEstoque($data);
        $this->assertEquals($expected, $this->data->getEstoque());
        $this->assertInternalType('integer', $this->data->getEstoque());
    }

    public function dataProviderEstoqueException()
    {
        return array(
            array(1000000000),
            array('a'),
            array(0),
            array('0'),
        );
    }

    /**
     * @dataProvider dataProviderEstoqueException
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage O estoque deve ser entre 1 e 999999999
     */
    public function testEstoqueException($value)
    {
        $this->data->setEstoque($value);
    }

    /**
     * @dataProvider dataProviderEstoque
     */
    public function testEstoqueMinimo($data, $expected)
    {
        $this->data->setEstoqueMinimo($data);
        $this->assertEquals($expected, $this->data->getEstoqueMinimo());
        $this->assertInternalType('integer', $this->data->getEstoqueMinimo());
    }

    /**
     * @dataProvider dataProviderEstoqueException
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage O estoque deve ser entre 1 e 999999999
     */
    public function testEstoqueMinimoException($value)
    {
        $this->data->setEstoqueMinimo($value);
    }

    public function dataProviderBoolean()
    {
        return array(
            array('1', true),
            array(1, true),
            array(true, true),
            array('0', false),
            array(0, false),
            array(false, false),
            array('a', false),
            array('n', false),
        );
    }

    /**
     * @dataProvider dataProviderBoolean
     */
    public function testFreteGratis($value, $expected)
    {
        $this->data->setFreteGratis($value);
        $this->assertEquals($expected, $this->data->getFreteGratis());
    }

    public function testDimensoes()
    {
        $this->data->setDimensoes(new \Rakuten\Dados\Produto\Dimensoes());
        $this->assertInstanceOf('\Rakuten\Dados\Produto\Dimensoes', $this->data->getDimensoes());
    }

    /**
     * @dataProvider dataProviderBoolean
     */
    public function testSku($value, $expected)
    {
        $this->data->setSku($value);
        $this->assertEquals($expected, $this->data->getSku());
    }

    public function testIsbm()
    {
        $this->data->setIsbm(1);
        $this->assertEquals(1, $this->data->getIsbm());

        $this->data->setIsbm('12');
        $this->assertEquals(12, $this->data->getIsbm());

        $this->data->setIsbm('a');
        $this->assertEquals(0, $this->data->getIsbm());
    }

    public function testModelo()
    {
        $this->data->setModelo('modelo');
        $this->assertEquals('modelo', $this->data->getModelo());

        $modelo = str_pad('modelo', 255, '-');
        $this->data->setModelo($modelo);
        $this->assertEquals($modelo, $this->data->getModelo());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Modelo do produto deve ter no máximo 255 caracteres
     */
    public function testModeloException()
    {
        $this->data->setModelo(str_pad('marca', 256, '-'));
    }

    public function testVariacao()
    {
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $this->data->getVariacao());

        $this->assertEquals(0, $this->data->getVariacao()->count());

        $variacao = new \Rakuten\Dados\Produto\Variacao();
        $this->data->addVariacao($variacao);

        $this->assertEquals(1, $this->data->getVariacao()->count());
        $this->assertEquals($variacao, $this->data->getVariacao()->get(0));

        $this->data->clearVariacao();
        $this->assertEquals(0, $this->data->getVariacao()->count());
    }

    public function testTipo()
    {
        $this->data->setTipo('tipo');
        $this->assertEquals('tipo', $this->data->getTipo());

        $tipo = str_pad('tipo', 255, '-');
        $this->data->setTipo($tipo);
        $this->assertEquals($tipo, $this->data->getTipo());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Tipo da variação deve ter no máximo 255 caracteres
     */
    public function testTipoException()
    {
        $this->data->setTipo(str_pad('tipo', 256, '-'));
    }

    public function testImagem()
    {
        $this->assertFalse($this->data->hasImagem());
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $this->data->getImagem());

        $this->data->addImagem('imagem/imagem1.jpg');
        $this->assertEquals(1, $this->data->getImagem()->count());
        $this->assertEquals('imagem/imagem1.jpg', $this->data->getImagem()->get(0));

        $this->data->addImagem('imagem/imagem2.JPG');
        $this->assertEquals(2, $this->data->getImagem()->count());
        $this->assertEquals('imagem/imagem2.JPG', $this->data->getImagem()->get(1));

        $this->assertTrue($this->data->hasImagem());
        $this->data->clearImagem();
        $this->assertFalse($this->data->hasImagem());

    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage A imagem deve ser jpg, jpeg ou gif
     */
    public function testImagemException()
    {
        $this->data->addImagem('imagem/semjpg');
    }
}
