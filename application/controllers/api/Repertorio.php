<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Repertorio extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function test_get()
    {
        $this->response([
            'status' => TRUE,
            'message' => 'Funziona'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
    }

    public function sep_get()
    {

        $this->load->model('sep_model');
        $sep = $this->sep_model->select_qualificazione();
        $this->response($sep, REST_Controller::HTTP_OK);
    }

    public function profilo_get()
    {

        $id_sep = $this->get('id_sep');
        $this->db->select('id_profilo,id_sep,titolo_profilo,descrizione_profilo,livello_eqf,flg_regolamentato,data_ultima_modifica,data_ultimo_export,rrtq_stato_profilo.id_stato_profilo,des_stato_profilo');
        $this->db->from('rrtq_profilo');
        $this->db->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo');
        if ($id_sep !== NULL)
        {
            $this->db->where('id_sep', $id_sep);
        }
        $this->db->where('rrtq_profilo.id_stato_profilo !=', 4);
        $this->db->order_by('id_sep');
        $query = $this->db->get();
        $lista_profili = $query->result_array();

        if (!empty($lista_profili))
        {
            $this->response($lista_profili, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Nessun record selezionato'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function competenza_get()
    {

        $id_profilo = $this->get('id_profilo');

        if ($id_profilo === NULL)
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Specificare il Profilo'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {
            $this->db->select('id_profilo,id_competenza,titolo_competenza,risultato_competenza,oggetto_di_osservazione,indicatori');
            $this->db->from('v_rrtq_profilo_competenze');
            $this->db->where('id_profilo', $id_profilo);
            $query = $this->db->get();
            $lista_profili = $query->result_array();
            if (!empty($lista_profili))
            {
                $this->response($lista_profili, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Nessun record selezionato'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function qualificazione_get()
    {
        $id_profilo = $this->get('id_profilo');

        if ($id_profilo === NULL)
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Specificare il Profilo'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {
            $this->load->model('qualificazione_model');
            $scheda = $this->qualificazione_model->select_qualificazione($id_profilo);
            $this->response($scheda, REST_Controller::HTTP_OK);
        }
    }

}
