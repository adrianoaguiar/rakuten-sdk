<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Produto;

use Rakuten\Exceptions\ParameterInvalidException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class SubProduto
 */
class SubProduto extends Detalhes
{
    /**
     * Nesse campo deverá ser preenchido
     * qual a variação existente no produto.
     * Sempre que um produto tiver alguma
     * variação, essa deverá ser identificada
     * nesse campo.
     *
     * Por exemplo, se o produto tiver alguma
     * variação de cor, a palavra Cor deverá
     * ser colocada nesse campo.
     *
     * @var string
     */
    private $tipo;

    /**
     * Variação
     *
     * @var Variacao
     */
    private $variacao;

    /**
     *
     */
    public function __construct()
    {
        $this->variacao = new ArrayCollection();
        parent::__construct();
    }

    /**
     * Tipo da Variação
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Tipo da Variação
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        if (strlen($tipo) > 255) {
            throw new ParameterInvalidException('Tipo da variação deve ter no máximo 255 caracteres');
        }
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Retornar variacao
     *
     * @return ArrayCollection
     */
    public function getVariacao()
    {
        return $this->variacao;
    }

    /**
     * Adicionar Variação
     *
     * @param Variacao $variacao
     */
    public function addVariacao(Variacao $variacao)
    {
        $this->variacao->add($variacao);

        return $this;
    }

    /**
     * Limpar Variações
     *
     * @return $this
     */
    public function clearVariacao()
    {
        $this->variacao->clear();

        return $this;
    }

    /**
     * Verifica se existe variação
     *
     * @return boolean
     */
    public function hasVariacao()
    {
        return $this->variacao->count() > 0;
    }

    /**
     *
     */
    public function __clone()
    {
        $this->tipo = null;
        $this->variacao = new ArrayCollection();
    }
}
