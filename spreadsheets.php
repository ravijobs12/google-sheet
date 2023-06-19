<?php
try {
    $sheet_name = 'Sheet1';
    if (isset($_REQUEST['row_id'])) {
        require __DIR__ . '/spreadsheets.class.php';
        $col_name = 'A'.$_REQUEST['row_id'];
        $range = $sheet_name.'!'.$col_name;
        $seets = new Spreadsheets();
        if ($seets->google_client_configuration()) {
            $spreadsheets_rows = $seets->fetch_spreadsheet_row($range);
            $newRow = [
                    $_REQUEST['col_1'],
                    $_REQUEST['col_2']
                ];
            if (isset($spreadsheets_rows) && is_array($spreadsheets_rows)) {
                $seets->update_spreadsheet_row($newRow, $range);
                echo "Successfully updated";
            } else {                
                $seets->create_spreadsheet_row($newRow, $range);
                echo "Successfully Inserted";
            }
        }
    }

} catch (error $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}

?>