<?php

namespace Crphp\SiebelServerManager;

use Crphp\SiebelServerManager\Client;

/**
 * Manipula componentes do Siebel Server
 */
class Component
{
    /** @var array Dados retornados pelo Siebel Server Manager */
    private $outout;

    /**
     * Lista o status de todos os componentes ou de um específico.
     *
     * @param Client $client
     * @param string|null $component
     *
     * @return Component
     */
    public function details(Client $client, ?string $component = null) : Component
    {
        $command = isset($component) ? 'list component ' : 'list comps';

        $this->output = $client->exec_command($command . $component);
        return $this;
    }

    /**
     * Efetua o stop ou kill do componente, conforme parâmetro informado.
     *
     * @param Client $client
     * @param string $component
     * @param boolean $force
     *
     * @return Component
     */
    public function stop(Client $client, string $component, bool $force = false) : Component
    {
        $result = $this->details($client, $component)->toArray();

        if ($result['CP_DISP_RUN_STATE'] != 'Fechar' && $result['CP_DISP_RUN_STATE'] != 'Desligado') {
            $command = ($force === false) ? 'stop component ' : 'kill comp ';
            $this->output = $client->exec_command($command . $component);
        }

        return $this;
    }

    /**
     * Inicia o componente informado
     *
     * @param Client $client
     * @param string $component
     *
     * @return Component
     */
    public function start(Client $client, string $component) : Component
    {
        $result = $this->details($client, $component)->toArray();

        if ($result['CP_DISP_RUN_STATE'] != 'Ativado' && $result['CP_DISP_RUN_STATE'] != 'Ativando') {
            $this->output = $client->exec_command('startup component ' . $component);
        }

        return $this;
    }

    /**
     * Transforma o texto retornado pelo Siebel Server Manager em um array
     *
     * @return array
     */
    public function toArray() : array
    {
        $header = explode('  ', $this->output['result'][1]);
        $initial_header_length = 0;

        // $columns armazena o nome da coluna, seu inicio e fim
        foreach($header as $h) {
            $key = trim(substr($this->output['result'][0], $initial_header_length,  strlen($h)));

            $columns[] = ['name' => $key, 'start' => $initial_header_length, 'end' => strlen($h)];

            $initial_header_length += strlen($h) + 2;
        }

        $components = array_slice($this->output['result'], 2);

        $item_counter = 0;
        foreach ($components as $comp) { // retorna a linha do componente
            foreach($columns as $column) { // retorna o item da coluna
                $item[$column['name']] = utf8_encode(trim(substr($comp, $column['start'], $column['end'])));
            }

            $result[$item_counter++] = $item;
        }

        return $result;
    }
}