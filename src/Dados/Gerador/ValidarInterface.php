<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Gerador;

/**
 * Validar produtos
 */
interface ValidarInterface
{
    /**
     * Valida os produtos e retorna um exception casso de erro.
     * @param  Produtos $produtos
     * @return boolean
     */
    public function isValido(Produtos $produtos);
}
