<?php
    
  //  $deviceToken = 'a16188fb2b2f1b4e751b30db509af7f7850ffc4a3c9f7270a045eec713359253';
      $deviceToken = 'cfafccb3708d2bc65f54bd21a0d2adc1771da2b9085594812e87dc7a5d590b25';
    
    //$deviceToken = $_POST['reg_id'];
    
    // Put your private key's passphrase here:
    $passphrase = 'satdmac2';
    
    
    // Put your alert message here:
    //$message = mysql_real_escape_string($_POST['message']);
    $message="notification for phonegap";
    ////////////////////////////////////////////////////////////////////////////////
    
    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', 'dbatestdeveck.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    
    // Open a connection to the APNS server
    $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,
                               $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
    
    
    if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);
    
    
    echo 'Connected to APNS' . PHP_EOL;
    
    // Create the payload body
    $body['aps'] = array(
                         'alert' => $message,
                         'sound' => 'default',
                         'from_user'=>'user',
                         'action'=>'subscribe',
                         'farmly_id'=>'1956504082'
                         );
    
    //openssl s_client -connect gateway.sandbox.push.apple.com:2195  -cert PushChatCert.pem -key PushChatKey.pem
    // Encode the payload as JSON
    $payload = json_encode($body);
    
    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    //$result = fwrite($fp, $msg, strlen($msg)); to: $result = fwrite($fp, $msg);
    
    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));
    
    if (!$result)
	echo 'Message not delivered' . PHP_EOL;
    else
	echo 'Message successfully delivered' . PHP_EOL;
	echo $result;
    
    // Close the connection to the server
    fclose($fp);
    
    ?>