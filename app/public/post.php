<?php
$db_host = "test_mysql";
$db_root = 'root';
$db_root_pass = '12345';
$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
if (in_array($_FILES['csv']['type'],$csvMimes)) {
    $input = fopen($_FILES['csv']['tmp_name'],"r");
    $results = array();
    try {
        $mysql = new mysqli($db_host, $db_root, $db_root_pass);
        $mysql->select_db('app');
        while (($data = fgetcsv($input, 255, ",")) !== FALSE)
        {
            preg_match('/((?:(?!([A-zА-я0-9\-\.])+)[\s\S])+)/', $data[1],$match);
            if ($match == null){
                array_push($results,array($data[0],$data[1],''));
                $escaped_key = $mysql->real_escape_string($data[0]);
                $escaped_value = $mysql->real_escape_string($data[1]);
                $query_result = $mysql->query("select * from `Handbook` where `key`='$data[0]'");
                if (!$query_result->num_rows) {
                    $query = "insert `Handbook` values('$escaped_key', '$escaped_value')";
                    $mysql->query($query);
                }
                else {
                    $query = "update `Handbook` set `value`='$escaped_value' where `key`='$escaped_key'";
                    $mysql->query($query);
                }
            }
            else
            {
                array_push($results,array($data[0],$data[1],"Недопустимый символ $match[0] в поле Название"));
            }
        }
        fclose($input);

        $output = fopen('file.csv','w');
        $BOM = "\xEF\xBB\xBF";
        fwrite($output,$BOM);
        foreach ($results as $fields) {
            fwrite($output, "$fields[0],$fields[1],$fields[2]\n");
        }
        fclose($output);
    }
    catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

}
else {
    echo 'Bad filetype';
}