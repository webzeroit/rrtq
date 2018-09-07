<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Isced_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function list_detailed()
    {
        $this->db->select('t3.id_isced,t3.des_isced AS detailed', FALSE);
        $this->db->from('rrtq_isced AS t1');
        $this->db->join('rrtq_isced AS t2', 't2.parent_id = t1.id_isced');
        $this->db->join('rrtq_isced AS t3', 't3.parent_id = t2.id_isced');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_board()
    {
        $this->db->select('id_isced,des_isced as board');
        $this->db->from('rrtq_isced');
        $this->db->where('parent_id', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_children($parent_id)
    {
        $this->db->select('id_isced,des_isced');
        $this->db->from('rrtq_isced');
        $this->db->where('parent_id', $parent_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function build_tree()
    {
        $this->db->select('id_isced AS id, des_isced AS text, parent_id', FALSE);
        $query = $this->db->get('rrtq_isced');


        foreach ($query->result_array() as $row)
        {
            $sub_data["id"] = $row["id"];
            $sub_data["name"] = $row["text"];
            $sub_data["text"] = $row["text"];
            $sub_data["parent_id"] = $row["parent_id"];
            $data[] = $sub_data;
        }
        foreach ($data as $key => &$value)
        {
            $output[$value["id"]] = &$value;
        }
        foreach ($data as $key => &$value)
        {
            if ($value["parent_id"] && isset($output[$value["parent_id"]]))
            {
                $output[$value["parent_id"]]["nodes"][] = &$value;
            }
        }
        foreach ($data as $key => &$value)
        {
            if ($value["parent_id"] && isset($output[$value["parent_id"]]))
            {
                unset($data[$key]);
            }
        }
        
        return $data;
    }

}
