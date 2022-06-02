<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_PeopleService;
use Google_Service_Calendar_Event;
use Carbon;

class TokenController extends Controller
{
    //

    public function GetToken()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
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

    public function CreateEvent(Request $request)
    {
        $client = $this->GetToken();

        // $client = getClient();

        $service = new Google_Service_Calendar($client);

        $start_date = Carbon\Carbon::parse('2021-10-24T09:00:00-07:00')->format('Y-m-d H:i');

        $end_date = Carbon\Carbon::parse($request->schedule_date ."". $request->schedule_time)->addHour(2)->format('Y-m-d H:i');



        $event = new Google_Service_Calendar_Event(array(
          'summary' => 'OnCon Online Consultation',
          // 'location' => '800 Howard St., San Francisco, CA 94103',
          'description' => 'Event Description',
          'start' => array(
            'dateTime' => $start_date,
            'timeZone' => 'Asia/Singapore',
        ),
          'end' => array(
            'dateTime' => $end_date,
            'timeZone' => 'Asia/Singapore',
        ),
          'attendees' => array(
            array('email' => $request->client_email),
            array('email' => $request->lawyer_email),
        ),
          'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
              array('method' => 'email', 'minutes' => 24 * 60),
              array('method' => 'popup', 'minutes' => 10),
          ),
        ),
          'conferenceData' => [
            'createRequest' => [
                'requestId' => 'randomString'.time()
            ]
        ]
    ));

        $calendarId = 'oncon.capstone@gmail.com';

        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        return $event;
        // printf('Event created: %s\n', $ event->htmlLink);
    }

    public function CreateEventOrig()
    {
        $client = $this->GetToken();
        // $client = getClient();
        $service = new Google_Service_Calendar  ($client);



        $event = new Google_Service_Calendar_Event(array(
          'summary' => 'Google I/O 2015',
          'location' => '800 Howard St., San Francisco, CA 94103',
          'description' => 'A chance to hear more about Google\'s developer products.',
          'start' => array(
            'dateTime' => '2021-10-26T09:00:00-07:00',
            'timeZone' => 'Asia/Singapore',
        ),
          'end' => array(
            'dateTime' => '2021-10-26T17:00:00-07:00',
            'timeZone' => 'Asia/Singapore',
        ),
          'recurrence' => array(
            'RRULE:FREQ=DAILY;COUNT=2'
        ),
          'attendees' => array(
            array('email' => 'lpage@example.com'),
            array('email' => 'sbrin@example.com'),
        ),
          'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
              array('method' => 'email', 'minutes' => 24 * 60),
              array('method' => 'popup', 'minutes' => 10),
          ),
        ),
          'conferenceData' => [
            'createRequest' => [
                'requestId' => 'randomString'.time()
            ]
        ]
    ));

        $calendarId = 'oncon.capstone@gmail.com';

        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        dd($event);
    }
}
