<?php

class Harvest {

    protected $certificatePath;

    public function __construct() {
        $this->certificatePath = realpath(dirname(__FILE__)) . "/cacert.pem";
    }

    /**
     * sendRequest method
     * 
     * @param string $url
     * @return string 
     */
    protected function sendRequest($url) {
        $url = 'https://cyberduckuk.harvestapp.com' . $url;
        $username = 'sylvain@cyber-duck.co.uk';
        $password = 'BMWDuck3';

        $ch = curl_init();
        curl_setopt_array($ch, array(CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => $this->certificatePath,
            CURLOPT_USERPWD => $username . ':' . $password,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
                'Accept: application/xml'
                )));
        $result = curl_exec($ch);
        if ($result === false)
            echo curl_error($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * parseResponse method
     * 
     * @param string $response
     * @return SimpleXMLElement
     */
    protected function parseResponse($response) {
        try {
            return new SimpleXMLElement($response);
        } catch (Exception $exc) {
            
        }
        return false;
    }

    /**
     * getEntries method
     * 
     * @param integer $projectId
     * @param string $from
     * @param string $to
     * @return SimpleXMLElement
     */
    public function getEntries($projectId, $from = '', $to = '') {
        $from = (empty($from)) ? date('Ymd', mktime(0, 0, 0, date('n'), 1, date('Y') - 2)) : $from;
        $to = (empty($to)) ? date('Ymd') : $to;

        $result = $this->sendRequest('/projects/' . $projectId . '/entries?from=' . $from . '&to=' . $to);

        if (!is_object($SimpleXMLElement = $this->parseResponse($result)))
            return;

        return $SimpleXMLElement;
    }

    /**
     * getTasks method
     * 
     * @return SimpleXMLElement 
     */
    public function getTasks() {
        $response = $this->sendRequest('/tasks');

        if (!is_object($SimpleXMLElement = $this->parseResponse($response)))
            return;

        return $SimpleXMLElement;
    }

    /**
     * getClients method
     * 
     * @return SimpleXMLElement 
     */
    public function getClients() {
        $response = $this->sendRequest('/clients');

        if (!is_object($SimpleXMLElement = $this->parseResponse($response)))
            return;

        return $SimpleXMLElement;
    }
    
    /**
     * getProjects method
     * 
     * @return SimpleXMLElement 
     */
    public function getProjects() {
        $response = $this->sendRequest('/projects');

        if (!is_object($SimpleXMLElement = $this->parseResponse($response)))
            return;

        return $SimpleXMLElement;
    }
    
    /**
     * getUsers method
     * 
     * @return SimpleXMLElement 
     */
    public function getUsers() {
        $response = $this->sendRequest('/people');

        if (!is_object($SimpleXMLElement = $this->parseResponse($response)))
            return;

        return $SimpleXMLElement;
    }
    
    /**
     * getTasks method
     * 
     * @return SimpleXMLElement 
     */
    public function getTasks() {
        $response = $this->sendRequest('/tasks');

        if (!is_object($SimpleXMLElement = $this->parseResponse($response)))
            return;

        return $SimpleXMLElement;
    }

}

?>