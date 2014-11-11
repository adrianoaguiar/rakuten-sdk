<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Tests\Dados\Produto;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Produto\Produto;

class ProdutosTest extends TestCase
{
    protected $data;

    public function setUp()
    {
        $this->data = new Produto();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Rakuten\Dados\Produto\Produto', $this->data);
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

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Identificador deve ser um valor entre 1 e 3
     */
    public function testidentificadorException()
    {
        $this->data->setIdentificador('4');
    }

    public function testNomeSuccess()
    {
        $this->data->setNome('teste');
        $this->assertEquals('teste', $this->data->getNome());

        $nome = str_pad('teste', 128, 'i');
        $this->data->setNome($nome);
        $this->assertEquals($nome, $this->data->getNome());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Nome do Produto deve ter no máximo 128 caracteres
     */
    public function testNomeException()
    {
        $this->data->setNome(str_pad('teste', 129, 'i'));
    }

    public function testCodigoSuccess()
    {
        $this->data->setCodigo('codigo');
        $this->assertEquals('codigo', $this->data->getCodigo());

        $codigo = str_pad('codigo', 25, '-');
        $this->data->setCodigo($codigo);
        $this->assertEquals($codigo, $this->data->getCodigo());
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

    public function dataProviderStatus()
    {
        return array(
            array('1',  true, 'Teste string 1'),
            array(1,    true, 'Teste integer 1'),
            array(true, true, 'Teste true'),
            array('2',  false, 'Teste string 2'),
            array('3',  false, 'Teste string 3'),
            array(2,  false, 'Teste integer 2'),
            array(false,  false, 'Teste false'),
        );
    }

    /**
     * @dataProvider dataProviderStatus
     */
    public function testStatus($status, $expected, $message)
    {
        $this->data->setStatus($status);
        $this->assertEquals($expected, $this->data->getStatus(), $message);
        $this->assertInternalType('boolean', $this->data->getStatus());
    }

    public function testDescricao()
    {
        $this->data->setDescricao('descricao');
        $this->assertEquals('descricao', $this->data->getDescricao());
    }

    public function testEspecificacao()
    {
        $this->data->setEspecificacao('especificacao');
        $this->assertEquals('especificacao', $this->data->getEspecificacao());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage O tipo do produto deve ser sempre 1
     */
    public function testTipoException()
    {
        $this->assertEquals(1, $this->data->getTipo());

        $this->data->setTipo(1);
        $this->assertEquals(1, $this->data->getTipo());

        $this->data->setTipo(2);
    }

    public function testLimitarQuantidade()
    {
        $this->data->setLimitarQuantidade(1);
        $this->assertEquals(1, $this->data->getLimitarQuantidade());
        $this->assertInternalType('integer', $this->data->getLimitarQuantidade());
    }

    public function dataProviderYoutube()
    {
        return array(
            array('http://www.youtube.com/watch?v=koyjj87QbXg', 'http://www.youtube.com/watch?v=koyjj87QbXg'),
            array('http://youtu.be/koyjj87QbXg', 'http://youtu.be/koyjj87QbXg'),
            array('http://youtube.com/v/koyjj87QbXg', 'http://youtube.com/v/koyjj87QbXg'),
            array('http://youtube.com/vi/koyjj87QbXg', 'http://youtube.com/vi/koyjj87QbXg'),
            array('http://youtube.com/?v=koyjj87QbXg', 'http://youtube.com/?v=koyjj87QbXg'),
            array('http://youtube.com/?vi=koyjj87QbXg', 'http://youtube.com/?vi=koyjj87QbXg'),
            array('http://youtube.com/watch?v=koyjj87QbXg', 'http://youtube.com/watch?v=koyjj87QbXg'),
            array('http://youtube.com/watch?vi=koyjj87QbXg', 'http://youtube.com/watch?vi=koyjj87QbXg'),
            array('<iframe width="420" height="315" src="//www.youtube.com/embed/koyjj87QbXg" frameborder="0" allowfullscreen></iframe>', '<iframe width="420" height="315" src="//www.youtube.com/embed/koyjj87QbXg" frameborder="0" allowfullscreen></iframe>'),
        );
    }

    /**
     * @dataProvider dataProviderYoutube
     */
    public function testYoutbe($video, $expected)
    {
        $this->data->setVideo($video);
        $this->assertEquals($expected, $this->data->getVideo());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Não foi possível detectar que esta é uma url do YouTube
     */
    public function testYoutbeException()
    {
        $this->data->setVideo('http://vimeo.com/31204910');
    }

    public function testCategoria()
    {
        $this->data->setCategoria(new \Rakuten\Dados\Produto\Categoria());
        $this->assertInstanceOf('\Rakuten\Dados\Produto\Categoria', $this->data->getCategoria());
    }

    public function testMarca()
    {
        $this->data->setMarca('marca');
        $this->assertEquals('marca', $this->data->getMarca());

        $marca = str_pad('marca', 255, '-');
        $this->data->setMarca($marca);
        $this->assertEquals($marca, $this->data->getMarca());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Marca do produto deve ter no máximo 255 caracteres
     */
    public function testMarcaException()
    {
        $this->data->setMarca(str_pad('marca', 256, '-'));
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
    public function testPrecoMinimo($preco, $expected)
    {
        $this->data->setPrecoMinimo($preco);
        $this->assertEquals($expected, $this->data->getPrecoMinimo());
        $this->assertInternalType('float', $this->data->getPrecoMinimo());
    }

    public function dataProviderImagem()
    {
        return array(
            array('imagem/name-ax.jpg', 'imagem/name-ax.jpg'),
            array('imagem/name-ax.jpeg', 'imagem/name-ax.jpeg'),
            array('imagem/name-ax.JPG', 'imagem/name-ax.JPG'),
            array('imagem/name-ax.JPEG', 'imagem/name-ax.JPEG'),
            array('imagem/name-ax.gif', 'imagem/name-ax.gif'),
            array('imagem/name-ax.GIF', 'imagem/name-ax.GIF'),
        );
    }

    /**
     * @dataProvider dataProviderImagem
     */
    public function testImagem($image, $expected)
    {
        $this->data->setImagem($image);
        $this->assertEquals($expected, $this->data->getImagem());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage A imagem deve ser jpg, jpeg ou gif
     */
    public function testImagemException()
    {
        $this->data->setImagem('imagem/semjpg');
    }

    public function testPrazoAdicional()
    {
        $this->assertEquals(0, $this->data->getPrazoAdicional());

        $this->data->setPrazoAdicional(5);
        $this->assertEquals(5, $this->data->getPrazoAdicional());
    }

    public function testSubProduto()
    {
        $this->assertFalse($this->data->hasSubProduto());
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $this->data->getSubProduto());
        $this->assertEquals(0, $this->data->getSubProduto()->count());

        $subProduto = new \Rakuten\Dados\Produto\SubProduto();
        $this->data->addSubProduto($subProduto);

        $this->assertTrue($this->data->hasSubProduto());
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $this->data->getSubProduto());
        $this->assertEquals(1, $this->data->getSubProduto()->count());
    }
}
