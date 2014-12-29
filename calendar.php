<?php
    date_default_timezone_set('Asia/Manila');
    // リクエスト
    $y = $_REQUEST['y'];
    $m = $_REQUEST['m'];
    
    // カレンダーデータ用変数初期化
    $data = array();
    // エラーエッセージ用変数初期化
    $message = '';

    // フォームの年月が指定されたら実行
    if ($y || $m) {
        // 入力された年月は正しいか？
        // 数字に変換してから、y年m月1日が存在するかどうかで判断
        $y = (int)$y;
        $m = (int)$m;
        if (checkdate($m, 1, $y)) {
            // 正しい時だけ実行
            // カレンター開始日（指定された年月の最初に日のYYYY-MM-DD形式
            $startYmd = sprintf('%04d-%02d-%02d', $y, $m, 1);
            // カレンダー開始タイムスタンプ
            $startT = strtotime($startYmd);
            // これに24時間ずつ加算して行って、1ヶ月分（月が同じ範囲）の日付一覧を作る
            for ($t = $startT; date('m', $t) == date('m', $startT); $t += 60 * 60 * 24) {
                $data[] = $t;
             }
        } else {
            // 年月が正しくない時エラーメッセージ
            $message = '年月を正しく入力してください。';
        }
    } else {
        // 年月の指定が全くない時
        $message = '年月日を選択して、「カレンターを表示する」ボタンを押してください。';
    }

    // 曜日の配列（表示用）
    $weeks = array('日', '月','火', '水', '木', '金' ,'土');
?>
<html>
<head>
    <title>phpでカレンダー</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
    <form action="calendar.php" method="get">
        <p>
            <select name="y">
                <option value=""> - - </option>
                <option value="2012">2012</option>
                <option value="2011">2011</option>
                <option value="2010">2010</option>
                <option value="2009">2009</option>
                <option value="2008">2008</option>
                <option value="2007">2007</option>
                <option value="2006">2006</option>
                <option value="2005">2005</option>
                <option value="2004">2004</option>
                <option value="2003">2003</option>
                <option value="2002">2002</option>
                <option value="2001">2001</option>
                <option value="2000">2000</option>
            </select>
             年
            <select name="m">
                <option value=""> - - </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            月
            <input type="submit" value="カレンダーを表示する">
        </p>
    </form>

<?php 

    // カレンダーのデータがあったら
    if (is_array($data) && count($data)) {
        // カレンダーを表示
        echo '<h1>' . $y . '年' . $m . '月のカレンダーです' . '<h1>';
        echo '<ul>';
        foreach($data as $k => $v) {
            // date()関数 -> 第2引数のタイムスタンプの日付表示、曜日計算
            echo '<li>' .date('Y年m月d日', $v) . '(' . $weeks[date('w', $v)] .')' . '</li>';
        }
        echo '</ul>';
    }
?>

<?php 
    // エラーメッセージがあったら
    if ($message) {
        echo '<p style="color: #ff0000;">' . $message . '</p>';
    }
?>
</body>
</html>

