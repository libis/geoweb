<?php
require __DIR__ . '/../../vendor/autoload.php';


$clientId = "117575197375-n9ncon0eplbdslke1g2qle1ilq86rk9d.apps.googleusercontent.com";
$clientSecret = "7lVZ6VgcWOUfJoqeip96Jwph";
$refreshToken = "1\/f86KR5OI1sWUcLzNDZm5r7XatcZIUrfQIPvA4vmX0Cs";


            $resultaat = '';
            $adacode = $_GET['adacode'];
            $client = new \Google_Client();

            $client->setApplicationName('Google Drive API PHP Quickstart');
            $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
            $client->setAuthConfig('client_id.json');
            $client->setAccessType('offline');
            $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
            $client->setApprovalPrompt('force'); 
            $client->setClientSecret($clientSecret);
            
            if (file_exists('credentials.json')) {
                $accessToken = json_decode(file_get_contents('credentials.json'), true);
                $client->setAccessToken($accessToken);     
                file_put_contents('credentials.json', json_encode($client->getAccessToken()));
                if ($client->isAccessTokenExpired()) {
                        $client->fetchAccessTokenWithRefreshToken($refreshToken);
                        file_put_contents('credentials.json', json_encode($client->getAccessToken()));
                }            
                $service = new Google_Service_Drive($client);
                $q = 'name contains \''.$adacode.'\'';
                $optParams = array(
                    'includeTeamDriveItems'=> true,
                    'q' => $q,
                    'supportsTeamDrives' => true,
                    'pageSize' => 1,
                    'fields' => 'nextPageToken, files(id, name)'
                );
                $results = $service->files->listFiles($optParams);
                foreach ($results->getFiles() as $file) {
                    $href = 'https://drive.google.com/open?id='; 
                    $href .= $file->getId();
                    $result[0] = $href;
                    $file->getMimeType();
                    $contentUrl = $file->getWebContentLink();
                    $webcontentlink = "https://docs.google.com/uc?id=".$file->getId()."&amp;export=download";
                    $response = $service->files->get($file->getId(), array('alt' => 'media'));
                    $content = $response->getBody()->getContents();      
                    ini_set('memory_limit', '-1');  
                    set_time_limit (30);
                    file_put_contents($file->getName(),$content);

// met imagick php module en windows omgeving
                    /*
                    $image = new \Imagick(getcwd()."\\".$file->getName());
                    $naam = substr($file->getName(),0,(strpos($file->getName(),'.')));
                    $image->writeImage(getcwd()."\\".$naam.".jpg");
                    $result[0]="gdrive\\".$naam.".jpg";
                    $result[1]=getcwd()."\\".$naam.".jpg";
                    $result[2]=getcwd()."\\".$file->getName();
                    $resultaat = $result[0]."##".$result[1]."##".$result[2];
                     */
//met image magick op aezel server en command calls via exec
                    
                    $naam = substr($file->getName(),0,(strpos($file->getName(),'.')));
                    $result[0]="gdrive/".$naam.".jpg";
                    $result[1]=getcwd()."/".$naam.".jpg";
                    $result[2]=getcwd()."/".$file->getName();
                    $imagick = "/usr/local/bin/convert ".getcwd()."/".$file->getName()." ".getcwd()."/".$naam.".jpg";
                    exec( $imagick, $output );
                    $resultaat = $result[0]."##".$result[1]."##".$result[2];
 
                    break;
                }
            } 
    
    echo $resultaat;
?>