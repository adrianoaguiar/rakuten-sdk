<?php
/**
 * Rogério Adriano <rogerioadris@gmail.com>
 */

namespace Rakuten\Ftp;

/**
 * Classe FTP
 */
class FTP
{
    /**
     * Conexão
     *
     * @var resource
     */
    private $conn_id;

    /**
     * @param string $ftp_server
     * @param string $ftp_user_name
     * @param string $ftp_user_pass
     */
    public function __construct($ftp_server, $ftp_user_name, $ftp_user_pass)
    {
        // define a conexão básica
        $this->conn_id = ftp_connect($ftp_server);

        // login com nome de usuário e senha
        ftp_login($this->conn_id, $ftp_user_name, $ftp_user_pass);
    }

    /**
     * Retorna a conexão ftp
     *
     * @return resource
     */
    public function getConnection()
    {
        return $this->conn_id;
    }

    /**
     * Fecha esta conexão
     */
    public function __destruct()
    {
        if (is_resource($this->conn_id)) {
            ftp_close($this->conn_id);
        }
    }
}
