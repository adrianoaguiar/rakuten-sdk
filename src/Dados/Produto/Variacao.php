<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Produto;

use Rakuten\Exceptions\ParameterInvalidException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Variacao
 */
class Variacao
{
    /**
     * A variação de produto pode seguir
     * muitas possibilidades. Nesse caso,
     * quantos níveis de variação forem
     * necessários poderão ser criados no
     * shopping. Para isso, o campo Variação
     * (que representa o tipo de variação) e
     * o valor podem se repetir quantas
     * vezes forem necessárias. Por exemplo,
     * se o produto tiver variação de cor e
     * voltagem, deverão ser usados 4
     * campos. Na variação colocado COR,
     * no segundo campo por exemplo
     * VERDE, no terceiro campo VOLTAGEM
     * e no quarto campo 220v.
     *
     * @var string
     */
    private $nome;

    /**
     * O valor da variação já definida. Esse
     * campo deve sempre andar em pares
     * com o campo anterior, de variação
     *
     * @var string
     */
    private $valor;

    /**
     * Nome da Variação
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Nome da Variação
     *
     * @param string $nome
     */
    public function setNome($nome)
    {
        if (strlen($nome) > 255) {
            throw new ParameterInvalidException('Nome da variação deve ter no máximo 255 caracteres');
        }
        $this->nome = $nome;

        return $this;
    }

    /**
     * Valor da Variação
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Valor da Variação
     *
     * @param string $valor
     */
    public function setValor($valor)
    {
        if (strlen($valor) > 255) {
            throw new ParameterInvalidException('Valor da variação deve ter no máximo 255 caracteres');
        }
        $this->valor = $valor;

        return $this;
    }
}
