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
echo "Test Master Report\n";
$item = "Keyword";
$master_full_req = array(
    "item" => $item
);


//-------------------------------------------------------------------
echo "  #1. full master\n";
$response = $api->POST("/master-reports", $master_full_req);
debug($response, $DEBUG);
$id = $response["id"];
$status = $response["status"];
echo "registed : id = $id, status = " . $status . "\n";
while ($status == 'REGIST' || $status == 'RUNNING') {
    echo "waiting a report..\n";
    sleep(5);
    $response = $api->GET("/master-reports/" . $id);
    $status = $response["status"];
    echo "check : id = $id, status = " . $status . "\n";
}
if ($status == 'BUILT') {
    echo "downloadUrl => " . $response["downloadUrl"] . "\n";
    $api->DOWNLOAD($response["downloadUrl"], 'data/'.$item . "-" . $id . ".tsv");//파일생성
} else if ($status == 'ERROR') {
    echo "failed to build master report\n";
} else if ($status == 'NONE') {
    echo "master has no data\n";
}



        //   #1. full master
            // request : {"item":"Keyword"}
            // sign = 1543211826485.POST./master-reports
            // Http Status : 201
            // Transaction-ID : B79QBRR0H9JGD
            // size : 10
            // registed : id = 2BF5BFC56EC81EA2890DC0E8E083BD75, status = REGIST
            // waiting a report..
            // sign = 1543211831527.GET./master-reports/2BF5BFC56EC81EA2890DC0E8E083BD75
            // Http Status : 200
            // Transaction-ID : B79QBT2DHDI0N
            // check : id = 2BF5BFC56EC81EA2890DC0E8E083BD75, status = BUILT
            // downloadUrl => https://api.naver.com/report-download?authtoken=BsG9NCpCxGmCavqIijx3u65Gpm4jQJcu3WYmlIjJtiA0N0wgeIEXOtI1yIcYrNxdTx88n%2Bddayuz7dRH9DvTNj%2FP64iG1E3j9Nsv3rVyBd8%3D
            // sign = 1543211831589.GET./report-download
            // Http Status : 200

        //Keyword-FF761DF6910EDF91E15C7A8C5F4B3B15.tsv 파일중 일부..
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515692	아이폰X케이스	600			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515693	아이폰X케이스추천	300			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515694	아이폰X스키니케이스	120			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515695	아이폰X가벼운케이스	70			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515696	아이폰X범퍼케이스	220			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515697	아이폰X충격흡수케이스	70			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515698	아이폰텐케이스	290			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515699	아이폰텐케이스추천	100			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005321382	nkw-a001-01-000000993515700	아이폰텐스키니케이스	70			0	20	0	2017-12-18T04:53:04Z	
        // 994423	grp-a001-01-000000005350844	nkw-a001-01-000000993594480	갤럭시노트8케이스	490			0	20	0	2017-12-18T05:17:34Z	
        // 994423	grp-a001-01-000000005350844	nkw-a001-01-000000993594481	노트8케이스	310			0	20	0	2017-12-18T05:17:34Z	
        // 994423	grp-a001-01-000000005350844	nkw-a001-01-000000993594482	노트8강화유리	980			0	20	0	2017-12-18T05:17:34Z	
        // 994423	grp-a001-01-000000005350844	nkw-a001-01-000000993594483	갤럭시노트8강화유리	300			0	20	0	2017-12-18T05:17:34Z	
        // 994423	grp-a001-01-000000005350844	nkw-a001-01-000000993594484	갤럭시노트8필름	300			0	20	0	2017-12-18T05:17:34Z	
        // 994423	grp-a001-01-000000005350844	nkw-a001-01-000000993594485	노트8필름	570			0	20	0	2017-12-18T05:17:34Z	
        // 994423	grp-a001-01-000000005351038	nkw-a001-01-000000993607291	갤럭시S8케이스	560			0	20	0	2017-12-18T05:26:02Z	
        // ...




//-------------------------------------------------------------------
// echo "  #2. delta master\n";
// $fromTime = "2016-04-01T00:00:00Z";
// $master_delta_req = array(
//     "item" => $item,
//     "fromTime" => $fromTime
// );
// $response = $api->POST("/master-reports", $master_delta_req);
// debug($response, $DEBUG);
// $id = $response["id"];
// $status = $response["status"];
// echo "registed : id = $id, status = " . $status . "\n";
// while ($status == 'REGIST' || $status == 'RUNNING') {
//     echo "waiting a report..\n";
//     sleep(5);
//     $response = $api->GET("/master-reports/" . $id);
//     $status = $response["status"];
//     echo "check : id = $id, status = " . $status . "\n";
// }
// if ($status == 'BUILT') {
//     echo "downloadUrl => " . $response["downloadUrl"] . "\n";
//     $api->DOWNLOAD($response["downloadUrl"], 'data/'."delta-" . $item . "-" . $id . ".tsv");//파일생성
// } else if ($status == 'ERROR') {
//     echo "failed to build master report\n";
// } else if ($status == 'NONE') {
//     echo "master has no data\n";
// }


        //   #2. delta master
            // request : {"item":"Keyword","fromTime":"2016-04-01T00:00:00Z"}
            // sign = 1543211831637.POST./master-reports
            // Http Status : 400
            // Transaction-ID : B79QBT379HGDQ
            // size : 6
            // <br />
            // <b>Notice</b>:  Undefined index: id in <b>D:\tools\xampp5.6\htdocs\naver\searchad-apidoc-master\php-sample\master_report_sample.php</b> on line <b>58</b><br />
            // registed : id = , status = 400





echo "\nTest End\n";







?>