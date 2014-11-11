<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Tests\Dados\Produto;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Produto\Categoria;

class CategoriaTest extends TestCase
{
    protected $data;

    public function setUp()
    {
        $this->data = new Categoria();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Rakuten\Dados\Produto\Categoria', $this->data);
    }

    public function testCodigo()
    {
        $this->data->setCodigo('codigo');
        $this->assertEquals('codigo', $this->data->getCodigo());

        $codigo = str_pad('codigo', 25, '-');
        $this->data->setCodigo($codigo);
        $this->assertEquals($codigo, $this->data->getCodigo());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage O Código da categoria deve ter no máximo 25 caracteres
     */
    public function testeCodigoException()
    {
        $this->data->setCodigo(str_pad('codigo', 26, '-'));
    }

    public function testNome()
    {
        $this->data->setNome('nome');
        $this->assertEquals('nome', $this->data->getNome());

        $nome = str_pad('nome', 1000, '-');
        $this->data->setNome($nome);
        $this->assertEquals($nome, $this->data->getNome());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage O Nome da categoria deve ter no máximo 1000 caracteres
     */
    public function testNomeException()
    {
        $this->data->setNome(str_pad('nome', 1001, '-'));
    }
}
