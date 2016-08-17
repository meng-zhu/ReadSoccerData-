<?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "http://www.228365365.com/sports.php");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_exec($ch);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "http://www.228365365.com/app/member/FT_browse/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&page_no=0&league_id=&hot_game=undefined");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //偽裝成正常途徑進入
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    $data = curl_exec($ch);
    curl_close($ch);

    //清除不要的資料
    $data = preg_replace("/.*?parent.GameFT\[0\]/si", '<?php $array[0]', $data);
    $data = preg_replace("/parent.GameFT/",'$array', $data);
    $data = preg_replace("/function.*?<\/html>/si", '', $data);
    $data = preg_replace("/new Array/", 'array', $data);
    $data = preg_replace("/<br>/", ' ', $data);
    $data = preg_replace("/<font.*?<\/font>/", '', $data);

    //將抓取的資料存到檔案中
    $fp = fopen("data.php", "w");
    fwrite($fp,$data);
    fclose($fp);