<?php

namespace llstarscreamll\CrudGenerator\Providers;

use llstarscreamll\CrudGenerator\Providers\BaseGenerator;

/**
* 
*/
class ControllerGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     * @var string
     */
    public $table_name;

    /**
     * Los mensajes de alerta en la operación.
     * @var string
     */
    public $msg_warning;

    /**
     * Los mensajes de info en la operación.
     * @var string
     */
    public $msg_info;

    /**
     * 
     */
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    /**
     * Genera el controlador.
     * @return void
     */
    public function generate()
    {
        // el archivo del controlador
        $controllerFile = $this->controllersDir().'/'.$this->controllerClassName().".php";

        $content = view($this->templatesDir().'.controller', [
            'gen' => $this,
            'fields' => $this->fields($this->table_name),
            'foreign_keys'  => $this->getForeignKeys($this->table_name)
        ]);

        return file_put_contents($controllerFile, $content);
    }
}
