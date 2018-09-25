<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );

use Restserver\libraries\REST_Controller;

class Carreras extends REST_Controller {

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


	//Obtener todas las carreras
	public function obtenerCarreras_get(){
		//QUERY Y CICLO FOR PHP
		$query = $this->db->query("SELECT * FROM `carreras`");

		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'result' => $query->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}
	
}
