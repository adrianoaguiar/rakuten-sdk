<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Tests\Dados\Produto;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Produto\Variacao;

class VariacaoTest extends TestCase
{
    protected $data;

    public function setUp()
    {
        $this->data = new Variacao();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Rakuten\Dados\Produto\Variacao', $this->data);
    }

    public function testNome()
    {
        $this->data->setNome('nome');
        $this->assertEquals('nome', $this->data->getNome());

        $nome = str_pad('nome', 255, '-');
        $this->data->setNome($nome);
        $this->assertEquals($nome, $this->data->getNome());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Nome da variação deve ter no máximo 255 caracteres
     */
    public function testNomeException()
    {
        $this->data->setNome(str_pad('nome', 256, '-'));
    }

    public function testValor()
    {
        $this->data->setValor('valor');
        $this->assertEquals('valor', $this->data->getValor());

        $valor = str_pad('valor', 255, '-');
        $this->data->setValor($valor);
        $this->assertEquals($valor, $this->data->getValor());
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterInvalidException
     * @expectedExceptionMessage Valor da variação deve ter no máximo 255 caracteres
     */
    public function testValorException()
    {
        $this->data->setValor(str_pad('valor', 256, '-'));
    }
}
