<?php

class input {

    function &input() {
        if (get_magic_quotes_gpc()) {
            if (isset($_REQUEST) && !isset($this->request))
                $this->request = $this->sanitize($_REQUEST, false);
            if (isset($_GET) && !isset($this->get))
                $this->get = $this->sanitize($_GET, false);
            if (isset($_POST) && !isset($this->post))
                $this->post = $this->sanitize($_POST, false);
            if (isset($_COOKIE) && !isset($this->cookie))
                $this->cookie = $this->sanitize($_COOKIE, false);
            if (isset($_SESSION) && !isset($this->session))
                $this->session = $this->sanitize($_SESSION, false);
            if (isset($_FILES) && !isset($this->files))
                $this->files = $this->sanitize($_FILES, false);
            if (isset($_SERVER) && !isset($this->server))
                $this->server = $this->sanitize($_SERVER, false);
        }
        else {
            if (isset($_REQUEST) && !isset($this->request))
                $this->request = $this->sanitize($_REQUEST, false);
            if (isset($_GET) && !isset($this->get))
                $this->get = $this->sanitize($_GET, true);
            if (isset($_POST) && !isset($this->post))
                $this->post = $this->sanitize($_POST, true);
            if (isset($_COOKIE) && !isset($this->cookie))
                $this->cookie = $this->sanitize($_COOKIE, true);
            if (isset($_SESSION) && !isset($this->session))
                $this->session = $this->sanitize($_SESSION, true);
            if (isset($_FILES) && !isset($this->files))
                $this->files = $this->sanitize($_FILES, true);
            if (isset($_SERVER) && !isset($this->server))
                $this->server = $this->sanitize($_SERVER, false);
        }

        if (!isset($this->url))
            $this->url = substr($this->server['PATH_INFO'], -1) != '/' ? basename($this->server['SCRIPT_NAME']) . $this->server['PATH_INFO'] . '/' : basename($this->server['SCRIPT_NAME']) . $this->server['PATH_INFO'];
        if (!isset($this->uri))
            $this->uri = explode('/', substr($this->server['PATH_INFO'], -1) != '/' ? basename($this->server['SCRIPT_NAME']) . $this->server['PATH_INFO'] : basename($this->server['SCRIPT_NAME']) . substr($this->server['PATH_INFO'], 0, -1));
    }

    function sanitize($input_data, $sanitize = true) {
        $output_data = NULL;
        if (is_array($input_data)) {
            foreach ($input_data as $input_key => $input_value) {
                $output_data[$input_key] = $this->sanitize($input_value, $sanitize);
                print("<pre>");
                print_r($output_data);
                print("</pre>");
            }

            return $output_data;
        } elseif ($sanitize) {
            return addslashes($input_data);
        } else {
            return $input_data;
        }
    }

}

?>