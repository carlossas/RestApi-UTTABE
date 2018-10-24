<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );

use Restserver\libraries\REST_Controller;

class ExamenesAlumno extends REST_Controller {

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
		$this->load->view('examenes alumno page');
	}


	//Obtener todos los examenes por carrera
	public function obtenerExamenes_get($id_carrera){
		//QUERY Y CICLO FOR PHP
		$examen = $this->db->query("SELECT * FROM `examen` WHERE id_carrera = '".$id_carrera."'");
		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'result' => $examen->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}

	//Obtener todos los examenes por carrera
	public function obtenerPreguntas_get($id_examen){
		//QUERY Y CICLO FOR PHP
		$preguntas = $this->db->query("SELECT * FROM `preguntas` WHERE id_examen = '".$id_examen."'");
		//DEVUELVE UN ARREGLO DE RESPUESTAS
		$respuesta = array (
			'error' => FALSE,
			'result' => $preguntas->result()

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}

	//CREAR UN NUEVO EXAMEN
	public function crearExamen_post(){
		$data = $this->post();

		//SI TODO SALE BIEN
        $examen = array(
			'id_examen' => '',
            'id_carrera' => $data['id_carrera'],
			'id_profesor' => $data['id_profesor'],
			'random' => $data['random'],
			'numeroPreguntas' => $data['numeroPreguntas'],
			'nombre' => $data['nombre'],
			'tiempo' => $data['tiempo']
		);

		$this->db->insert('examen', $examen);

		$ultimoId = $this->db->insert_id();

		$examen['id_examen'] = $ultimoId;
		
			
		$respuesta = array (
			'error' => FALSE,
			'result' => $examen

		);

		//DEVUELVE LA RESPUESTA
		$this->response( $respuesta );

	}
	
}
