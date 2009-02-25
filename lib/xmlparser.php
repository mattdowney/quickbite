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

class xml_parser
{
    protected $result;

    public function parse($xml)
    {
        $this->result = array();
        $parser = xml_parser_create();
        xml_set_object($parser, $this);
        xml_set_element_handler($parser, 'start_tag', 'close_tag');   
        xml_set_character_data_handler($parser, 'tag_content');
        if (!xml_parse($parser, $xml))
            return false;
        xml_parser_free($parser); 
        return $this->result[0];
    }

    protected function start_tag($parser, $name, $atts)
    {
        $tag = array('name' => $name, 'attributes' => $atts);
        array_push($this->result, $tag);
    }

    protected function tag_content($parser, $tag_data)
    {
        if (trim($tag_data))
        {
            if (isset($this->result[count($this->result)-1]['content']))
                $this->result[count($this->result)-1]['content'] .= $tag_data;
            else
                $this->result[count($this->result)-1]['content'] = $tag_data;
        }
    }

    protected function close_tag($parser, $name)
    {
        $this->result[count($this->result)-2]['items'][] = $this->result[count($this->result)-1];
        array_pop($this->result);
    }
}
