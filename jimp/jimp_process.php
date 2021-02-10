<?php 
//Load SDK for Environmentals and Zoho SDK

include_once('vendor/autoload.php'); 
use Zoho\CRM\ZohoClient;


$JimpClientID='YOUR API CLIENT ID';
$JimpClientSecret='YOUR API CLIENT SECRET';
$JimpRefreshToken = 'REFESH TOKEN RETURNED AT THE END OF THE GETTOKEN.PHP SCRIPT ON THE FIRST RUN AUTHENTICATION';
$JimpOutputFile='FILE TO CREARE FROM ZOHO RESULTS.TXT';
$CVID = 'Custom View ID';

echo 'Environment Running<br>';

// Get Code from response

$ZohoClient = new ZohoClient(); // Make the connection to zoho api

$ZohoClient->setAuthRefreshToken($JimpRefreshToken);
$ZohoClient->setZohoClientId($JimpClientID);
$ZohoClient->setZohoClientSecret($JimpClientSecret);
$refresh = $ZohoClient->generateAccessTokenByRefreshToken();

echo 'Tokens Generated<br>';

$rslt = $ZohoClient->getDefaultHeaders();
$hdr = key($rslt) . ": " . $rslt[key($rslt)];	// sets the auth http header in the format:	"Authorization: Zoho-oauthtoken 1000.65f0085c05c2f8fe99b1b5dbe005ca79.bb5d36a4de18694cc364c30963be7346"
$arrHdr[] = $hdr;								// make it a single entry array


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://recruit.zoho.com/recruit/private/xml/JobOpenings/getCVRecords?fromIndex=1&toIndex=200&cvid='.$CVID.'&selectColumns=All&newFormat=2');
$fp = fopen($JimpOutputFile, 'w');
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHdr);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_exec ($ch); 
curl_close ($ch);
fclose($fp);

echo "Import Complete<br>";
echo "Data written to disk file ".$JimpOutputFile."<br>";


function GetBetween($var1="",$pool){
      $var1 .= '"><![CDATA['; 
      $pos = strpos($pool,$var1);
      if($pos === false) {
          return '';
      }
      else {
            $temp1 = strpos($pool,$var1)+strlen($var1);
            $result = substr($pool,$temp1,strlen($pool));
            $dd=strpos($result,"]]></FL>");
                if($dd == 0){
                  $dd = strlen($result);
                }
                return substr($result,0,$dd);
       }         
}
  

// Process File
$string = file_get_contents($JimpOutputFile, FILE_USE_INCLUDE_PATH);
$string = str_replace('<?xml version="1.0" encoding="UTF-8" ?>', "", $string);
$pieces = explode("<row", $string);
$recordcount = substr_count($string, '<row');


// Loop though the records and return the Data
for ($k = 1 ; $k <= $recordcount; $k++){ 

          echo GetBetween('REF',$pieces[$k]).' - '.GetBetween('Created Time',$pieces[$k]).'<br>';
                    
}






?>

