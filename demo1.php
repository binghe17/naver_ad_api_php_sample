<?php


echo '<pre>';

//-------------------------------------------------------------------

//네이버광고API 사용.(최초실행)
function naverSearchInit(){
    ini_set("default_socket_timeout", 30);
    require_once 'restapi.php';                 //네이버 광고 API를 불러올때 쓰이는 REST클래스
    $config = parse_ini_file("sample.ini");     //비밀키 외부파일에서 가져오기
    $GLOBALS['naver_ad_api'] = new RestApi($config['BASE_URL'], $config['API_KEY'], $config['SECRET_KEY'], $config['CUSTOMER_ID']);
}
//네이버광고 검색어와 카테고리ID로 검색어 조회수와 클릭수를 가져오기.
function naverSearchCateId($search, $cateId, $device=2){
    if(!isset($GLOBALS['naver_ad_api'])) naverSearchInit(); 
    $deviceArr = array('PC','MOBILE','BOTH'); //0,1,2
    $search = str_replace(' ', '', $search);
    $req_performance = array(
        "device" => $deviceArr[$device],    //PC, MOBILE, BOTH
        "keywordplus" => true,
        "key" => $search,                   //공백제거
        "bids" => array( $cateId )          // 카테고리: cat_id
    );
    $result = $GLOBALS['naver_ad_api']->POST('/estimate/performance/keyword', $req_performance);
    $result['estimate'][0]['search'] = $search;
    $result['estimate'][0]['device'] = $deviceArr[$device];
    return $result['estimate'][0];
}

print_r(naverSearchCateId('아이패드6세대케이스', '50001588'));//카테고리ID자동 입력하게 만들어야 함.
        //결과:
        // Array
        // (
        //     [bid] => 50001588                 //카테고리ID
        //     [clicks] => 207                   //클릭수
        //     [impressions] => 6272             //검색수
        //     [cost] => 603198                  //비용?
        //     [search] => 아이패드6세대케이스     //검색어 (공백제거한 카테고리명) 
        //     [device] => PC                    //디바이스별 통계 범위설정
        // )

print_r(naverSearchCateId('아이폰X케이스', '50004591'));





//--------------------------

// https://cc.naver.com/cc?a=lst*C.image&r=3&i=12562325794&bw=1648&px=254&py=1742&sx=254&sy=742&m=0&ssc=svc.shopping.v3&q=%EC%95%84%EC%9D%B4%ED%8F%B0%20X%EC%BC%80%EC%9D%B4%EC%8A%A4&s=qgc+SCJxkpav633WtE2/0w&p=T/zdNlpl6G8ssh1eP1ossssssZd-218111&u=http://cr2.shopping.naver.com/adcr.nhn?x=I%2FH3l7SzpXlyq4NpiZOySf%2F%2F%2Fw%3D%3DsQuEo0zrNChrxr5PWCRW0NmluB61n%2FzgavpOrfvmHOY5kXOOUMRuP3VdzblunqC6EYZwC2s8YFczhxaINzgKRVkjH28ETI%2BLMcMvarxAJmoM427ngu9Ku5Ti5fmyIKbcN80TP1ntM1mOoVDSV22scdOO23wvY5ABGBtZ0tm6c9JVNefxUfx94Q%2BOnywVtGEbJy5sNsOqjZvBUYjuxshfvyFUAlOr%2FQmF7eOny7%2BtZCWb4FjQLKtgpdaxOC6%2FeJ5KoS4A2Wg%2FUMC%2B6rw6N25foWoyfa430Tylic96Wc630Ev7%2BsgRacfF%2B6sJiBdvPqZYLNH5gNaSyk1Lf3d55J3s6tXPZ%2BrFdBTboQAqeyQo1osNkcq3IAhC%2BeW7CKZfGihLE7mO6swUVwrnJECPHVpv718GvU9I7hoobpIy1YSVvFPRhc81F0E%2BxfLAzfaaLhxCXzPCd6fZFMMxKFnl7TjFzSqWilumJ5qA9GiKkn8RnX0NqCIrmjU1KFAOSx0tFAL1rbDHUpRklVQfF953LrzAxSiwfTdAgFG8RacBcEpPeJmEXgUXqvqkqzMgpo0PJ1yrpU3WBaVU2sxA1%2Bo6hyCos4YgGElAgvjuS9MhoAuS0K15C4LiQUqFCoUo5u6lUAxhuh%2BAI%2F5R4RNB7u9vY5uvXDcrExa3HetGcX41i7Gk%2BowaWEVg1Ah8mAsDhdC3%2Fr6HmzJTyxFCq5jQR98rsnMaUy9wo26bKFm8M7C8e6BSoWyUu2oWDu4QkuNeNwb8BOhkTfG1Sor8YMa21vquXuGXpkSk6hhhMuRwf0Z0%2BwKRIDuGa39Zm1jJNrsb0Sn0QnqjGUeGhdap6ao8unffYwlsCOA%3D%3D



//상품 검색 링크
// https://search.shopping.naver.com/search/all.nhn?query=%EC%95%84%EC%9D%B4%ED%8F%B0X%EC%BC%80%EC%9D%B4%EC%8A%A4&cat_id=&frm=NVSHATC //검색
// https://search.shopping.naver.com/search/all.nhn?query=14016207273    //직접 상품고유ID로 검색도 됨.
// https://search.shopping.naver.com/search/all.nhn?origQuery=%EC%95%84%EC%9D%B4%ED%8F%B0X%EC%BC%80%EC%9D%B4%EC%8A%A4&pagingIndex=2&pagingSize=80&viewType=list&sort=rel&frm=NVSHPAG&query=%EC%95%84%EC%9D%B4%ED%8F%B0X%EC%BC%80%EC%9D%B4%EC%8A%A4
    
    //분석:
    // query='아이폰X케이스'
    // origQuery='아이폰X케이스'
    // pagingIndex=2
    // pagingSize=80    //20, 40, 60, 80
    // viewType=list  //thumb
    // sort=rel
    // frm=NVSHPAG


//특정상품 클릭시 전환하는 페이지 링크
// https://search.shopping.naver.com/detail/detail.nhn?nv_mid=14541402633
// https://search.shopping.naver.com/detail/detail.nhn?nv_mid=15472472279
// https://search.shopping.naver.com/detail/detail.nhn?nv_mid=12916256024&cat_id=50004594&frm=NVSHATC&query=%EC%95%84%EC%9D%B4%ED%8F%B0+X+%EC%BC%80%EC%9D%B4%EC%8A%A4&NaPm=ct%3Djozdw31s%7Cci%3D5f4d689e453aed600e0179518f47a22e30c9af3f%7Ctr%3Dslsl%7Csn%3D95694%7Chk%3D33ad4999c619e8d9bf9d6e128af0201dd9792484




// 필요한 변수: 1.검색어(페이지), 2.몇페이지의 데이터 가져오기;  3.상품ID, 4.감시상품의 순위계산; )
// 저장할 값: 저장날짜시간. 검색어, 상품ID, 한페이지에서 출력되는 리스트의 모든 상품ID. 카테고리분류ID,  (상품명, 카테고리ID, 상품가격, 총상품수) 
// 어느상품을 어느시간에 몇페이지만큼의 데이터를 가져왔다. (검색어 범위로 긁어온다)


//검색어와, 상품고유ID만 입력하게 해서 네이버 스마트스토어에서의 순위 출력 (정적화면 크롤링 curl)



//스케줄러로 자동으로 특정 시간대에 php파일을 실행하게함.



