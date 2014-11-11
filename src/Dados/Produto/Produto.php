<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Dados\Produto;

use Rakuten\Exceptions\ParameterInvalidException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Produto
 */
class Produto extends Base
{
    /**
     * O nome do produto.
     *
     * @var string
     */
    private $nome;

    /**
     * O Status do produto.
     *
     * O status do produto pode ser ativo (1) e
     * inativo (0). Quando a loja estiver em
     * processo de criação, os produtos entrarão
     * como pendentes. Dessa forma é indicado
     * que sejam enviados apenas produtos que
     * serão comercializados pelo shopping.
     * Produtos inativos não serão importados até
     * que se libere a loja.
     *
     * @var boolean
     */
    private $status;

    /**
     * Descrição do Produto.
     *
     * A descrição do produto pode vender o
     * produto para você sem que nada precise
     * ser feito. Não economize nos detalhes,
     * coloque tudo que puder. Essa informação
     * pode ter um código HTML, mas não será
     * permitido links com entidades externas.
     *
     * @var string
     */
    private $descricao;

    /**
     * Especificações do Produto.
     *
     * As especificações do produto são questões
     * técnicas que desejam ser apresentadas ao
     * cliente. Essas informações também
     * poderão ser subidas em HTML, porém sem
     * links externos.
     *
     * @var string
     */
    private $especificacao;

    /**
     * O tipo do produto.
     *
     * Enviar sempre "1" significando que é do tipo "produto".
     *
     * @var integer
     */
    private $tipo;

    /**
     * Quantidade máxima de venda do produto por pedido.
     *
     * Essa é uma trava que é utilizada por
     * exemplo quando se faz alguma promoção
     * muito agressiva e se quer limitar por
     * pedido quanto pode ser adquirido.
     *
     * @var integer
     */
    private $limitar_quantidade;

    /**
     * URL de compartilhamento de vídeo YouTube.
     *
     * Caso insira um Script para vídeo YouTube o
     * mesmo será apresentado na descrição do
     * seu produto.
     *
     * @var string
     */
    private $video;

    /**
     * Categoria do Lojista
     *
     * @var Categoria
     */
    private $categoria;

    /**
     * Marca do produto.
     *
     * A marca deve ser transcrita exatamente
     * como disponibilizada pela marca. Evite
     * abreviações como por exemplo “Sony Eric.”,
     * siga o nome conhecido pelo mercado
     * (ao invés de Hewlett Packard use HP),
     * coloque as acentuações corretas
     * (Intelbras - Intelbrás). Se a marca é
     * própria, coloque seu próprio nome,
     * também com as orientações acima.
     *
     * @var string
     */
    private $marca;

    /**
     * Inserir o Preço Mínimo de venda do produto.
     *
     * O preço mínimo é o campo de segurança
     * para que em caso de erro de cadastro o
     * produto não seja vendido num valor menor
     * que o especificado. Utilize vírgula como
     * casa decimal.
     *
     * @var float
     */
    private $preco_minimo;

    /**
     * O caminho para a Imagem Padrão.
     *
     * A imagem padrão é a imagem que
     * aparecerá em todos os locais da loja,
     * menos nos detalhes de produto que serão
     * de detalhes das variações. Essa imagem
     * deve ser a mais chamativa e mais comercial
     * possível, pois é a partir dela que o cliente se
     * interessará em comprar o produto.
     *
     * @var string
     */
    private $imagem;

    /**
     * O prazo adicional para a entrega do produto.
     *
     * Aqui você pode preencher o número de
     * dias a mais (do que está estipulado na
     * tabela de frete) que cada produto demora
     * para ser entregue.
     *
     * Por exemplo, se o prazo de frete for 10 dias
     * e o prazo adicional for de 2 dias, o prazo
     * total para entregar o pedido será de 12 dias.
     *
     * É importante ressaltar que o prazo do frete
     * é calculado por cesta. Portanto, se a cesta
     * tem vários produtos com prazos diferentes,
     * o sistema puxará o maior prazo.
     *
     * @var integer
     */
    private $prazo_adicional;

    /**
     * Variações do produto
     *
     * @var SubProduto
     */
    private $sub_produto;


    /**
     * Setar valores padrão
     */
    public function __construct()
    {
        $this->tipo = 1;
        $this->sub_produto = new ArrayCollection();
    }

    /**
     * O nome do produto.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * O nome do produto.
     *
     * @param string $nome
     *
     * @return $this
     */
    public function setNome($nome)
    {
        if (strlen($nome) > 128) {
            throw new ParameterInvalidException('Nome do Produto deve ter no máximo 128 caracteres');
        }
        $this->nome = $nome;

        return $this;
    }

    /**
     * O Status do produto.
     *
     * @return boolean
     */
    public function getStatus()
    {
        return (boolean)$this->status;
    }

    /**
     * O Status do produto.
     *
     * @param boolean $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = is_bool($status) ? $status : ($status == '1' ? true : false);

        return $this;
    }

    /**
     * Descrição do Produto.
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Descrição do Produto.
     *
     * @param string $descricao
     *
     * @return $this
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Especificações do Produto.
     *
     * @return string
     */
    public function getEspecificacao()
    {
        return $this->especificacao;
    }

    /**
     * Especificações do Produto.
     *
     * @param string $especificacao
     *
     * @return $this
     */
    public function setEspecificacao($especificacao)
    {
        $this->especificacao = $especificacao;

        return $this;
    }

    /**
     * O tipo do produto.
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * O tipo do produto.
     *
     * @param integer $tipo
     *
     * @return $this
     */
    public function setTipo($tipo)
    {
        settype($tipo, 'integer');
        if ($tipo !== 1) {
            throw new ParameterInvalidException('O tipo do produto deve ser sempre 1');
        }
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Quantidade máxima de venda do produto por pedido.
     *
     * @return integer
     */
    public function getLimitarQuantidade()
    {
        return $this->limitar_quantidade;
    }

    /**
     * Quantidade máxima de venda do produto por pedido.
     *
     * @param integer $limitar_quantidade
     *
     * @return $this
     */
    public function setLimitarQuantidade($limitar_quantidade)
    {
        $this->limitar_quantidade = (int) $limitar_quantidade;

        return $this;
    }

    /**
     * URL de compartilhamento de vídeo YouTube.
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * URL de compartilhamento de vídeo YouTube.
     *
     * @param string $video
     *
     * @return $this
     */
    public function setVideo($video)
    {
        preg_match('/((v(i)?(\/|=)?)|embed\/|be\/)([A-z0-9-]{11})/', $video, $return);
        if (empty($return[5])) {
            throw new ParameterInvalidException('Não foi possível detectar que esta é uma url do YouTube');
        }
        $this->video = $video;

        return $this;
    }

    /**
     * Categoria do Lojista.
     *
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Categoria do Lojista.
     *
     * @param Categoria $categoria
     *
     * @return $this
     */
    public function setCategoria(Categoria $categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Marca do produto.
     *
     * @param string $marca
     *
     * @return $this
     */
    public function setMarca($marca)
    {
        if (strlen($marca) > 255) {
            throw new ParameterInvalidException('Marca do produto deve ter no máximo 255 caracteres');
        }
        $this->marca = $marca;

        return $this;
    }

    /**
     * Inserir o Preço Mínimo de venda do produto.
     *
     * @return float
     */
    public function getPrecoMinimo()
    {
        return $this->preco_minimo;
    }

    /**
     * Inserir o Preço Mínimo de venda do produto.
     *
     * @param float $preco_minimo
     *
     * @return $this
     */
    public function setPrecoMinimo($preco_minimo)
    {
        $this->preco_minimo = $this->convertStringToFloat($preco_minimo);

        return $this;
    }

    /**
     * O caminho para a Imagem Padrão.
     *
     * @return string
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * O caminho para a Imagem Padrão.
     *
     * @param string $imagem
     *
     * @return $this
     */
    public function setImagem($imagem)
    {
        if (!preg_match('/\.(jpeg|jpg|gif)$/i', $imagem)) {
            throw new ParameterInvalidException('A imagem deve ser jpg, jpeg ou gif');
        }
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * O prazo adicional para a entrega do produto.
     *
     * @return integer
     */
    public function getPrazoAdicional()
    {
        return (int)$this->prazo_adicional;
    }

    /**
     * O prazo adicional para a entrega do produto.
     *
     * @param integer $prazo_adicional
     *
     * @return $this
     */
    public function setPrazoAdicional($prazo_adicional)
    {
        $this->prazo_adicional = (int)$prazo_adicional;

        return $this;
    }

    /**
     * Retornar as variação do produto.
     *
     * @return ArrayCollection
     */
    public function getSubProduto()
    {
        return $this->sub_produto;
    }

    /**
     * Adicionar variação do produto
     *
     * @param SubProduto
     *
     * @return $this
     */
    public function addSubProduto(SubProduto $subProduto)
    {
        $this->sub_produto->add($subProduto);

        return $this;
    }

    /**
     * Verificar se existe variação
     *
     * @return boolean
     */
    public function hasSubProduto()
    {
        return $this->sub_produto->count() > 0;
    }
}
