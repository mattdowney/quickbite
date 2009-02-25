<?php

// This class uses selected code originally written by Edward Eliot for the
// PhpDelicious project (http://www.phpdelicious.com/). Because of this, Edward
// is included in this BSD license.
// 
// License
// -------
// 
// Software License Agreement (BSD License)
// 
// Copyright (C) 2005-2008, Edward Eliot.
// Copyright (C) 2009, Garrett Murray.
// All rights reserved.
//    
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions are met:
// 
// * Redistributions of source code must retain the above copyright
//   notice, this list of conditions and the following disclaimer.
// * Redistributions in binary form must reproduce the above copyright
//   notice, this list of conditions and the following disclaimer in the
//   documentation and/or other materials provided with the distribution.
// * Neither the name of Edward Eliot nor the names of its contributors 
//   may be used to endorse or promote products derived from this software 
//   without specific prior written permission of Edward Eliot.
// 
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS "AS IS" AND ANY
// EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
// WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
// DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
// DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
// LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
// ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
// (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
// SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

require('xmlparser.php');
define('DELICIOUS_BASE_URL', 'https://api.del.icio.us/v1/');
define('DELICIOUS_JSON_URL', 'http://badges.del.icio.us/feeds/json/');
define('DELICIOUS_USER_AGENT', 'QuickBite 1.0');
define('DELICIOUS_CONNECT_TIMEOUT', 5);
define('DELICIOUS_TRANSFER_TIMEOUT', 20);
define('DELICIOUS_DNS_TIMEOUT', 86400);
define('ERROR', 'Couldn\'t add bookmark.');

class quick_bite
{
    protected $user;
    protected $pass;
    protected $parser;

    function __construct($username, $password)
    {
        $this->user = urlencode($username);
        $this->pass = urlencode($password);
        $this->parser = new xml_parser();
    }

    public function add_post($url, $desc, $notes = '', $tags = array(), $date = '', $replace = OVERWRITE_DUPLICATES, $shared = SHARE_BOOKMARKS)
    {
        $params = array('url' => $url, 'description' => $desc, 'extended' => $notes, 'tags' => implode(' ', $tags));

        if ($date != '')
            $params['dt'] = date('Y-m-d\TH:i:s\Z', strtotime($date));
        if (!$replace)
            $params['replace'] = 'no';
        if (!$shared)
            $params['shared'] = 'no';

        if ($result = $this->send_delicious_request('posts/add', $params))
            return $this->check_return_code($result['attributes']['CODE']);
        
        return ERROR;
    }
    
    protected function check_return_code($code) { return ($code == 'done' || $code == 'ok'); }
    
    protected function send_delicious_request($cmd, $params = array())
    {
        $cmd = DELICIOUS_BASE_URL.$cmd . ((count($params) > 0) ? '?' : '');
        $c = 0;

        foreach ($params as $key => $val)
        {
            if ($val != '')
            {
                $cmd .= (($c > 0) ? '&' : '') . "{$key}=" . urlencode($val);
                $c++;
            }
        }

        if ($xml = $this->http_request($cmd))
        {
            if ($xml = $this->parser->parse($xml))
                return $xml;
        }  
            
        return false;
    }
    
    protected function http_request($cmd)
    {
        if (function_exists('curl_init'))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $cmd);
            curl_setopt($ch, CURLOPT_USERAGENT, DELICIOUS_USER_AGENT);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, DELICIOUS_CONNECT_TIMEOUT);
            curl_setopt($ch, CURLOPT_TIMEOUT, DELICIOUS_TRANSFER_TIMEOUT);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, DELICIOUS_DNS_TIMEOUT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_USERPWD, "$this->user:$this->pass");
            
            if ($result = curl_exec($ch))
            {
                switch (curl_getinfo($ch, CURLINFO_HTTP_CODE))
                {
                    case 200:
                        return $result;
                        break;
                    default:
                        return false;
                }
            }
            
            curl_close($ch);            
        }
        return false;
    }
}
