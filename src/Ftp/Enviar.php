<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Ftp;

use Rakuten\Dados\Gerador\Gerar;
use Rakuten\Exceptions\Exception;
use Rakuten\Exceptions\ParameterInvalidException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Enviar arquivo para ftp
 */
class Enviar
{
    /**
     * @var Gerar
     */
    private $gerar;

    /**
     * @var string
     */
    private $id_usuario;

    /**
     * @var string
     */
    private $diretorio_imagem;

    /**
     * @param Gerar  $gerar
     * @param string $id_usuario       Código do Lojista
     * @param string $diretorio_imagem Diretório onde estão as imagem informada nos produtos
     */
    public function __construct(Gerar $gerar, $id_usuario, $diretorio_imagem = './')
    {
        $this->gerar = $gerar;
        $this->id_usuario = $id_usuario;
        $this->setDiretorioImagem($diretorio_imagem);
    }

    /**
     * Setar o diretório onde estão as imagens a ser enviada no ftp
     *
     * @param string $diretorio
     */
    public function setDiretorioImagem($diretorio)
    {
        $this->diretorio_imagem = realpath($diretorio);
        if (false === $this->diretorio_imagem) {
            throw new ParameterInvalidException('Diretório não encontrado');
        }
    }

    /**
     * Capturar as imagens dos produtos e subprodutos
     *
     * @return array Array com as imagens array('imagem_no_arquivo' => 'imagem_no_computador')
     */
    private function retornarImagens()
    {
        $imagens = array();
        $produtos = $this->gerar->getProdutos()->getProdutos();
        foreach ($produtos as $produto) {
            $this->adicionarImagem($imagens, sprintf('/P-%s/%s', $this->id_usuario, $produto->getImagem()));
            foreach ($produto->getSubProdutos() as $subproduto) {
                foreach ($subproduto->getImagem() as $imagem) {
                    $this->adicionarImagem($imagens, sprintf('/P-%s/%s', $this->id_usuario, $imagem));
                }
            }
        }
        return $imagens;
    }

    /**
     * Adiciona imagem no array
     *
     * @param  array $array
     * @param   $key   imagem informada no arquivo
     */
    private function adicionarImagem(array &$array, $key)
    {
        $imagem = $this->validarImagem($key);
        if (!(array_key_exists($key, $array) && $array[$key] === $imagem)) {
            $array[$key] = $imagem;
        }
    }

    /**
     * Verificar se existe a imagem no diretório informado
     *
     * @param  string $imagem
     *
     * @return string
     */
    private function validarImagem($imagem)
    {
        $file = end(explode(DIRECTORY_SEPARATOR, $imagem));
        if (is_file($file_path = sprintf('%s/%s', $this->diretorio_imagem, $file))) {
            return $file_path;
        } else {
            throw new ParameterInvalidException(sprintf('A imagem "%s" não foi encontrada', $imagem));
        }
    }

    /**
     * Enviar arquivos para o servidor.
     */
    public function run()
    {
        $this->uploadImagens();
        $this->uploadArquivo();
    }

    /**
     * Fazer upload das imagens do produtos
     */
    private function uploadImagens()
    {
        // captura as imagens a serem enviadas no ftp
        $imagens = $this->retornarImagens();

        $ftp = new FTP('177.154.155.117', 'rkimagensftp', '$OlyV3ks'); // ftp imagens
        $uploadImage = new UploadImage($ftp);
        $uploadImage->upload(new ArrayCollection($imagens));
        unset($ftp); // desconecta

    }

    /**
     * Fazer upload dos produtos/arquivo
     */
    private function uploadArquivo()
    {

        $texto = $this->gerar->getTexto();
        if (strlen($texto) === 0) {
            throw new Exception('Não é possivel enviar arquivo vazio para o servidor.');
        }

        // criar arquivo temporário
        $temporario = fopen('php://temp', 'r+');

        // adiciona texto ao arquivo
        fwrite($temporario, $texto);

        // Reinicializa a posição do ponteiro de arquivos para o início
        rewind($temporario);

        // conecta ao ftp de arquivos do rakuten
        $ftp = new FTP('177.154.155.116', 'rkfilesftp', 'Skz-uE6z');

        // monta nome do arquivo seguindo o padrão rakuten "P-00000000-0000-0000-0000-000000000000.txt"
        $destino_arquivo = sprintf('/P-%s.txt', $this->id_usuario);

        // retona arquivos do servidor
        $arquivos_servidor = @ftp_nlist($ftp->getConnection(), '/');
        if (is_array($arquivos_servidor) && in_array($destino_arquivo, $arquivos_servidor)) {
            throw new Exception(sprintf('Arquivo "%s" já existe no servidor.', $destino_arquivo));
        }

        // gravar arquivo no servidor de arquivos
        ftp_fput($ftp->getConnection(), $destino_arquivo, $temporario, FTP_ASCII);

        // retona arquivos do servidor
        $arquivos_servidor = @ftp_nlist($ftp->getConnection(), '/');

        // verificar se arquivo foi criado no servidor
        if (is_array($arquivos_servidor) && !in_array($destino_arquivo, $arquivos_servidor)) {
            throw new Exception(sprintf('Não foi possível criar o arquivo "%s" no servidor.', $destino_arquivo));
        }

        unset($ftp); // desconecta
    }
}
