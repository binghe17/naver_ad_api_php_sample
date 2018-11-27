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
// echo "Test Estimate\n";
// echo "  #1. average-position-bid\n"; //평균위치bid
// $req_avg_pos = array(
//     "device" => "PC",
//     "items" => array(
//         array("key" => "제주여행", "position" => 1),
//         array("key" => "게스트하우스", "position" => 2),
//         array("key" => "자전거여행", "position" => 3),
//     )
// );
// $response = $api->POST('/estimate/average-position-bid/keyword', $req_avg_pos);  //POST /estimate/exposure-minimum-bid/{type}    ; type => id, keyword
// debug($response, $DEBUG);
// print_r($response);

        // Array
        // (
        //     [device] => PC
        //     [estimate] => Array
        //         (
        //             [0] => Array
        //                 (
        //                     [bid] => 6830                //new add
        //                     [keyword] => 제주여행
        //                     [position] => 1
        //                 )

        //             [1] => Array
        //                 (
        //                     [bid] => 1500
        //                     [keyword] => 게스트하우스
        //                     [position] => 2
        //                 )

        //             [2] => Array
        //                 (
        //                     [bid] => 320
        //                     [keyword] => 자전거여행
        //                     [position] => 3
        //                 )

        //         )

        // )




// echo "  #2. exposure-minimum-bid\n"; //최소노출bid
// $req_bid = array(
//     "device" => "PC", //PC, MOBILE
//     "period" => "MONTH",
//     "items" => array(
//         "제주여행",
//         "게스트하우스",
//         "자전거여행",
//     )
// );
// $response = $api->POST('/estimate/exposure-minimum-bid/keyword', $req_bid);
// debug($response, $DEBUG);
// print_r($response);

        // Array
        // (
        //     [device] => PC                       //PC , MOBILE
        //     [period] => MONTH                    //MONTH 월간,  DAY 일간
        //     [estimate] => Array
        //         (
        //             [0] => Array
        //                 (
        //                     [bid] => 3660                //new add
        //                     [keyword] => 제주여행
        //                 )

        //             [1] => Array
        //                 (
        //                     [bid] => 360
        //                     [keyword] => 게스트하우스
        //                 )

        //             [2] => Array
        //                 (
        //                     [bid] => 100
        //                     [keyword] => 자전거여행
        //                 )

        //         )

        // )



echo "  #3. median-bid\n"; //중앙bid
$req_bid = array(
    "device" => "PC",
    "period" => "MONTH",
    "items" => array(
        "제주여행",
        "게스트하우스",
        "자전거여행",
    )
);
$response = $api->POST('/estimate/median-bid/keyword', $req_bid);
debug($response, $DEBUG);
print_r($response);

        // Array
        // (
        //     [device] => PC
        //     [period] => MONTH
        //     [estimate] => Array
        //         (
        //             [0] => Array
        //                 (
        //                     [bid] => 3790                //new add
        //                     [keyword] => 제주여행
        //                 )

        //             [1] => Array
        //                 (
        //                     [bid] => 700
        //                     [keyword] => 게스트하우스
        //                 )

        //             [2] => Array
        //                 (
        //                     [bid] => 200
        //                     [keyword] => 자전거여행
        //                 )

        //         )

        // )





echo "  #4. performance\n";  //https://naver.github.io/searchad-apidoc/#/operations/POST/~2Festimate~2Fperformance~2F%7Btype%7D
$req_performance = array(
    "device" => "BOTH", //PC, MOBILE, BOTH
    "keywordplus" => true,
    "key" => "모드애드온",
    "bids" => array(
        // 100,
        // 500,
        // 1000,
        // 1500,
        216222, //.mail_txt[data-filter-value]
        314374, //li[data-mall-seq]
    )
);
$response = $api->POST('/estimate/performance/keyword', $req_performance);
debug($response, $DEBUG);
print_r($response);

        // Array
        // (
        //     [device] => PC
        //     [keywordplus] => 1
        //     [keyword] => 중고차
        //     [estimate] => Array
        //         (
        //             [0] => Array
        //                 (
        //                     [bid] => 100
        //                     [clicks] => 0                //new add
        //                     [impressions] => 0           //new add
        //                     [cost] => 0                  //new add
        //                 )

        //             [1] => Array
        //                 (
        //                     [bid] => 500
        //                     [clicks] => 0
        //                     [impressions] => 0
        //                     [cost] => 0
        //                 )

        //             [2] => Array
        //                 (
        //                     [bid] => 1000
        //                     [clicks] => 0
        //                     [impressions] => 12779
        //                     [cost] => 0
        //                 )

        //             [3] => Array
        //                 (
        //                     [bid] => 1500
        //                     [clicks] => 549
        //                     [impressions] => 25993
        //                     [cost] => 750697
        //                 )

        //             [4] => Array
        //                 (
        //                     [bid] => 2000
        //                     [clicks] => 5628
        //                     [impressions] => 39206
        //                     [cost] => 9975232
        //                 )

        //             [5] => Array
        //                 (
        //                     [bid] => 3000
        //                     [clicks] => 14795
        //                     [impressions] => 65634
        //                     [cost] => 38208219
        //                 )

        //             [6] => Array
        //                 (
        //                     [bid] => 5000
        //                     [clicks] => 14795
        //                     [impressions] => 84820
        //                     [cost] => 57863245
        //                 )

        //         )

        // )





// echo "  #5. performance-bulk\n";
// $req_performance_bulk = array (
// 		"items" => array (
// 				0 => array (
// 						"device" => "PC",
// 						"keywordplus" => true,
// 						"keyword" => "제주여행",
// 						"bid" => 70 
// 				),
// 				1 => array (
// 						"device" => "PC",
// 						"keywordplus" => true,
// 						"keyword" => "제주도",
// 						"bid" => 80 
// 				),
// 				2 => array (
// 						"device" => "PC",
// 						"keywordplus" => true,
// 						"keyword" => "제주맛집",
// 						"bid" => 90 
// 				) 
// 		) 
// );
// $response = $api->POST('/estimate/performance-bulk', $req_performance_bulk);
// debug($response, $DEBUG);
// print_r($response);

        // Array
        // (
        //     [items] => Array
        //         (
        //             [0] => Array
        //                 (
        //                     [keyword] => 제주여행
        //                     [bid] => 70
        //                     [device] => PC
        //                     [keywordplus] => 1
        //                     [clicks] => 0                        //new add
        //                     [impressions] => 0                   //new add
        //                     [cost] => 0                          //new add
        //                 )

        //             [1] => Array
        //                 (
        //                     [keyword] => 제주도
        //                     [bid] => 80
        //                     [device] => PC
        //                     [keywordplus] => 1
        //                     [clicks] => 0
        //                     [impressions] => 28116
        //                     [cost] => 0
        //                 )

        //             [2] => Array
        //                 (
        //                     [keyword] => 제주맛집
        //                     [bid] => 90
        //                     [device] => PC
        //                     [keywordplus] => 1
        //                     [clicks] => 0
        //                     [impressions] => 3013
        //                     [cost] => 0
        //                 )

        //         )

        // )




echo "\nTest End\n";



//--------------------조회수 테스트------------------------------
//https://naver.github.io/searchad-apidoc/#/operations/POST/~2Festimate~2Fperformance~2F%7Btype%7D
// $req_performance = array(
//     "device" => "MOBILE", //PC, MOBILE, BOTH
//     "keywordplus" => true,
//     "key" => "아이폰X케이스", //공백제거
//     "bids" => array(    // 카테고리: cat_id
//         50004594,              // 기타케이스
//         // 50001377,           // 휴대폰케이스
//         // 50000205,           // (디지털/가전 > 휴대폰액세서리 > 휴대폰케이스 > 기타케이스) 중 하나
//     )
// );
// $response = $api->POST('/estimate/performance/keyword', $req_performance);
// print_r($response);

        //결과
        // request : {"device":"MOBILE","keywordplus":true,"key":"\uc544\uc774\ud3f0X\ucf00\uc774\uc2a4","bids":[50004594]}
        // sign = 1543294056409.POST./estimate/performance/keyword
        // Http Status : 200
        // Transaction-ID : B7ADV7G419JJU
        // Array
        // (
        //     [device] => MOBILE
        //     [keywordplus] => 1
        //     [keyword] => 아이폰X케이스
        //     [estimate] => Array
        //         (
        //             [0] => Array
        //                 (
        //                     [bid] => 50004594
        //                     [clicks] => 2549
        //                     [impressions] => 39857
        //                     [cost] => 2441942
        //                 )
        //         )
        // )



//------------------기타 테스트---------------
// $response = $api->GET('/ncc/keywords/nkw-a001-01-000000993515692');
// print_r($response);

        //결과
        // sign = 1543294056359.GET./ncc/keywords/nkw-a001-01-000000993515692
        // Http Status : 200
        // Transaction-ID : B7ADV7FQ1DHDO
        // Array
        // (
        //     [nccKeywordId] => nkw-a001-01-000000993515692
        //     [keyword] => 아이폰X케이스
        //     [customerId] => 994423
        //     [nccAdgroupId] => grp-a001-01-000000005321382
        //     [nccCampaignId] => cmp-a001-01-000000000900621
        //     [userLock] => 
        //     [inspectStatus] => APPROVED
        //     [bidAmt] => 600
        //     [useGroupBidAmt] => 
        //     [delFlag] => 
        //     [regTm] => 2017-12-18T04:53:04.000Z
        //     [editTm] => 2017-12-18T05:47:06.000Z
        //     [status] => ELIGIBLE
        //     [statusReason] => ELIGIBLE
        //     [nccQi] => Array
        //         (
        //             [qiGrade] => 6
        //         )

        // )





?>