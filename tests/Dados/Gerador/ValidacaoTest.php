<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Test\Dados\Gerador;

use Rakuten\Tests\TestCase;
use Rakuten\Dados\Gerador\Validacao;
use Rakuten\Dados\Gerador\Produtos;
use Rakuten\Dados\Produto\Produto;
use Rakuten\Dados\Produto\SubProduto;
use Rakuten\Dados\Produto\Categoria;

class ValidacaoTest extends TestCase
{
    protected $data;

    protected $produtos;

    protected $produto;

    public function setUp()
    {
        $this->data = new Validacao();
        $this->produtos = new Produtos();
        $this->produto = new Produto();
    }

    public function testValidInstance()
    {
        $this->assertInstanceOf('\Rakuten\Dados\Gerador\Validacao', $this->data);
        $this->assertInstanceOf('\Rakuten\Dados\Gerador\Produtos', $this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não existe produtos
     */
    public function testProdutoNaoExisteException()
    {
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Nome" do produto
     */
    public function testInvalidNomeException()
    {
        $this->produto->setIdentificador(1);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Codigo" do produto
     */
    public function testInvalidCodigoException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Descricao" do produto
     */
    public function testInvalidDescricaoException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Quantidade máxima por venda (LimitarQuantidade)" do produto
     */
    public function testInvalidLimitarQuantidadeException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Categoria" do produto
     */
    public function testInvalidCategoriaException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Codigo da categoria" do produto
     */
    public function testInvalidCategoriaCodigoException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $categoria = new \Rakuten\Dados\Produto\Categoria();
        $this->produto->setCategoria($categoria);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Nome da categoria" do produto
     */
    public function testInvalidCategoriaNomeException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $categoria = new \Rakuten\Dados\Produto\Categoria();
        $categoria->setCodigo('X15');
        $this->produto->setCategoria($categoria);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Marca" do produto
     */
    public function testInvalidMarcaException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $categoria = new \Rakuten\Dados\Produto\Categoria();
        $categoria->setCodigo('X15');
        $categoria->setNome('Nome Categoria');
        $this->produto->setCategoria($categoria);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Preço mínimo" do produto
     */
    public function testInvalidPrecoMinimoException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $categoria = new \Rakuten\Dados\Produto\Categoria();
        $categoria->setCodigo('X15');
        $categoria->setNome('Nome Categoria');
        $this->produto->setCategoria($categoria);
        $this->produto->setMarca('marca');
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Imagem padrão" do produto
     */
    public function testInvalidImagemException()
    {
        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $categoria = new \Rakuten\Dados\Produto\Categoria();
        $categoria->setCodigo('X15');
        $categoria->setNome('Nome Categoria');
        $this->produto->setCategoria($categoria);
        $this->produto->setMarca('marca');
        $this->produto->setPrecoMinimo(1.00);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }
}
