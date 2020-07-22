<?php
class Electricity_model extends CI_Model {

    /*
    * UPDATE `mainElecticityMeter` AS m, `mainElecticityMeter` AS mm
    * SET m.phase1_rae_delta = m.phase1_rae - coalesce(mm.phase1_rae,0),
    * m.phase2_rae_delta = m.phase2_rae - coalesce(mm.phase2_rae,0),
    * m.phase3_rae_delta = m.phase3_rae - coalesce(mm.phase3_rae,0),
    * m.phase1_fae_delta = m.phase1_fae - coalesce(mm.phase1_fae,0),
    * m.phase2_fae_delta = m.phase2_fae - coalesce(mm.phase2_fae,0),
    * m.phase3_fae_delta = m.phase3_fae - coalesce(mm.phase3_fae,0),
    * m.date_converted = FROM_UNIXTIME(m.date_timestamp)
    * WHERE m.channel = mm.channel
    * AND m.date_converted IS NULL
    * AND mm.date_timestamp < m.date_timestamp
    * AND mm.date_timestamp > (m.date_timestamp-700)

UPDATE `mainElecticityMeter` AS m, `mainElecticityMeter` AS mm
     SET m.phase1_rae_delta = m.phase1_rae - coalesce(mm.phase1_rae,0),
     m.phase2_rae_delta = m.phase2_rae - coalesce(mm.phase2_rae,0),
     m.phase3_rae_delta = m.phase3_rae - coalesce(mm.phase3_rae,0),
     m.phase1_fae_delta = m.phase1_fae - coalesce(mm.phase1_fae,0),
     m.phase2_fae_delta = m.phase2_fae - coalesce(mm.phase2_fae,0),
     m.phase3_fae_delta = m.phase3_fae - coalesce(mm.phase3_fae,0)
     WHERE m.date_converted IS NULL
     AND m.channel = mm.channel
     AND mm.date_timestamp < m.date_timestamp
     AND mm.date_timestamp > (m.date_timestamp-700)


     UPDATE `mainElecticityMeter` AS m,  `mainElecticityMeter` AS mm
     SET m.phase1_rae_delta = m.phase1_rae - coalesce(mm.phase1_rae,0),
     m.phase2_rae_delta = m.phase2_rae - coalesce(mm.phase2_rae,0),
     m.phase3_rae_delta = m.phase3_rae - coalesce(mm.phase3_rae,0),
     m.phase1_fae_delta = m.phase1_fae - coalesce(mm.phase1_fae,0),
     m.phase2_fae_delta = m.phase2_fae - coalesce(mm.phase2_fae,0),
     m.phase3_fae_delta = m.phase3_fae - coalesce(mm.phase3_fae,0),
     m.date_converted = FROM_UNIXTIME(m.date_timestamp)
     WHERE m.date_converted IS NULL
     AND m.channel = mm.channel
     AND mm.date_timestamp = (select * from (select max(mmm.date_timestamp) FROM `mainElecticityMeter` AS mmm WHERE mmm.date_timestamp < mm.date_timestamp and mmm.channel = m.channel) as d ) 


    */

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

    public function get_monthly_counters()
    {
        $sql = "SELECT max(phase1_rae) as p1r, 
                    max(phase1_fae) as p1f, 
                    max(phase2_rae) as p2r, 
                    max(phase2_fae) as p2f, 
                    max(phase3_rae) as p3r, 
                    max(phase3_fae) as p3f, 
                    channel, month(FROM_UNIXTIME(date_timestamp)) AS m, year(FROM_UNIXTIME(date_timestamp)) AS y  
                FROM `mainElecticityMeter`
                GROUP BY channel, month(FROM_UNIXTIME(date_timestamp)), year(FROM_UNIXTIME(date_timestamp)) 
                ORDER BY year(FROM_UNIXTIME(date_timestamp)) , month(FROM_UNIXTIME(date_timestamp)), channel";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
