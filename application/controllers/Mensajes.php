<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );

use Restserver\libraries\REST_Controller;

class Mensajes extends REST_Controller {

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
		$this->load->view('welcome_message');
	}

	//DEVUELVE LOS MENSAJES POR ID
	public function obtenerMensajesById_get($id){
		//INICIALIZA LA BASE DE DATOS
		// $this->load->database();

		//QUERY Y CICLO FOR PHP
		$query = $this->db->query("SELECT * FROM `mensajes` WHERE id = '".$id."'");

		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'result' => $query->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );
	}

	//OBTENER LOS MENSAJES PAGINADOS
	public function obtenerMensajes_get($pagina = 0){
		//PAGINA POR LOS ELEMENTOS QUE CONTIENE
		$pagina = $pagina * 10;

		//QUERY Y CICLO FOR PHP
		$query = $this->db->query("SELECT * FROM `mensajes` LIMIT ".$pagina.",10");

		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'result' => $query->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );
	}

	//OBTENER LOS MENSAJES POR FECHA
	public function obtenerMensajesPorFecha_get($fecha, $pagina = 0){
		//PAGINA POR LOS ELEMENTOS QUE CONTIENE
		$pagina = $pagina * 10;

		//QUERY Y CICLO FOR PHP
		$query = $this->db->query("SELECT * FROM `mensajes` WHERE fecha = '".$fecha."' LIMIT ".$pagina.",10");

		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'result' => $query->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}

	//BUSCADOR DE MENSAJES
	public function buscarMensajes_get($palabra){

		//QUERY Y CICLO FOR PHP
		$query = $this->db->query("SELECT * FROM `mensajes` WHERE mensaje LIKE '%".$palabra."%'");

		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'termino' => $palabra,
			'result' => $query->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}

	//ENVIAR UN MENSAJE
	public function enviarMensaje_post(){
		$data = $this->post();

		//SI TODO SALE BIEN
        $mensaje = array(
            'name' => $data['name'],
			'email' => $data['email'],
			'mensaje' => $data['mensaje'],
			'fecha' => $data['fecha'],
		);
		
		$this->db->insert('mensajes', $mensaje);

		$this->response( $mensaje );
	}

	//ENVIAR UN MENSAJE
	public function borrarMensaje_delete($id){
		//SI TODO SALE BIEN
        $id_mensaje = array(
            'id' => $id
		);

		$this->db->delete('mensajes', $id_mensaje);

		$this->response( $id_mensaje );
	}

	//////////////////////////////////////////PENDIENTE/////////////////////////////////////////////////
	//REALIZA UN POST RECIBIENDO UN TOKEN DE AUTENTIFICACION
	public function enviarMensajeConAut_post($token = "0", $id_usuario = "0"){

		$data = $this->post();
        //SI LA INFORMACION ESTA VACIA
        if( $token == "0" || $id_usuario == "0" ){
            $respuesta = array(
                'error' => TRUE,
                'result' => 'Token invalido!'
            );

            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

	}
}
