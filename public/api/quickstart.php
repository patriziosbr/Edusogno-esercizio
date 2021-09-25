<?php
require __DIR__ . './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/PHPMailer/src/Exception.php';
require './vendor/phpmailer/PHPMailer/src/PHPMailer.php';
require './vendor/phpmailer/PHPMailer/src/SMTP.php';

//per ripristinare token.json: eliminare api/token.json 
// commentare da db_connect a close all user e invio mail smtp
// RUN php quickstart.php prendere la chiave e decommentare
include_once '../db/DB_connect.php';

//get mails x google
$getMail = "SELECT email FROM utenti";
$mail = $conn->query($getMail);
// var_dump($users->fetch_assoc());
// die();
$allMail = [];
for ($i=0; $i < $mail->num_rows; $i++) { 
    $allMail[] = $mail->fetch_assoc();
};
//array con tutti mail inseriti nel DB
// var_dump($allMail);
// die();
// close get mails x google

//get last event
$lastEvent = "SELECT * FROM eventi ORDER BY id DESC LIMIT 1";
$result = $conn->query($lastEvent);

$eventInfo = $result->fetch_assoc();
//array con ultimo evento inserito 
// var_dump($eventInfo);
// die();
//close get last event


//all users
$getUsers = "SELECT * FROM utenti";
$user = $conn->query($getUsers);
// var_dump($users->fetch_assoc());
// die();
$allUsers = [];
for ($i=0; $i < $user->num_rows; $i++) { 
    $allUsers[] = $user->fetch_assoc();
};
//close all users

// if (php_sapi_name() != 'cli') {
//     throw new Exception('This application must be run on the command line.');
// }

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('edusogno');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = '2kp21l60t2a6ga56s8ajajbd7s@group.calendar.google.com';
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

// dettagli evento
$event = new Google_Service_Calendar_Event(array(
    'summary' => $eventInfo['nome_evento'],
    'location' => 'Online',
    'description' => $eventInfo['desc_evento'],
    'start' => array(
      'dateTime' => $eventInfo['data_evento'].'T'.$eventInfo['ora_evento'],
      'timeZone' => 'Europe/Amsterdam',
    ),
    'end' => array(
      'dateTime' => $eventInfo['data_evento'].'T'.$eventInfo['ora_evento'],
      'timeZone' => 'Europe/Amsterdam',
    ),
    'recurrence' => array(
      'RRULE:FREQ=DAILY;COUNT=2'
    ),
    'attendees' => $allMail,
    'reminders' => array(
      'useDefault' => FALSE,
      'overrides' => array(
        array('method' => 'email', 'minutes' => 24 * 60),
        array('method' => 'popup', 'minutes' => 10),
      ),
    ),
    "conferenceData" => [
      "createRequest" => [
        "conferenceSolutionKey" => [
          "type" => "hangoutsMeet"
        ],
        "requestId" => "default"
      ]
    ]
  )); // dettagli evento

  $calendarId = '2kp21l60t2a6ga56s8ajajbd7s@group.calendar.google.com';
  $opt = array('sendNotifications' => true, 'conferenceDataVersion' => true );
  $event = $service->events->insert($calendarId, $event, $opt);
  $meetLink = $event->hangoutLink; //link meet
  printf('Event created: %s\n', $event->htmlLink);

if (empty($events)) {
    print "No upcoming events found.\n";
} else {
    print "Upcoming events:\n";
    foreach ($events as $event) {
        $start = $event->start->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }
        printf("%s (%s)\n", $event->getSummary(), $start);
    }
};

// invio mail smtp
foreach ($allUsers as $oneUser) {
  $mail = new PHPMailer(true);
  try {
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'patrizio.sbrozzi.edusogno.test@gmail.com';
      $mail->Password = 'pippoplutopaperino';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
  
      $mail->setFrom('no-reply@edusogno.com', 'Mailer');
      $mail->addCC($oneUser['email']);
  
      $mail->isHTML(true); 
      $mail->Subject = 'Reminder evento';
      $mail->Body = "<h2>Ciao " . $oneUser['nome_utente'] . ' ' . $oneUser['cognome_utente']  . "</h2>" . "<br>" . "<p>sei stato invitato all'evento " . $eventInfo['nome_evento'] . ' in data ' . $eventInfo['data_evento'] . ' ' . $eventInfo['ora_evento'] . ' e puoi partecipare alla call tramite il seguente link ' . $meetLink . "</p>" ;
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
      $mail->send();
      echo 'Messaggio inviato';
  } catch (Exception $e) {
      echo 'Messaggio non inviato. Mailer Error: ', $mail->ErrorInfo;
  }
} // fine foreach close invio mail smtp

//prevent 
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");


