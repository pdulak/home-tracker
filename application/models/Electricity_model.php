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

    public function get_24h_counters()
    {
        $sql = "SELECT phase1_rae, phase1_fae, phase2_rae, phase2_fae, phase3_rae, phase3_fae, channel,
                        FROM_UNIXTIME(date_timestamp) AS dt FROM `mainElecticityMeter`
                WHERE date_timestamp > UNIX_TIMESTAMP( NOW() - INTERVAL 24 HOUR )";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
