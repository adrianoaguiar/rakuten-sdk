<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */
namespace Rakuten\Dados\Produto;

use Rakuten\Exceptions\ParameterInvalidException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Detalhes
 */
class Detalhes extends Base
{
    /**
     * Preço base do produto sem descontos.
     *
     * Quando ele e o próximo campo(de
     * Preço POR) forem diferentes, será
     * apresentado na loja o DE/POR em
     * todo o catálogo.
     *
     * @var float
     */
    private $preco;

    /**
     * Preço promocional do produto.
     *
     * Esse preço poderá ser igual ao
     * anterior (Preço DE), mas caso seja
     * diferente será dado o destaque
     * promocional.
     *
     * @var float
     */
    private $preco_promocional;

    /**
     * Quantidade de itens em estoque que serão disponibilizados na loja.
     *
     * A venda será permitida até o limite do
     * campo seguinte (Estoque mínimo).
     * Quando o estoque estiver zerado ou
     * atingir a mesma quantidade do
     * mínimo, o produto ficará indisponível
     *
     * @var integer
     */
    private $estoque;

    /**
     * Estoque Mínimo.
     *
     * Estoque Mínimo do produto é um
     * estoque de segurança para que a loja
     * esteja limitada a vender somente até
     * uma quantidade especificada.
     *
     * @var integer
     */
    private $estoque_minimo;

    /**
     * Opção de ter frete grátis ou não para o produto.
     *
     * Se o produto tiver frete grátis, enviar
     * "1" e quando o frete precisar ser
     * calculado, enviar "0".
     *
     * Caso um cliente efetue
     * um pedido com outros itens que não
     * tenham essa marcação, o frete será
     * cobrado normalmente sobre os
     * produtos não marcados.
     *
     * @var boolean
     */
    private $frete_gratis;

    /**
     * Dimensões do produto
     *
     * @var Dimensoes
     */
    private $dimensoes;

    /**
     * SKU padrão é a variação que virá
     * preenchida quando o cliente acessar
     * os detalhes do produto. De acordo
     * com essa variação, as imagens iniciais
     * de produto serão carregadas.
     *
     * Insira "true" para o produto aparecer em
     * primeiro lugar no detalhe do produto.
     * Para os demais SKUs, insira "false"
     *
     * @var boolean
     */
    private $sku;

    /**
     * O Código ISBN é um código único de
     * identificação, utilizado apenas para
     * livros.
     *
     * Esta informação é bastante
     * importante, pois muitos clientes
     * podem efetuar buscas por este
     * critério.
     *
     * @var integer
     */
    private $isbm;

    /**
     * O Código EAN13 é um código único de
     * identificação de produtos. Este código
     * será diferente para cada variação de
     * produto.
     *
     * Esta informação é bastante
     * importante, pois muitos clientes
     * podem efetuar buscas por este
     * critério, e sempre que possível, efetue
     * o preenchimento.
     *
     * @var integer
     */
    private $ean13;

    /**
     * Modelo do produto.
     *
     * Esta informação é bastante
     * importante, pois muitos clientes
     * podem efetuar buscas por este
     * critério.
     *
     * @var string
     */
    private $modelo;

    /**
     * Imagens da variacao
     *
     * @var ArrayCollection
     */
    private $imagem;

    /**
     *
     */
    public function __construct()
    {
        $this->imagem = new ArrayCollection();
    }

    /**
     * Preço base do produto sem descontos.
     *
     * @return float
     */
    public function getPreco()
    {
        return (float) $this->preco;
    }

    /**
     * Preço base do produto sem descontos.
     *
     * @param float $preco
     *
     * @return $this
     */
    public function setPreco($preco)
    {
        $this->preco = $this->convertStringToFloat($preco);

        return $this;
    }

    /**
     * Preço promocional do produto.
     *
     * @return float
     */
    public function getPrecoPromocional()
    {
        return (float) (is_null($this->preco_promocional) ? $this->getPreco() : $this->preco_promocional);
    }

    /**
     * Preço promocional do produto.
     *
     * @param float $preco_promocional
     *
     * @return $this
     */
    public function setPrecoPromocional($preco_promocional)
    {
        $this->preco_promocional = $this->convertStringToFloat($preco_promocional);

        return $this;
    }

    /**
     * Estoque.
     *
     * @return integer
     *
     */
    public function getEstoque()
    {
        return (integer) $this->estoque;
    }

    /**
     * Validar estoque/estoque_minimo
     *
     * @param  string|integer $estoque
     *
     * @return integer
     */
    private function validarEstoque($estoque)
    {
        settype($estoque, 'integer');
        if ($estoque == 0 || $estoque > 999999999) {
            throw new ParameterInvalidException('O estoque deve ser entre 1 e 999999999');
        }
        return $estoque;
    }

    /**
     * Estoque.
     *
     * @param integer $estoque
     *
     * @return $this
     */
    public function setEstoque($estoque)
    {
        $this->estoque = $this->validarEstoque($estoque);

        return $this;
    }

    /**
     * Estoque Mínimo
     *
     * @return integer
     */
    public function getEstoqueMinimo()
    {
        return (integer) $this->estoque_minimo;
    }

    /**
     * Estoque Mínimo
     *
     * @param integer $estoque
     *
     * @return $this
     */
    public function setEstoqueMinimo($estoque)
    {
        $this->estoque_minimo = $this->validarEstoque($estoque);

        return $this;
    }


    /**
     * Opção de ter frete grátis ou não para o produto.
     *
     * @return boolean
     */
    public function getFreteGratis()
    {
        return (boolean) $this->frete_gratis;
    }

    /**
     * Opção de ter frete grátis ou não para o produto.
     *
     * @param boolean $frete
     *
     * @return $this
     */
    public function setFreteGratis($frete)
    {
        $this->frete_gratis = is_bool($frete) ? $frete : ($frete == '1' ? true : false);

        return $this;
    }

    /**
     * Dimensões do produto
     *
     * @return Dimensoes
     */
    public function getDimensoes()
    {
        return $this->dimensoes;
    }

    /**
     * Dimensões do produto
     *
     * @param Dimensoes $dimensoes
     */
    public function setDimensoes(Dimensoes $dimensoes)
    {
        $this->dimensoes = $dimensoes;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSku()
    {
        return (boolean) $this->sku;
    }

    /**
     * @param boolean $sku
     */
    public function setSku($sku)
    {
        $this->sku = is_bool($sku) ? $sku : ($sku == '1' ? true : false);

        return $this;
    }

    /**
     * @return integer
     */
    public function getIsbm()
    {
        return $this->isbm;
    }

    /**
     * @param integer $isbm
     */
    public function setIsbm($isbm)
    {
        $this->isbm = preg_replace('/([^\d]+)/', '', $isbm);

        return $this;
    }

    /**
     * @return integer
     */
    public function getEan13()
    {
        return $this->ean13;
    }

    /**
     * @param integer $ean13
     */
    public function setEan13($ean13)
    {
        $this->ean13 = preg_replace('/([^\d]+)/', '', $ean13);

        return $this;
    }

    /**
     * Modelo do produto.
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Modelo do produto.
     *
     * @param string $modelo
     */
    public function setModelo($modelo)
    {
        if (strlen($modelo) > 255) {
            throw new ParameterInvalidException('Modelo do produto deve ter no máximo 255 caracteres');
        }
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Retonar Imagem
     *
     * @return ArrayCollection
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Adicionar Imagem
     *
     * @param ArrayCollection $imagem
     *
     * @return $this
     */
    public function addImagem($imagem)
    {
        if (!$this->imagem->contains($imagem)) {
            if (!preg_match('/\.(jpeg|jpg|gif)$/i', $imagem)) {
                throw new ParameterInvalidException('A imagem deve ser jpg, jpeg ou gif');
            }
            $this->imagem->add($imagem);
        }

        return $this;
    }

    /**
     * Limpar Imagens
     *
     * @return $this
     */
    public function clearImagem()
    {
        $this->imagem->clear();

        return $this;
    }

    /**
     * Verificar se existe imagem
     *
     * @return boolean
     */
    public function hasImagem()
    {
        return !$this->imagem->isEmpty();
    }
}
