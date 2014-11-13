<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Gerador;

use Rakuten\Exceptions\ParameterNotFoundException;
use Rakuten\Dados\Produto\Produto;
use Rakuten\Dados\Produto\SubProduto;

/**
 *
 */
class Validacao implements ValidarInterface
{
    protected $_error = 'Não foi informado o "%s" do produto';

    /**
     * Verificar se produtos são validos
     */
    public function isValido(Produtos $produtos)
    {
        if (!$produtos->hasProduto()) {
            throw new ParameterNotFoundException('Não existe produtos');
        }

        foreach ($produtos->getProdutos() as $produto) {
            $this->validar($produto);
        }
    }

    /**
     * Validar produto dependendo do identificador
     */
    private function validar(Produto $produto)
    {
        if ($produto->getIdentificador() === 1) {
            $this->validarProduto($produto);
        }
    }

    /**
     * Verificar campos necessario do produto
     */
    private function validarProduto(Produto $produto)
    {
        if (is_null($produto->getNome())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Nome'));
        }

        if (is_null($produto->getCodigo())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Codigo'));
        }

        if (is_null($produto->getDescricao())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Descricao'));
        }

        if ($produto->getLimitarQuantidade() === 0) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Quantidade máxima por venda (LimitarQuantidade)'));
        }

        if (!$produto->getCategoria() instanceof \Rakuten\Dados\Produto\Categoria) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Categoria'));
        }

        if (is_null($produto->getCategoria()->getCodigo())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Codigo da categoria'));
        }

        if (is_null($produto->getCategoria()->getNome())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Nome da categoria'));
        }

        if (is_null($produto->getMarca())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Marca'));
        }

        if ($produto->getPrecoMinimo() <= 0) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Preço mínimo'));
        }

        if (is_null($produto->getImagem())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Imagem padrão'));
        }

        if (!$produto->hasSubProduto()) {
            throw new ParameterNotFoundException('O produto deve conter pelo menos 1 subproduto, caso o produto não possua variações adicione o mesmo com os campos necessários');
        }

        // validar os subprodutos
        foreach ($produto->getSubProdutos() as $subproduto) {
            $this->validarSubProduto($subproduto);
        }
    }

    private function validarSubProduto(SubProduto $subproduto)
    {
        if (is_null($subproduto->getCodigo())) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Subproduto codigo'));
        }

        if ($subproduto->getPreco() <= 0) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Subproduto preço'));
        }

        if ($subproduto->getEstoque() === 0) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Subproduto estoque'));
        }

        if ($subproduto->getEstoqueMinimo() === 0) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Subproduto estoque mínimo'));
        }

        if (!$subproduto->getDimensoes() instanceof \Rakuten\Dados\Produto\Dimensoes) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Subproduto dimensões'));
        }

        if ($subproduto->getDimensoes()->getPeso() <= 0) {
            throw new ParameterNotFoundException(sprintf($this->_error, 'Subproduto dimensões peso'));
        }

        if ($subproduto instanceof SubProduto && null === $subproduto->getTipo()) {
            throw new ParameterNotFoundException('Deve informar o Tipo de Variação de Imagem');
        }

        if ($subproduto instanceof SubProduto && !$subproduto->hasVariacao()) {
            throw new ParameterNotFoundException('O subproduto deve conter pelomenos 1 variação');
        }
    }
}
