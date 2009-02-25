<?php

// License
// -------
// 
// Software License Agreement (BSD License)
// 
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

require('_conf.php');
require('lib/quickbite.php');
$qb = new quick_bite(DELICIOUS_USER, DELICIOUS_PASS);
$create_post = false;

if (array_key_exists('z', $_GET) && $_GET['z'] == '1')
{
    if (
        (array_key_exists('u', $_GET) && $_GET['u'] == DELICIOUS_USER) &&
        (array_key_exists('mp', $_GET) && $_GET['mp'] == md5(DELICIOUS_PASS))
        )
    {
        $create_post = true;
        $url = $_GET['url'];
        $desc = $_GET['title'];
        $notes = $_GET['desc'];
        $tags = array($_GET['tags']);
        $date = date('Y-m-d H:i:s', time());
    }
}

?>
<?= '<'.'?xml version="1.0" encoding="UTF-8"'.'?'.'>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Saving to Del.icio.us...</title>
    <style type="text/css" media="screen">
        body {
            background-color: #d2d2d2;
            margin: 0;
            padding: 0;
            font: 18px/18px HelveticaNeue, "Helvetica Neue", Helvetica, Arial, Sans-serif;
            color: #3e3e3e;
        }
        h1, h3 {
            margin: 0;
            padding: 0;
        }
        h1 {
            margin: 14px 0 0 0;
        }
        h3 {
            color: #000;
            font-size: 14px;
            background: url('img/icon.gif') no-repeat left top;
            padding: 0 0 0 28px;
            margin: 8px 0 0 1px;
        }
        #wrapper {
            background-color: #fff;
            -webkit-border-radius: 14px;
            -moz-border-radius: 14px;
            padding: 20px 20px 20px 30px;
            width: 170px;
            height: 80px;
            margin: 10px;
        }
        .err, .good {
            color: red;
            font-size: 11px;
            margin-top: 8px;
        }
        .good {
            color: green;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <h3>del.icio.us</h3>
        <h1>Saving...</h1>
        <div class="err">
            
            <?php

            if ($create_post)
            {
                $result = $qb->add_post($url, $desc, $notes, $tags, $date);
                if ($result == '1' || $result == '')
                    echo '<script type="text/javascript" charset="utf-8">setTimeout(\'window.close()\', 700);</script><div class="good">Done!</span>';
                else
                    echo ERROR;
            }
            else
            {
                echo 'No info submitted!';
            }

            ?>
            
        </div>
    </div>

</body>
</html>
