<?php

class Spreadsheets
{
    var $service;
    var $spreadsheetId;


    /**
     * Google client api configuration.
     * @return boolean
     */
    function google_client_configuration()
    {
        require __DIR__ . '/vendor/autoload.php';
        //Reading data from spreadsheet.

        $client = new \Google_Client();

        $client->setApplicationName('Google Sheets and PHP');

        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        $client->setAccessType('offline');

        $client->setAuthConfig(__DIR__ . '/credentials.json');

        $this->service = new Google_Service_Sheets($client);
        $this->spreadsheetId = '1Ar5F7UAtQxpesGz48_ufV1uJRPLGeYF0lDeB73Zm1aY';
        return 1;
    }                                                                                                
    /**
     * Fetch spreadsheet row.
     * 
     * @param string $range
     * @return array spreadsheet row
     */
    function fetch_spreadsheet_row($range)
    {
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues();
    } 

    /**
     * Create spreadsheet row.
     * 
     * @param array $data
     * @param string $range
     */
    function create_spreadsheet_row($data, $range)
    {
        $rows = [$data]; // you can append several rows at once
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $valueRange, $options);
    }

    /**
     * Update spreadsheet row.
     * 
     * @param array $data
     * @param string $range
     */
    function update_spreadsheet_row($data, $range)
    {
        $rows = [$data];
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $valueRange, $options);
    }
}

?>