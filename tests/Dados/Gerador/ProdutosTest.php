<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Test\Dados\Gerador;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Gerador\Produtos;
use Rakuten\Dados\Produto\Produto;

class ProdutosTest extends TestCase
{
    protected $data;

    public function setUp()
    {
        $this->data = new Produtos();
    }

    public function testSemProduto()
    {
        $this->assertEquals(0, $this->data->getProdutos()->count());
    }

    public function testNovoProduto()
    {
        $produto = new Produto();
        $this->data->addProduto($produto);
        $this->assertEquals(1, $this->data->getProdutos()->count());
    }

    public function testProdutoNotExist()
    {
        $this->assertFalse($this->data->hasProduto());
    }

    public function testProdutoExist()
    {
        $produto = new Produto();
        $this->data->addProduto($produto);
        $this->assertTrue($this->data->hasProduto());
    }
}
