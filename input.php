<?php 

if(count($_POST) > 0 ){
    echo '검색어:'. $_POST['query'];
    echo '상품고유ID(nv_mid):'. $_POST['nv_mid'];
    echo '카테고리ID(cat_id):'. $_POST['cat_id'];
}
    

?>
<form action="input.php" method="post">
    <input type="text" name="query" value="아이패드6세대케이스" placeholder="검색어" />
    <input type="text" name="nv_mid" value="14016207273" placeholder="상품고유ID(nv_mid)" />
    <input type="text" name="cat_id" value="50001588" placeholder="카테고리ID(cat_id)" />
    <button>즉시추출</button>
</form>