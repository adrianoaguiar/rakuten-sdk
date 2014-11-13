<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Gerador;

use Rakuten\Dados\Produto\Produto;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Produtos
 */
class Produtos
{
    /**
     * Produtos
     *
     * @var ArrayCollection
     */
    private $produtos;

    /**
     *
     */
    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }

    /**
     * Adicionar produto
     *
     * @param Produto $produtos
     *
     * @return $this
     */
    public function addProduto(Produto $produto)
    {
        $this->produtos->add($produto);

        return $this;
    }

    /**
     * Retornar produtos
     *
     * @return ArrayCollection
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Verificar se existe produtos
     *
     * @return boolean
     */
    public function hasProduto()
    {
        return ! $this->produtos->isEmpty();
    }
}
