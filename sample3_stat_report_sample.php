<?php
ini_set("default_socket_timeout", 30);
require_once 'restapi.php';

$config = parse_ini_file("sample.ini");

echo '<pre>';
// print_r($config);

function debug($obj, $detail = false)
{
    if (is_array($obj)) {
        echo "size : " . count($obj) . "\n";
    }
    if ($detail) {
        print_r($obj);
    }
}

// #. detail log
$DEBUG = false;

$api = new RestApi($config['BASE_URL'], $config['API_KEY'], $config['SECRET_KEY'], $config['CUSTOMER_ID']);



//-------------------------------------------------------------------
echo "Test StatReport\n";
$reportType = "AD_DETAIL";
$statDt = date('Ymd',strtotime("-1 days"));;
$stat_req = array(
    "reportTp" => $reportType,
    "statDt" => $statDt
);

$response = $api->POST("/stat-reports", $stat_req);
debug($response, $DEBUG);
print_r($response);


$reportjobid = $response["reportJobId"];
$status = $response["status"];
echo "registed : reportJobId = $reportjobid, status = " . $status . "\n";
while ($status == 'REGIST' || $status == 'RUNNING' || $status == 'WAITING') {
    echo "waiting a report..\n";
    sleep(5);
    $response = $api->GET("/stat-reports/" . $reportjobid);
    $status = $response["status"];
    echo "check : reportJobId = $reportjobid, status = " . $status . "\n";
}
if ($status == 'BUILT') {
    echo "downloadUrl => " . $response["downloadUrl"] . "\n";
    $api->DOWNLOAD($response["downloadUrl"], 'data/'.$reportType . "-" . $statDt . ".tsv");
} else if ($status == 'ERROR') {
    echo "failed to build stat report\n";
} else if ($status == 'NONE') {
    echo "report has no data\n";
} else if ($status == 'AGGREGATING') {
    echo "stat aggregation not yet finished\n";
}


        // request : {"reportTp":"AD_DETAIL","statDt":"20181125"}
        // sign = 1543211710937.POST./stat-reports
        // Http Status : 200
        // Transaction-ID : B79QAVK8PDHMI
        // size : 8
        // registed : reportJobId = 476244661, status = REGIST
        // waiting a report..


        // sign = 1543211716003.GET./stat-reports/476244661
        // Http Status : 200
        // Transaction-ID : B79QB0RP19JNK
        // check : reportJobId = 476244661, status = BUILT
        // downloadUrl => https://api.naver.com/report-download?authtoken=75JLZ5Ya%2BTPDRBqH3%2B9IVoUO9RogL2aRcT%2BRVKIZWltuKdQlvXR%2FWArrTKkjHgW%2FIgohTd2FgygY845ibAdOUDUX%2Bw%2B3Xltc


        // sign = 1543211716035.GET./report-download
        // Http Status : 200





echo "\nTest End\n";


?>