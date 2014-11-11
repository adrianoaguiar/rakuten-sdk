<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Produto;

/**
 * Class Dimensoes
 */
class Dimensoes extends Base
{
    /**
     * Peso do produto que será exibido no
     * detalhe do produto e utilizado no
     * calculo de frete.
     *
     * Caso o cálculo do frete esteja
     * configurado por faixa de peso, este
     * valor será utilizado para calcular o
     * frete
     *
     * Se o peso estiver zerado,
     * o frete será zerado, como um produto
     * que não tem valor de frete.
     *
     * @var float
     */
    private $peso;

    /**
     * Altura do produto que será exibido no
     * detalhe do produto.
     *
     * É bastante importante o
     * preenchimento dessa informação para
     * que o cliente tenha total visibilidade
     * do que está comprando. Essa
     * informação não é relevante
     * dependendo ramo de atividade.
     *
     * @var integer
     */
    private $altura;

    /**
     * Largura do produto que será exibido
     * no detalhe do produto.
     *
     * É bastante importante o
     * preenchimento dessa informação para
     * que o cliente tenha total visibilidade
     * do que está comprando. Essa
     * informação não é relevante
     * dependendo ramo de atividade.
     *
     * @var integer
     */
    private $largura;

    /**
     * Profundidade do produto que será
     * exibido no detalhe do produto.
     *
     * É bastante importante o
     * preenchimento dessa informação para
     * que o cliente tenha total visibilidade
     * do que está comprando. Essa
     * informação não é relevante
     * dependendo ramo de atividade.
     *
     * @var integer
     */
    private $profundidade;

    /**
     * Peso do produto
     *
     * @return float
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Peso do produto
     *
     * @param [string|float $peso
     *
     * @return $this
     */
    public function setPeso($peso)
    {
        $this->peso = $this->convertStringToFloat($peso);

        return $this;
    }

    /**
     * Altura do produto.
     *
     * @return integer
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Altura do produto
     *
     * @param integer $altura
     *
     * @return $this
     */
    public function setAltura($altura)
    {
        $this->altura = (int)$altura;

        return $this;
    }

    /**
     * Largura do produto
     *
     * @return integer
     */
    public function getLargura()
    {
        return $this->largura;
    }

    /**
     * Largura do produto
     *
     * @param integer $largura
     *
     * @return $this
     */
    public function setLargura($largura)
    {
        $this->largura = (int)$largura;

        return $this;
    }

    /**
     * Profundidade do produto
     *
     * @return integer
     */
    public function getProfundidade()
    {
        return $this->profundidade;
    }

    /**
     * Profundidade do produto
     *
     * @param integer $profundidade
     *
     * @return $this
     */
    public function setProfundidade($profundidade)
    {
        $this->profundidade = (int)$profundidade;

        return $this;
    }
}
