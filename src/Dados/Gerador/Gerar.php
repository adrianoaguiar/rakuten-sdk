<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Gerador;

use Rakuten\Exceptions\ParameterNotFoundException;
use Rakuten\Exceptions\InvalidException;
use Rakuten\Exceptions\Exception;
use Rakuten\Dados\Produto\SubProduto;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Gerar texto
 */
class Gerar
{
    /**
     * Produtos
     *
     * @var Produtos
     */
    private $produtos;

    private $string;

    /**
     * @param Produtos $produtos
     */
    public function __construct(Produtos $produtos = null)
    {
        if (null !== $produtos) {
            $this->setProdutos($produtos);
        }
    }

    /**
     * Get Produtos
     *
     * @return Produtos
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Set Produtos
     *
     * @param Produtos $produtos
     */
    public function setProdutos(Produtos $produtos)
    {
        $this->produtos = $produtos;

        return $this;
    }

    /**
     * Validar produtos
     *
     * @param  ValidarInterface $Validar
     *
     * @return $this
     */
    public function validar(ValidarInterface $validar = null)
    {
        if ($validar === null) {
            $validar = new Validacao();
        }

        $validar->isValido($this->produtos);

        return $this;
    }

    /**
     * Gerar string dos produtos
     *
     * @param  string $string
     */
    private function gerarProduto(&$string)
    {
        foreach ($this->produtos->getProdutos() as $key => $produto) {
            if ($key > 0) {
                $string .= chr(10);
            }
            $string .= sprintf("%s\t", $produto->getIdentificador());
            $string .= sprintf("%s\t", $produto->getNome());
            $string .= sprintf("%s\t", $produto->getCodigo());
            $string .= sprintf("%s\t", $produto->getStatus() ? '1' : '0');
            $string .= sprintf("%s\t", $produto->getDescricao());
            $string .= sprintf("%s\t", $produto->getEspecificacao());
            $string .= sprintf("%s\t", $produto->getTipo());
            $string .= sprintf("%s\t", '0'); //Campo não usado Enviar sempre “0”
            $string .= sprintf("%s\t", $produto->getLimitarQuantidade());
            $string .= sprintf("%s\t", $produto->getVideo());
            $string .= sprintf("%s\t", $produto->getCategoria()->getCodigo());
            $string .= sprintf("%s\t", $produto->getCategoria()->getNome());
            $string .= sprintf("%s\t", $produto->getMarca());
            $string .= sprintf("%.2f\t", $produto->getPrecoMinimo());
            $string .= sprintf("%s\t", $produto->getImagem());
            $string .= sprintf("%s", $produto->getPrazoAdicional());
            $this->gerarSubProduto($produto->getSubProdutos(), $string);
        }
    }

    /**
     * Gerar string dos sub produtos
     *
     * @param ArrayCollection $subprodutos
     * @param  string $string
     */
    private function gerarSubProduto(ArrayCollection $subprodutos, &$string)
    {
        foreach ($subprodutos as $subproduto) {
            $string .= chr(10);
            $string .= sprintf("%s\t", $subproduto->getIdentificador());
            $string .= sprintf("%s\t", $subproduto->getCodigo());
            $string .= sprintf("%.2f\t", $subproduto->getPreco());
            $string .= sprintf("%.2f\t", $subproduto->getPrecoPromocional());
            $string .= sprintf("%s\t", $subproduto->getEstoque());
            $string .= sprintf("%s\t", $subproduto->getEstoqueMinimo());
            $string .= sprintf("%s\t", $subproduto->getFreteGratis());
            $string .= sprintf("%.2f\t", $subproduto->getDimensoes()->getPeso());
            $string .= sprintf("%u\t", $subproduto->getDimensoes()->getAltura());
            $string .= sprintf("%u\t", $subproduto->getDimensoes()->getLargura());
            $string .= sprintf("%u\t", $subproduto->getDimensoes()->getProfundidade());
            $string .= sprintf("%s\t", $subproduto->getSku());
            $string .= sprintf("%u\t", $subproduto->getIsbm());
            $string .= sprintf("%s\t", $subproduto->getEan13());
            $string .= sprintf("%s\t", $subproduto->getModelo());

            if ($subproduto instanceof SubProduto) {
                $string .= sprintf("%s\t", $subproduto->getTipo());
            }

            if ($subproduto->getImagem()->isEmpty()) {
                throw new ParameterNotFoundException('O subproduto deve conter pelomenos 1 imagem');
            }
            for ($x = 0; $x < 6; $x++) {
                if ($subproduto->getImagem()->containsKey($x)) {
                    $string .= sprintf("%s\t", $subproduto->getImagem()->get($x));
                } else {
                    $string .= sprintf("%s\t", $subproduto->getImagem()->get(0));
                }
            }
            if ($subproduto instanceof SubProduto) {
                foreach ($subproduto->getVariacao() as $variacao) {
                    $string .= sprintf(" \t%s\t%s", $variacao->getNome(), $variacao->getValor());
                }
            }
        }
    }

    /**
     * Executar
     *
     * @return string
     */
    public function run()
    {
        // validar produtos
        $this->validar();
        $string = '';
        $this->gerarProduto($string);
        return $this->string = $string;
    }

    /**
     * Retornar produtos em forma de texto
     *
     * @return string
     */
    public function getTexto()
    {
        if (null === $this->string) {
            $this->run();
        }

        return $this->string;
    }

    /**
     * Salva texto em arquivo
     * @param  string $nome_arquivo Nome do arquivo
     * @return $this
     */
    public function salvar($nome_arquivo)
    {
        $filesystem = new Filesystem();
        $filesystem->dumpFile($nome_arquivo, $this->getTexto());
        $filesystem->chmod($nome_arquivo, 0775);
    }
}
