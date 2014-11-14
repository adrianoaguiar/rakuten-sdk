<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Ftp;

use Doctrine\Common\Collections\ArrayCollection;
use Rakuten\Exceptions\Exception;

/**
 * Classe para envio de imagem
 */
class UploadImage
{
    /**
     * @var FTP
     */
    private $conexao;

    /**
     * Diretórios já acessados
     *
     * @var array
     */
    private $diretorio;

    /**
     * @param FTP $conexao
     */
    public function __construct(FTP $conexao)
    {
        $this->conexao = $conexao;
        $this->diretorio = array();
    }

    /**
     * Fazer upload das imagens
     *
     * @param  ArrayCollection $imagens
     */
    public function upload(ArrayCollection $imagens)
    {
        foreach ($imagens as $remoto => $local) {
            $this->uploadImage($local, $remoto);
        }
    }

    /**
     * Fazer upload da imagem individual
     *
     * @param  string $local  destino imagem local
     * @param  string $remoto destino imagem servidor
     */
    protected function uploadImage($local, $remoto)
    {
        $this->checkDiretorio($remoto);
        ftp_put($this->conexao->getConnection(), $remoto, $local, FTP_ASCII);
    }

    /**
     * Verificar se existe diretório caso não exista cria.
     *
     * @param  string $arquivo_remoto
     */
    protected function checkDiretorio($arquivo_remoto)
    {
        $array_diretorio = explode(DIRECTORY_SEPARATOR, $arquivo_remoto);
        array_pop($array_diretorio);
        $diretorio = implode(DIRECTORY_SEPARATOR, $array_diretorio);

        // verificar se ja acessou o diretório
        if (!in_array($diretorio, $this->diretorio)) {

            // verificar se existe o diretório no servidor ftp
            if (false === @ftp_chdir($this->conexao->getConnection(), $diretorio)) {

                // acessa o diretório recursivamente no servidor ftp
                foreach ($array_diretorio as $dir) {

                    // verificar se existe informação na variavel
                    if (strlen($dir) > 0) {

                        // verifica se diretório existe
                        if (false === @ftp_chdir($this->conexao->getConnection(), $dir)) {

                            // diretório não existe cria
                            ftp_mkdir($this->conexao->getConnection(), $dir);

                            // acessa o diretório criado
                            if (false === @ftp_chdir($this->conexao->getConnection(), $dir)) {
                                // caso não tenha criado diretório gera erro
                                throw new Exception('Não foi possível criar o diretório');
                            }

                        }

                    }

                }

            }
            // Adiciona a lista de diretório acessados
            $this->diretorio[] = $diretorio;

            // Retorna para a raiz do ftp
            @ftp_chdir($this->conexao->getConnection(), '/');
        }
    }
}
