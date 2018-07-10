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
            'message' => 'Connessione ok'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
    }

    public function sep_get()
    {
        $this->db->select('id_sep,CONCAT(codice_sep," - ", descrizione_sep) as descrizione_sep', FALSE);
        $this->db->from('rrtq_sep');
        $query = $this->db->get();
        $lista_sep = $query->result_array();
        if (!empty($lista_sep))
        {
            $this->response($lista_sep, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Nessun record selezionato'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function profilo_get()
    {

        $id_sep = $this->get('id_sep');

        if ($id_sep === NULL)
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Specificare il SEP'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {
            $this->db->select('id_profilo,id_sep,titolo_profilo,descrizione_profilo');
            $this->db->from('rrtq_profilo');
            $this->db->where('id_sep', $id_sep);
            $this->db->order_by('titolo_profilo');
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

    public function profilo_post()
    {
        $id_profilo = $this->post('id_profilo');
        $descrizione_profilo = $this->post('descrizione_profilo');

        if (($id_profilo === NULL) OR ( $descrizione_profilo === NULL))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Specificare il SEP'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {
            $data = array(
                'descrizione_profilo' => $descrizione_profilo
            );

            $this->db->where('id_profilo', $id_profilo);
            $this->db->update('rrtq_profilo', $data);
            $db_error = $this->db->error();
            if (!$db_error["code"] === 0)
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Non aggiornato'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
            $this->response([
                'status' => TRUE,
                'message' => 'Aggiornato'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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

    public function competenza_post()
    {
        $id_competenza = $this->post('id_competenza');
        $risultato_competenza = $this->post('risultato_competenza');
        $oggetto_di_osservazione = $this->post('oggetto_di_osservazione');
        $indicatori = $this->post('indicatori');

        if (($id_competenza === NULL))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Specificare la competenza'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {
            $data = array(
                'risultato_competenza' => $risultato_competenza,
                'oggetto_di_osservazione' => $oggetto_di_osservazione,
                'indicatori' => $indicatori
            );

            $this->db->where('id_competenza', $id_competenza);
            $this->db->update('rrtq_competenza', $data);
            $db_error = $this->db->error();
            if (!$db_error["code"] === 0)
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Non aggiornato'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
            $this->response([
                'status' => TRUE,
                'message' => 'Aggiornato'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function cp2011_post()
    {
        $id_profilo = $this->post('id_profilo');
        $codice_cp2011 = $this->post('codice_cp2011');
        $action = $this->post('action');
        if (($id_profilo === NULL) && ($codice_cp2011 === NULL))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Non aggiornato'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {

            $this->db->where('id_profilo', $id_profilo);
            $this->db->where('codice_cp2011', $codice_cp2011);
            $this->db->delete('rrtq_profilo_cp2011');
            $db_error = $this->db->error();
            if (!$db_error["code"] === 0)
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Impossibile Cancellare'
                        ], REST_Controller::HTTP_NOT_FOUND);
            }
            if ($action == "ADD")
            {
                $data = array(
                    'id_profilo' => $id_profilo,
                    'codice_cp2011' => $codice_cp2011
                );

                $this->db->insert('rrtq_profilo_cp2011', $data);
                $db_error = $this->db->error();
                if (!$db_error["code"] === 0)
                {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Impossibile Inserire'
                            ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
            $this->response([
                'status' => TRUE,
                'message' => 'Aggiornato'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function cp2011_get()
    {

        $id_profilo = $this->get('id_profilo');

        if ($id_profilo === NULL)
        {

            $query = $this->db->get('rrtq_istat_cp2011');
            $lista_cp2011 = $query->result_array();
            if (!empty($lista_cp2011))
            {
                $this->response($lista_cp2011, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Nessun record selezionato'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        else
        {
            $this->db->select('id_profilo,codice_cp2011');
            $this->db->from('rrtq_profilo_cp2011');
            $this->db->where('id_profilo', $id_profilo);
            $query = $this->db->get();
            $lista_profilo_cp2011 = $query->result_array();
            if (!empty($lista_profilo_cp2011))
            {
                $this->response($lista_profilo_cp2011, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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

    public function ateco2007_post()
    {
        $id_profilo = $this->post('id_profilo');
        $codice_ateco = $this->post('codice_ateco');
        $action = $this->post('action');
        if (($id_profilo === NULL) && ($codice_ateco === NULL))
        {
            $this->response([
                'status' => FALSE,
                'message' => 'Non aggiornato'
                    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
        else
        {

            $this->db->where('id_profilo', $id_profilo);
            $this->db->where('codice_ateco', $codice_ateco);
            $this->db->delete('rrtq_profilo_ateco2007');
            $db_error = $this->db->error();
            if (!$db_error["code"] === 0)
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Impossibile Cancellare'
                        ], REST_Controller::HTTP_NOT_FOUND);
            }
            if ($action == "ADD")
            {
                $data = array(
                    'id_profilo' => $id_profilo,
                    'codice_ateco' => $codice_ateco
                );

                $this->db->insert('rrtq_profilo_ateco2007', $data);
                $db_error = $this->db->error();
                if (!$db_error["code"] === 0)
                {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Impossibile Inserire'
                            ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
            $this->response([
                'status' => TRUE,
                'message' => 'Aggiornato'
                    ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function ateco2007_get()
    {

        $id_profilo = $this->get('id_profilo');

        if ($id_profilo === NULL)
        {

            $query = $this->db->get('rrtq_istat_ateco2007');
            $lista_ateco = $query->result_array();
            if (!empty($lista_ateco))
            {
                $this->response($lista_ateco, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Nessun record selezionato'
                        ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        else
        {
            $this->db->select('id_profilo,codice_ateco');
            $this->db->from('rrtq_profilo_ateco2007');
            $this->db->where('id_profilo', $id_profilo);
            $query = $this->db->get();
            $lista_ateco = $query->result_array();
            if (!empty($lista_ateco))
            {
                $this->response($lista_ateco, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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

    
    public function scheda_get()
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
            
            
            /*
            $this->db->where('id_profilo', $id_profilo);
            $query = $this->db->get('rrtq_profilo');
            $scheda['profilo'] = $query->result_array();
            
            $id_sep = $scheda['profilo'][0]['id_sep'];
            
            $this->db->where('id_sep', $id_sep);
            $query = $this->db->get('rrtq_sep');
            $scheda['profilo'][0]['sep'] = $query->result_array();
            */
            
            
            $this->response($scheda, REST_Controller::HTTP_OK); 
        }
    }
    
    
    
     public function decreto_get()
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
            $scheda = $this->qualificazione_model->select_qualificazione_decreto($id_profilo);
                        
            
            $this->response($scheda, REST_Controller::HTTP_OK); 
        }
    }
}
