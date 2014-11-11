<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Produto;

use Rakuten\Exceptions\ParameterInvalidException;

/**
 * Class Base
 */
abstract class Base
{
    /**
     * O número 1 é o identificador que a linha em questao é referente a um cadastro de produto.
     * A linha com o inicio 2 é referente a um de produto (cores, tamanhos, voltagens, etc. Um SKU).
     *
     *  1 - Cadastro de produto
     *  2 - Variação de um produto
     *
     * @var integer
     */
    private $identificador;

    /**
     * Código Interno.
     *
     * Este código é utilizado para que você
     * identifique o produto na sua empresa.
     * Quando se tem uma integração e os
     * pedidos ao serem enviados para a
     * integração, serão identificados com esse
     * código.
     *
     ******************************************
     *
     * Part Number do produto. O
     * PartNumber é um número interno que
     * identifica a variação de cada produto.
     * Importante: Este número precisa ser
     * único e não pode ser igual ao código
     * interno de outro produto.
     *
     * @var string
     */
    private $codigo;

    /**
     * Identificador 1,2 ou 3
     *
     * @return integer
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * @param integer $identificador Valores válido 1, 2 ou 3
     *
     * @return $this
     */
    public function setIdentificador($identificador)
    {
        settype($identificador, 'integer');
        if (preg_match('/^([1-3]+)$/', $identificador) === 0) {
            throw new ParameterInvalidException('Identificador deve ser um valor entre 1 e 3');
        }
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * identificador = 1 - Código Interno.
     * identificador = 2 - Part Number do produto.
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * identificador = 1 - Código Interno.
     * identificador = 2 - Part Number do produto.
     *
     * @param string $codigo
     *
     * @return $this
     */
    public function setCodigo($codigo)
    {
        if (strlen($codigo) > 25 || preg_match('/( |&|\?)/', $codigo)) {
            throw new ParameterInvalidException('Código Interno do Produto deve ter no máximo 25 caracteres');
        }
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @param  string|float  $string
     *
     * @return boolean
     */
    protected function convertStringToFloat($string)
    {
        if (is_string($string) && strpos($string, ',') !== false) {
            $string = str_replace(array('.', ','), array('', '.'), $string);
        }
        return (float)number_format((float)$string, 2, '.', '');
    }
}
