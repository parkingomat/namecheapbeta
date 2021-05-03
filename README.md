# namecheapphp
# Script to set new domain name records for any provided domain using namecheap.com REST API.
# Namecheap don't provide functionality to delete specific dns record.this script will fetch all the records from get call and only update the provided one
# To delete all records for the domain you can simply pass DeleteAll = true
# To delete specific record just pass the RecordType for example RecordType=A,CNAME,URL & deleteRecord=true


# Currently Support and Tested CNAME,A,URL record modification

# SetHostName   modifydomain.php?SetHostName=@
# SetRecordType modifydomain.php?SetRecordtype=A,CNAME,URL
# Address       modifydomain.php?Address=IP,URL depends on Record Type
# TTL           modifydomain.php?TTL=VALUE 300-1800
# DeleteRecord  modifydomain.php?SetRecordtype=A&DelecteRecord=true delete the specific record
# DeleteAll     modifydomain.php?DeleteAll=true Use with caution will delete all records for the domain


# Examples provided below
# http://yourhost.com/modifydomain.php?SetHostName=@&SetRecordType=A&Address=192.168.1.1&TTL=300
# http://yourhost.com/modifydomain.php?SetHostName=@&SetRecordType=URL&Address=www.google.com&TTL=300
# http://yourhost.com/modifydomain.php?SetHostName=@&SetRecordType=CNAME&Address=abc.domain.com&TTL=300
# http://yourhost.com/modifydomain.php?SetRecordType=A&DeleteRecord=true
# http://yourhost.com/modifydomain.php?DeleteAll=true


# CONFIG EXAMPLE
# $namecheap_url = "https://api.namecheap.com/xml.response?";   #Url it will remain same always
# $user_name = "demo_user";                          #Require user name
# $api_user = "demo_user";                           #Require api user
# $api_key = "yoosaeb1thoh6xaiw8lohngi0aiDahy3";     #Require api key
# $command_get = "namecheap.domains.dns.getHosts";   #Always Remain the same
# $command_set = "namecheap.domains.dns.setHosts";   #Always Remain the same
# $client_ip = "192.168.1.1";                        #Require whitelist IP
# $sld = "xyz";                                      #Require domain name for xyz
# $tld = "com";                                      #Require top level domain for example xyz.com TLD=com

