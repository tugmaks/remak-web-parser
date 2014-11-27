<?php

/**
 * Description of RemakConnector
 *
 * @author tugmkas
 */
class RemakConnector {

    public $path;
    public $login;
    public $password;
    public $remakId;
    public $response;
    private $responseSplit;

    public function __construct($params) {
        $this->login = $params['login'];
        $this->password = $params['password'];
    }

    public function setRemakId($id) {
        $this->remakId = $id;
        return $this;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function run() {
        $this->response = $this->connect();
        $this->responseSplit = $this->split();
        return $this;
    }

    public function show() {
        return $this->response;
    }

    public function getSignalCount() {
        return count($this->responseSplit) - 1;
    }

    public function getAlarmCount() {

        return count($this->getAlarms());
    }

    public function getAlarms() {
        $alarms = [];
        foreach ($this->responseSplit as $signal) {
            if ($this->detectAlarm($signal)) {
                $alarms[] = $this->convert2object($signal);
            }
        }
        return $alarms;
    }

    private function parseSignal($signal) {
        return explode(',', $signal);
    }

    private function convert2object($signal) {
        $s = $this->parseSignal($signal);
        $o = new stdClass;

        $o->name = $s[0];
        $o->code = $s[1];
        $o->error = trim($s[2]);
        $o->type = $s[3];
        $o->remakId = $this->remakId;
        return $o;
    }

    private function detectAlarm($signal) {
        $s = $this->parseSignal($signal);
        if (count($s) > 3 && $s[2] !== '  ') {
            return true;
        }
        return false;
    }

    public function split($separator = '| ') {
        return explode($separator, $this->response);
    }

    private function connect() {
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connection, CURLOPT_URL, $this->path);
        curl_setopt($connection, CURLOPT_USERPWD, "$this->login:$this->password"); //login/pass - это и есть данные для аутентификации!!!!  
        return curl_exec($connection);
    }

}
