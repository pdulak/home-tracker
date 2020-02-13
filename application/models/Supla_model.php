<?php 
class Supla_model extends CI_Model {
// endpoint = "https://svr12.supla.org/api/v2.3.0/channels/" + str(channel) + "/measurement-logs?limit=1500"
// headers = {"Authorization": "Bearer " + dbconfig.API['key'], "accept": "application/json"}


    public function __construct()
    {
        require_once('Supla_secret.php');
        $this->token = $supla_secret['token'];
    }

    public function get_counter_state($id)
    {
        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, "https://svr12.supla.org/api/v2.3.0/channels/" . $id . "?include=state");
        // confiture bearer authorization
        $authorization = "Authorization: Bearer " . $this->token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch); 

        $result = json_decode($output);
        return $result->state;
    }

    
}