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
use Rakuten\Dados\Produto\Dimensoes;
use Rakuten\Dados\Produto\Categoria;

class ValidacaoSubTest extends TestCase
{
    protected $data;

    protected $produtos;

    protected $produto;

    public function setUp()
    {
        $this->data = new Validacao();
        $this->produtos = new Produtos();
        $this->produto = new Produto();
        $this->subproduto = new SubProduto();

        $categoria = new \Rakuten\Dados\Produto\Categoria();
        $categoria->setCodigo('X15');
        $categoria->setNome('Nome Categoria');

        $this->produto->setIdentificador(1);
        $this->produto->setNome('nome');
        $this->produto->setCodigo('X15');
        $this->produto->setStatus(true);
        $this->produto->setDescricao('descricao');
        $this->produto->setTipo(1);
        $this->produto->setLimitarQuantidade(10);
        $this->produto->setMarca('marca');
        $this->produto->setPrecoMinimo(1.00);
        $this->produto->setImagem('imagem/teste.jpg');
        $this->produto->setCategoria($categoria);

    }

    public function testValidInstance()
    {
        $this->assertInstanceOf('\Rakuten\Dados\Gerador\Validacao', $this->data);
        $this->assertInstanceOf('\Rakuten\Dados\Gerador\Produtos', $this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage O produto deve conter pelo menos 1 subproduto, caso o produto não possua variações adicione o mesmo com os campos necessários
     */
    public function testInvalidSubProdutoException()
    {
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Subproduto codigo" do produto
     */
    public function testInvalidSubProdutoIdentificadorException()
    {
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Subproduto preço" do produto
     */
    public function testInvalidSubProdutoPrecoException()
    {
        $this->subproduto->setCodigo('X16');
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Subproduto estoque" do produto
     */
    public function testInvalidSubProdutoEstoqueException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Subproduto estoque mínimo" do produto
     */
    public function testInvalidSubProdutoEstoqueMinimoException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Subproduto dimensões" do produto
     */
    public function testInvalidSubProdutoDimensoesException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->subproduto->setEstoqueMinimo(2);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Não foi informado o "Subproduto dimensões peso" do produto
     */
    public function testInvalidSubProdutoDimensoesPesoException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->subproduto->setEstoqueMinimo(2);
        $dimensoes = new Dimensoes();
        $this->subproduto->setDimensoes($dimensoes);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Deve informar o Tipo de Variação de Imagem
     */
    public function testInvalidSubProdutoTipoException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->subproduto->setEstoqueMinimo(2);
        $dimensoes = new Dimensoes();
        $dimensoes->setPeso(1.20);
        $this->subproduto->setDimensoes($dimensoes);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage O subproduto deve conter pelomenos 1 variação
     */
    public function testInvalidSubProdutoVariacaoException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->subproduto->setEstoqueMinimo(2);
        $dimensoes = new Dimensoes();
        $dimensoes->setPeso(1.20);
        $this->subproduto->setTipo('Cor');
        $this->subproduto->setDimensoes($dimensoes);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    /**
     * @expectedException \Rakuten\Exceptions\ParameterNotFoundException
     * @expectedExceptionMessage Deve informar o Tipo de Variação de Imagem
     */
    public function testInvalidSubProdutoCloneException()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->subproduto->setEstoqueMinimo(2);
        $dimensoes = new Dimensoes();
        $dimensoes->setPeso(1.20);
        $this->subproduto->setTipo('Cor');
        $this->subproduto->setDimensoes($dimensoes);
        $this->produto->addSubProduto(clone $this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }

    public function testProduto()
    {
        $this->subproduto->setCodigo('X16');
        $this->subproduto->setPreco(2.00);
        $this->subproduto->setEstoque(5);
        $this->subproduto->setEstoqueMinimo(2);
        $dimensoes = new Dimensoes();
        $dimensoes->setPeso(1.20);
        $this->subproduto->setTipo('Cor');
        $variacao = new \Rakuten\Dados\Produto\Variacao;
        $this->subproduto->addVariacao($variacao);
        $this->subproduto->setDimensoes($dimensoes);
        $this->produto->addSubProduto($this->subproduto);
        $this->produtos->addProduto($this->produto);
        $this->data->isValido($this->produtos);
    }
}
