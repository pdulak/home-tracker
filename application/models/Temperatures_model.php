<?php
class Temperatures_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_single_folder($fid)
    {
        $this->db->select('name');
        $query = $this->db->get_where('podsafe_folders', array('fid' => $fid));
        return $query->row_array();
    }

    public function get_last_temps()
    {
        $sql = "SELECT l.* , t.value, t.date_timestamp
                FROM tempMetersLabels AS l
                    LEFT OUTER JOIN (
                        SELECT max(id) AS maxId, address FROM tempMeters    
                        GROUP BY address     
                        ) AS tMax
                    ON l.address = tMax.address
                        LEFT OUTER JOIN tempMeters AS t
                        ON l.address = t.address
                        AND tMax.maxId = t.id
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_24h_temps()
    {
        $sql = "SELECT t.date_timestamp AS dt, t.value AS v, l.id
                FROM tempMeters AS t
                    INNER JOIN tempMetersLabels AS l
                    ON t.address = l.address
                WHERE date_timestamp > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                ORDER BY date_timestamp";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
