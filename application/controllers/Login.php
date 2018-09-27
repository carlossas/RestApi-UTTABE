<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );

use Restserver\libraries\REST_Controller;

class Login extends REST_Controller {

	public function __construct(){

		//ALLOW HEADER - PERMISOS DE URL
		header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header("Access-Control-Allow-Origin: *");
		parent::__construct();
		//INICIALIZA LA BASE DE DATOS
		$this->load->database();
	}

	public function index_post(){
        $this->load->view('welcome_message');
        
        $data = $this->post();
        //SI LA INFORMACION ESTA VACIA
        if( !isset( $data['matricula']) OR !isset( $data['contrasena']) ){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Algo ocurrio mal!'
            );

            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        //SI TODO SALE BIEN
        $condiciones = array(
            'matricula' => $data['matricula'],
            'contrasena' => $data['contrasena']
        );

        //BUSCA EL USUARIO DENTRO DE LA BASE DE DATOS

        $query = $this->db->get_where('usuarios', $condiciones);

        $usuario = $query->row();

        if( !isset($usuario) ){
            $respuesta = array(
                'error' => TRUE,
                'mensaje' => 'Usuario o contraseña invalido!'
            );

            $this->response($respuesta);
            return;
        }

        //SI TODO SALE CORRECTAMENTE
        
        //CREAR TOKEN
        //1 formaa de crearlo
        $token = bin2hex( openssl_random_pseudo_bytes(20) );
        //2 forma de crearlo
        $token = hash('ripemd160', $data['matricula']);

        //GUARDAR EN BASE DE DATOS EL TOKEN

        //LIMPIAR LAS QUERYS
        $this->db->reset_query();

        //ACTUALIZA TOKEN
        $actualizar_token = array ( 'token' => $token );
        $this->db->where( 'id_usuario', $usuario->id_usuario );
        $update = $this->db->update( 'usuarios ', $actualizar_token);

       $usuario->contrasena = 'k mira prro';

        $respuesta = array(
            'error' => FALSE,
            'token' => $token,
            'usuario' => $usuario
        );

        $this->response($respuesta);

    }
    

}
