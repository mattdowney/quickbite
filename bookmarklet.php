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
$current_url  = 'http://'.$_SERVER['HTTP_HOST'].(str_replace('bookmarklet.php', '', $_SERVER['REQUEST_URI']));
$current_url .= (substr($current_url, -1) == '/' ? '' : '/');

?>
<?php echo '<'.'?xml version="1.0" encoding="UTF-8"'.'?'.'>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Create Bookmarklet</title>
    <style type="text/css" media="screen">
        body {
            background-color: #fff;
            margin: 30px;
            padding: 0;
            font: 14px/18px HelveticaNeue, "Helvetica Neue", Helvetica, Arial, Sans-serif;
            color: #3e3e3e;
        }
        h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
            margin: 14px 0 0 0;
        }
        #wrapper {
            width: 500px;
        }
        .large {
            font-size: 18px;
            font-weight: bold;
            margin-left: 10px;
        }
        .credit {
            font-size: 12px;
            color: gray;
            margin-top: 60px;
        }
        .imp {
            color: red;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        
        <h1>Grab the Bookmarklet</h1>
        
        <p>We think quickbite is installed at: <b><?php echo $current_url; ?></b>. If that's incorrect, you'll need to modify the code in this bookmarklet appropriately.</p>
        
        <p><b>Drag this bookmarklet to your browser's bookmarks bar:</b> <a class="large" href="javascript:window.open('<?php echo $current_url ?>?z=1&desc='+encodeURIComponent(''+(window.getSelection?window.getSelection():document.getSelection?document.getSelection():document.selection.createRange().text)).replace(/ /g,'+')+'&mp=<?php echo md5(DELICIOUS_PASS) ?>&tags=quickbite&u=<?php echo DELICIOUS_USER ?>&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)+'','Saving to Del.icio.us...','toolbar=0,resizable=0,status=1,width=240,height=140');void(0);">quickbite</a></p>
        
        <p class="imp"><b>NOTE:</b> When you're done with this file, please either delete it or rename it to something cryptic. If someone were to access this page, they could use it to post to your Del.icio.us account.</p>
        
        <p class="credit">Written by <a href="http://maniacalrage.net">Garrett Murray</a>. Updates at <a href="http://github.com/garrettmurray/quickbite">GitHub</a>.</p>
    

    </div>

</body>
</html>
