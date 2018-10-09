<?php
/*
    Этот код необходимо добавить один раз перед первым использованием SDK, указав в директиве require путь к файлу с SDK.
    Он подключает SDK и проверяет, установлена ли необходимая для работы SDK библиотека curl.
*/

header('Content-Type: text/html; charset=utf-8');


require("./odnoklassniki_sdk.php");
if (!OdnoklassnikiSDK::checkCurlSupport()){
    print "У вас не установлен модуль curl, который требуется для работы с SDK одноклассников.  Инструкция по установке есть, например, <a href=\"http://www.php.net/manual/en/curl.installation.php\">здесь</a>.";
    return;
}else {


    if (!is_null(OdnoklassnikiSDK::getCode())) {

        /*
        throw new Exception(
            print_r(
                !empty($a[self::PARAMETER_NAME_ACCESS_TOKEN]) && !empty($a[self::PARAMETER_NAME_REFRESH_TOKEN])
            )
        );

        */



        if (OdnoklassnikiSDK::changeCodeToToken(OdnoklassnikiSDK::getCode())) {
            // сделать что-то, если аторизация удалась
//            print_r('SUCCESS!');//сукес

            // получили пользователя
            $current_user = OdnoklassnikiSDK::makeRequest("users.getCurrentUser", array("fields" => "name,pic_5"));

            $uid = $current_user['uid'];//id пользователя в одноклассниках

                $albomId = 875741333355; // id альбома

                // собираем параметры в массив
                $params = array(
                    "application_key=". OdnoklassnikiSDK::$app_public_key, // ключ приложения
                    "format=". "json", // тип передачи данных
//                    "access_token=". OdnoklassnikiSDK::$access_token, // ключ приложения
                    "uid=". $uid, // id юзера
                    "aid=". $albomId // id альбома. если не передавать параметр aid, то получим фотки из "личного альбома"
                );
                sort($params); // сортировка массива
                $sig = md5(join('', $params).OdnoklassnikiSDK::$app_secret_key); // генерируем сигнатуру
                // ссылка, по которой будет сделан запрос к api
                $req = "http://api.odnoklassniki.ru/api/photos/getPhotos?sig=".$sig."&".join('&',$params);
                $page = file_get_contents($req); // запрос к api одноклассников
print_r($page);

//                $result = json_decode($page,true); // разбираем полученные данные
//
//                // вывод полученных данных
//                echo "<pre>";
//                print_r ($result["photos"]);
//                echo "</pre>";



        }else {
            OdnoklassnikiSDK::showError("Не удалось получить токен" );
        }
    }else{
        header("Location: https://connect.ok.ru/oauth/authorize?client_id=".OdnoklassnikiSDK::$app_id
            ."&scope=VALUABLE_ACCESS;LONG_ACCESS_TOKEN&response_type=code&redirect_uri=".OdnoklassnikiSDK::$redirect_url);

    }


//    print_r(OdnoklassnikiSDK::getCode());

//    file_get_contents('
}
?>
