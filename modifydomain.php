<?php

header("content-type: text/plain;charset=utf8");


$response = "";
$additiona_parameters = "";


$namecheap_url = "https://api.namecheap.com/xml.response?";   #Url it will remain same always
$user_name = "{USER_NAME}";                        #Require user name
$api_user = "{API_USER}";                          #Require api user
$api_key = "{API_KEY}";                            #Require api key
$command_get = "namecheap.domains.dns.getHosts";   #Always Remain the same
$command_set = "namecheap.domains.dns.setHosts";   #Always Remain the same
$client_ip = "{WHITELIST_IP}";                     #Require whitelist IP
$sld = "{DOMAIN_NAME}";                            #Require domain name for example xyz
$tld = "{TLD}";                                    #Require top level domain for example xyz.com TLD=com

$get_records_list = "{$namecheap_url}apikey={$api_key}&Command={$command_get}".
              "&ClientIp={$client_ip}&SLD={$sld}&TLD={$tld}".
              "&username={$user_name}&apiuser={$api_user}";

$set_hosts_call = "{$namecheap_url}apikey={$api_key}&Command={$command_set}".
              "&ClientIp={$client_ip}&SLD={$sld}&TLD={$tld}".
              "&username={$user_name}&apiuser={$api_user}";
              


execute_rest_call($get_records_list);



$xml=simplexml_load_string($response);
if(empty($_GET)) {

  print_r($xml);
  exit(1);

}


$hostCount = 0;
$Count = 1;
$recordMatch = 0;

if($_GET['DeleteAll']=="true") {
$set_hosts_call .= $additiona_parameters;
execute_rest_call($set_hosts_call);
$xml=simplexml_load_string($response);
print_r($xml);
exit(1);
}

foreach($xml->CommandResponse->DomainDNSGetHostsResult->children() as $host) {  

      $record_type = $xml->CommandResponse->DomainDNSGetHostsResult->host[$hostCount]['Type'];
      $host_name = $xml->CommandResponse->DomainDNSGetHostsResult->host[$hostCount]['Name'];        
      $address = $xml->CommandResponse->DomainDNSGetHostsResult->host[$hostCount]['Address'];
      $ttl = $xml->CommandResponse->DomainDNSGetHostsResult->host[$hostCount]['TTL'];  

      if($_GET['SetRecordType']==$record_type) {

        if($_GET['DeleteRecord']=="true") {
            $hostCount++;
            continue;
        }
        
        $additiona_parameters .= "&HostName{$Count}={$_GET['SetHostName']}".
                                 "&RecordType{$Count}={$_GET['SetRecordType']}".
                                 "&Address{$Count}={$_GET['Address']}".
                                 "&TTL{$Count}={$_GET['TTL']}"; 
                                 
                                 
        $recordMatch = 1;
        $hostCount++;
        $Count++;
        continue;
      }  
             
      $additiona_parameters .= "&HostName{$Count}={$host_name}".
                               "&RecordType{$Count}={$record_type}".
                               "&Address{$Count}={$address}".
                               "&TTL{$Count}={$ttl}";                
      $hostCount++;
      $Count++;
}


if ($recordMatch == 0 && $_GET['DeleteRecord']!="true") {        
  
    $additiona_parameters .= "&HostName{$Count}={$_GET['SetHostName']}".
    "&RecordType{$Count}={$_GET['SetRecordType']}".
    "&Address{$Count}={$_GET['Address']}".
    "&TTL{$Count}={$_GET['TTL']}"; 
}

$set_hosts_call .= $additiona_parameters;
echo $set_hosts_call;
execute_rest_call($set_hosts_call);

$xml=simplexml_load_string($response);
print_r($xml);


function execute_rest_call($result_url) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "{$result_url}",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $GLOBALS['response'] = curl_exec($curl);
    curl_close($curl);    
}




?>