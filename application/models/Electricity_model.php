<?php
class Electricity_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_counters()
    {
        $query = $this->db->get('channelsLabels');
        return $query->result_array();
    }

}
