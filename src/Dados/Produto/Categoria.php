<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Produto;

use Rakuten\Exceptions\ParameterInvalidException;

/**
 * Class Categoria
 */
class Categoria
{
    /**
     * Código da Categoria do Lojista
     *
     * Este código é utilizado para que você
     * identifique a categoria na sua empresa.
     * Quando se tem uma integração e os
     * pedidos ao serem enviados para a
     * integração, as categorias dos mesmos serão
     * identificadas com esse código.
     *
     * @var string
     */
    private $codigo;

    /**
     * Nome da Categoria
     *
     * A categoria do produto, incluindo todos os
     * níveis da Árvore de Navegação. Para que
     * sua categoria seja indexada corretamente é
     * importante que seja sempre usado o
     * caracter " > " para separar os níveis da sua
     * árvore de categorias. Procure sempre usar
     * com espaços antes e depois do caracter.
     *
     * @var string
     */
    private $nome;

    /**
     * @param string $newcodigo
     */
    public function setCodigo($codigo)
    {
        if (strlen($codigo) > 25) {
            throw new ParameterInvalidException('O Código da categoria deve ter no máximo 25 caracteres');
        }
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $newnome
     */
    public function setNome($nome)
    {
        if (strlen($nome) > 1000) {
            throw new ParameterInvalidException('O Nome da categoria deve ter no máximo 1000 caracteres');
        }
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
}
