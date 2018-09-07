<?php

class Activity_log_model extends CI_Model
{

    /**
     * Admin-only log types
     * 
     * @var array
     */
    private $admin_types = array('page_access', 'user_registered', 'logged_in', 'login_failed', 'login_failed_sa');

    /**
     * Main user activity logging function
     * 
     * @param string $action
     * @param array $arr Additional attributes per case
     * @return void
     */
    public function log($action, $arr = array())
    {
        /* add additional info to the message */
        $extra_info = "";
        if (isset($arr['extra_info']))
        {
            $extra_info = $arr['extra_info'];
        }

        switch ($action)
        {
            default:
                return;
            case 'add':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha aggiunto id {$arr['id']} nella tabella {$arr['table']} {$extra_info}";
                break;
            case 'edit':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha modificato id {$arr['id']} nella tabella {$arr['table']} {$extra_info}";
                break;
            case 'export':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha esportato id {$arr['id']} dalla tabella {$arr['table']} {$extra_info}";
                break;
            case 'delete':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha cancellato id {$arr['id']} dalla tabella {$arr['table']} {$extra_info}";
                break;
            case 'publish':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha pubblicato id {$arr['id']} dalla tabella {$arr['table']}";
                break;
            case 'unpublish':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha sospeso la pubblicazione id {$arr['id']} dalla tabella {$arr['table']}";
                break;
            case 'revision':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha inserito in revisione id {$arr['id']} dalla tabella {$arr['table']}";
                break;
            case 'revision_ok':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha approvato le revisioni id {$arr['id']} dalla tabella {$arr['table']}";
                break;   
            case 'restore_ok':
                $username = $this->ion_auth->user()->row()->username;
                $msg = "{$username} ha ripristinato id {$arr['id']} dalla tabella {$arr['table']}";
                break;              
        }
        $data = array(
            'action' => $action,
            'type' => in_array($action, $this->admin_types) ? 'admin' : 'all',
            'message' => $msg
        );
        $this->add_info();
        $this->db->insert('sys_activity_log', $data);
    }

    /**
     * Adds identifier information to the insert query
     * 
     * @return void
     */
    public function add_info()
    {
        $user_id = $this->ion_auth->user()->row()->id;
        $this->db->set('time', 'NOW()', false);
        $this->db->set('ip', $this->input->ip_address());
        if (!empty($user_id))
        {
            $this->db->set('user_id', $user_id);
        }
    }

    /* TABELLA */

    public function datatables_log()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id, user_id, DATE_FORMAT(time, "%d/%m/%Y %H:%i:%s") as time, action, message, ip')
                ->from('sys_activity_log');

        return $this->datatables->generate();
    }


    /**
     * Truncates user_activity table
     * 
     * @return boolean
     */
    public function delete_logs()
    {
        return $this->db->truncate('sys_activity_log');
    }

    /**
     * Stub for automate hook to add 'added' activity
     * 
     * @param array $data
     */
    public function automate_activity_add($data)
    {
        $this->activity->log('added', array('table' => $data['table'], 'id' => $data['id']));
    }

    /**
     * Stub for automate hook to add 'modified' activity
     * 
     * @param array $data
     */
    public function automate_activity_modify($data)
    {
        $this->activity->log('modified', array('table' => $data['table'], 'id' => $data['id']));
    }

}
