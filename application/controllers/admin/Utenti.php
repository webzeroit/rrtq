<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utenti extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        $this->output->set_template('admin');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    /**
     *  List Users     
     */
    public function index()
    {
        if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('Non hai i privilegi per visualizzare questa pagina.');
        }
        $this->output->set_title("Elenco Utenti");
        $data['message'] = "";
        //list the users
        $data['users'] = $this->ion_auth->users()->result_array();
        foreach ($data['users'] as $k => $user)
        {
            $data['users'][$k]['groups'] = $this->ion_auth->get_users_groups($user['id'])->result_array();
        }

        $this->load->view('auth/index', $data);
    }

    public function gestione($user_id = NULL)
    {
        if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('Non hai i privilegi per visualizzare questa pagina.');
        }

        $this->output->set_title("Gestione utente");

        $groups = $this->ion_auth->groups()->result_array();
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        if ($user_id === NULL)
        {
            $this->data['action'] = 'add';
            $this->data['user'] = NULL;
            $this->data['groups'] = $groups;
            $this->data['currentGroups'] = array();
        }
        else
        {
            $user = $this->ion_auth->user($user_id)->row_array();
            $currentGroups = $this->ion_auth->get_users_groups($user_id)->result_array();

            $this->data['action'] = 'edit';
            $this->data['user'] = $user;
            $this->data['groups'] = $groups;
            $this->data['currentGroups'] = $currentGroups;
        }

        $this->load->view('auth/gestione_utente', $this->data);
    }

    public function edit_profilo()
    {
        $this->output->set_title("Impostazioni profilo");
        $this->load->view('auth/edit_profilo');
    }

    /*
     * SEZIONE MESSAGGI
     */

    public function messages()
    {
        if (!$this->config->item('enable_messages')) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('Modulo messaggi non abilitato.');
        }
        
        $this->output->set_title("Centro messaggi");
        $this->load->view('auth/messages');
    }

    public function get_datatables_in_arrivo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('Messaggistica_model', 'messages');
        $output = $this->messages->datatables_in_arrivo();
        $this->_render_text($output);
    }

    public function segna_come_letto()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('Messaggistica_model', 'messages');
        if ($this->input->post('id_message'))
        {
            $output = $this->messages->segna_come_letto($this->input->post('id_message'));
        }
        else
        {
            $output = $this->messages->segna_come_letto();
        }
        $this->_render_json($output);
    }

    /*
     * FINE SEZIONE MESSAGGI
     */

    /* AJAX Call */

    public function save_utente()
    {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $action = $this->input->post('action');

        if ($action === "add")
        {
            $FormRules = array
                (
                array('field' => 'first_name', 'label' => 'Nome', 'rules' => 'trim|required',),
                array('field' => 'last_name', 'label' => 'Cognome', 'rules' => 'trim|required',),
                array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]'),
                array('field' => 'password', 'label' => 'Password', 'rules' => 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']'),
                array('field' => 'phone', 'label' => 'Telefono', 'rules' => 'trim|numeric|max_length[20]'),
                array('field' => 'groups[]', 'label' => 'Ruoli', 'rules' => 'required')
            );
        }
        else
        {
            $original_value = $this->ion_auth->user($this->input->post('id'))->row()->email;
            if ($this->input->post('email') != $original_value)
            {
                $is_unique = '|is_unique[' . $tables['users'] . '.email]';
            }
            else
            {
                $is_unique = '';
            }
            $FormRules = array
                (
                array('field' => 'first_name', 'label' => 'Nome', 'rules' => 'trim|required',),
                array('field' => 'last_name', 'label' => 'Cognome', 'rules' => 'trim|required',),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email' . $is_unique),
                array('field' => 'phone', 'label' => 'Telefono', 'rules' => 'trim|numeric|max_length[20]'),
                array('field' => 'groups[]', 'label' => 'Ruoli', 'rules' => 'required')
            );
        }


        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() === TRUE)
        {
            //NUOVO UTENTE
            if ($action === "add")
            {
                $email = strtolower($this->input->post('email'));
                $identity = $this->input->post('username');
                $password = $this->input->post('password');
                $groupData = $this->input->post('groups');
                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                );
                $ret = $this->ion_auth->register($identity, $password, $email, $additional_data, $groupData);
            }
            else
            {
                //MODIFICA UTENTE
                $user_id = $this->input->post('id');
                $email = strtolower($this->input->post('email'));
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                    'email' => $email
                );
                //AGGIORNAMENTO GRUPPI     
                $groupData = $this->input->post('groups');
                if (isset($groupData) && !empty($groupData))
                {
                    $this->ion_auth->remove_from_group('', $user_id);
                    foreach ($groupData as $grp)
                    {
                        $this->ion_auth->add_to_group($grp, $user_id);
                    }
                }
                $ret = $this->ion_auth->update($user_id, $data);
            }

            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di inserimento'
                );
            }
            else
            {
                $output = array(
                    'id' => $ret,
                    'esito' => 'success',
                    'message' => 'Salvataggio effettuato '
                );
            }
            $this->_render_json($output);
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

    public function activate($id)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('Non hai i privilegi per visualizzare questa pagina.');
        }

        $activation = $this->ion_auth->activate($id);

        if ($activation)
        {
            $output = array(
                'esito' => 'success',
                'message' => $this->ion_auth->messages()
            );
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => $this->ion_auth->errors()
            );
        }
        $this->_render_json($output);
    }

    public function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('Non hai i privilegi per visualizzare questa pagina.');
        }

        $id = (int) $id;
        $deactivation = $this->ion_auth->deactivate($id);
        if ($deactivation)
        {
            $output = array(
                'esito' => 'success',
                'message' => $this->ion_auth->messages()
            );
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => $this->ion_auth->errors()
            );
        }
        $this->_render_json($output);
    }

    public function save_profilo()
    {

        if (!$this->ion_auth->logged_in())
        {
            redirect('/', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $current_user = $this->ion_auth->user()->row_array();
        $user_id = $current_user['id'];
        $current_email = $current_user['email'];

        if ($this->input->post('email') != $current_email)
        {
            $is_unique = '|is_unique[' . $tables['users'] . '.email]';
        }
        else
        {
            $is_unique = '';
        }
        $FormRules = array
            (
            array('field' => 'first_name', 'label' => 'Nome', 'rules' => 'trim|required',),
            array('field' => 'last_name', 'label' => 'Cognome', 'rules' => 'trim|required',),
            array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email' . $is_unique),
            array('field' => 'phone', 'label' => 'Telefono', 'rules' => 'trim|numeric|max_length[20]')
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() === TRUE)
        {

            //MODIFICA UTENTE
            $email = strtolower($this->input->post('email'));
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'email' => $email
            );
            //AGGIORNAMENTO GRUPPI                 
            $ret = $this->ion_auth->update($user_id, $data);


            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di inserimento'
                );
            }
            else
            {
                $output = array(
                    'id' => $ret,
                    'esito' => 'success',
                    'message' => 'Salvataggio effettuato '
                );
            }
            $this->_render_json($output);
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('/', 'refresh');
        }

        if ($this->form_validation->run() === TRUE)
        {

            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                $output = array(
                    'id' => $change,
                    'esito' => 'success',
                    'message' => $this->ion_auth->messages()
                );
            }
            else
            {
                $output = array(
                    'esito' => 'error',
                    'message' => $this->ion_auth->errors()
                );
            }
            $this->_render_json($output);
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

}
