<?php

namespace Crphp\SiebelServerManager;

class Client
{
    /** @var string Armazena a string de conexão com o Siebel Server Manager */
    private $connection_string;

    /**
     * Monta a string de conexão
     *
     * @param string $path_bin
     * @param string $gateway
     * @param string $enterprise
     * @param string $username
     * @param string $password
     * @param string|null $server
     *
     * @return Client
     */
    public function connectionString(
        string $path_bin,
        string $gateway,
        string $enterprise,
        string $username,
        string $password,
        ?string $server = null
    ) {
        $server = isset($server) ? ' /s ' . $server : '';

        $this->connection_string  = $path_bin .
            ' /g ' . $gateway .
            ' /e ' . $enterprise .
            ' /u ' . $username .
            ' /p ' . $password .
            $server;

        return $this;
    }

    /**
     * Execulta a instrução no Siebel Server Manager
     *
     * @param string $command_string
     *
     * @return array
     */
    public function execCommand(string $command_string)
    {
        try {
            if (!isset($this->connection_string)) {
                throw new \Exception('Você não possui uma connection_string!');
            }

            $command = $this->connection_string . ' /b /c "' . $command_string . '"';

            if (!(exec($command, $result))) {
                throw new \Exception('Ocorreu um erro na execução do comando!');
            }

            return [
                'status' => 'success',
                'rows_returned' => preg_replace('/[^0-9]/', '', $result[count($result) - 3]),
                'result' => $this->clearAnswer($result, $command_string)
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    /**
     * Remove o banner default e linhas desnecessárias retornado pelo Siebel Service Manager
     *
     * @param array $result
     * @param string $filter_start
     *
     * @return array
     */
    private function clearAnswer(array $result, string $filter_start)
    {
        foreach ($result as $key => $value) {
            if (strpos($value, $filter_start)) {
                return array_slice($result, $key + 2, -4);
            }
        }
    }
}

