<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
	include "config.php";
    include_once './GCM.php';
	$regId = 'APA91bHS6PN0H7SRz8TUC_DxW0_WJqrNFvCduC3clSnhjouGZ2m1jna4ED1xJUJ-AJBtzfLRg6aelibhL_NhpIDpKCUpt8p74-adDnWiVhh5zmn0GmMjGEDozdOLKFQ0ropeWWjmdrvQPo4Ajvq_GAXdsJk8KQpWow';
	
    $registatoin_ids = array($regId);
	$gcm = new GCM();
    $message = array("message" =>'Hello',"title"=>'DBA');
    $result = $gcm->send_notification($registatoin_ids, $message); 
    

?>
