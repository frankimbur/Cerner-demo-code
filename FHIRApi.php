<?php
class FHIRApi{ 
    public function __construct() {
        $this->baseurl = 'https://fhir-open.sandboxcerner.com/dstu2/0b8a0111-e8e6-4c26-a91c-5069cbc6b1ca/';
    }

    public function FHIRGET($uri, array $params, $extraUrlText="") {        
        $headers = array(
                    'Accept' => 'application/json',
                );
        return $this->FHIRCall("GET", $this->baseurl, $params, $headers,$extraUrlText);
    }


    // Find Patient Using Name From FHIR
    public function FHIRFindPatientsUsingName($params = array()) 
    {
        $url = $this->baseurl;

        $extraUrlText = "Patient";
        $headers = array(
                    'Accept' => 'application/json',
                );

        if (isset($params['firstname']) && !empty($params['firstname']) && isset($params['lastname']) && !empty($params['lastname'])) {
            $parameters = array('family' => $params['lastname'], 'given' => $params['firstname']);
        } elseif (isset($params['firstname']) && !empty($params['firstname']) && empty($params['lastname'])) {
            $parameters = array('given' => $params['firstname']);
        } elseif (isset($params['lastname']) && !empty($params['lastname']) && empty($params['firstname'])) {
            $parameters = array('family' => $params['lastname']);
        }


        $resp = $this->FHIRGET($url,$parameters,$extraUrlText);
        return $resp;
    }

    public function FHIRCall($verb, $url, $body, $headers, $otherText = '', $secondcall=false) 
    {
        $formatted_headers = array();
        foreach ($headers as $k => $v) {
            $formatted_headers[] = $k . ': ' . $v;
        }

        $DataPerms = '';
        foreach ($body as $key => $value) {
            $DataPerms.=$key.'='.$value.'&';
        }
        if (!empty($body)) {
            $RequestFullURL = $url.$otherText."?".$DataPerms;
        }
        else
        {
            $RequestFullURL = $url.$otherText;
        }
        $curl = curl_init();

        $port = array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $RequestFullURL,
            $port,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $formatted_headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            return json_decode($response, true);
        }

    }

}