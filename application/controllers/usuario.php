<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );

use Restserver\libraries\REST_Controller;

class Usuario extends REST_Controller {

	//CONSTRUCTOR DE LA CLASE
	public function __construct(){

		//ALLOW HEADER - PERMISOS DE URL
		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header("Access-Control-Allow-Origin: *");
		parent::__construct();
		//INICIALIZA LA BASE DE DATOS
		$this->load->database();
	}

	//INDEX ES NECESARIO
	public function index()
	{
		$this->load->view('registro page');
	}


	//REGISTRAR UN USUARIO
	public function registrar_post(){
		$data = $this->post();

		//DATOS QUE NO SE PUEDEN REPETIR
        $condicion1 = array(
			'matricula' => $data['matricula'],
		);
		$condicion2 = array(
			'correo' => $data['correo']
		);
		

        //BUSCA EL USUARIO DENTRO DE LA BASE DE DATOS
		$queryMatricula = $this->db->get_where('usuarios', $condicion1);
		$queryCorreo = $this->db->get_where('usuarios', $condicion2);

		$get_matricula = $queryMatricula->row();
		$get_correo = $queryCorreo->row();

        if( isset($get_matricula) || isset($get_correo) ){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'El usuario ya existe'
            );

            $this->response($respuesta);
            return;
		}

		//SI EL USUARIO NO EXISTE, ENTONCES LO REGISTRAMOS BIEN
        $usuario = array(
			'matricula' => $data['matricula'],
            'nombre' => $data['nombre'],
			'correo' => $data['correo'],
			'contrasena' => $data['contrasena'],
			'tipo' => $data['tipo'],
			'id_carrera' => $data['id_carrera'],
		);

		$this->db->insert('usuarios', $usuario);

		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'mensaje' => 'Usuario registrado con exito',
			'result' => $usuario

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}
	
}
