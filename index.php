<?php
/*
    Этот код необходимо добавить один раз перед первым использованием SDK, указав в директиве require путь к файлу с SDK.
    Он подключает SDK и проверяет, установлена ли необходимая для работы SDK библиотека curl.
*/

header('Content-Type: text/html; charset=utf-8');

require("./odnoklassniki_sdk.php");
if (!OdnoklassnikiSDK::checkCurlSupport()){
    //библиотека не подключена
    print "У вас не установлен модуль curl, который требуется для работы с SDK одноклассников.  Инструкция по установке есть, например, <a href=\"http://www.php.net/manual/en/curl.installation.php\">здесь</a>.";
    return;
}else {
    //библиотека подключена. можно работать
    if (isset($_COOKIE['access_token'])
        && isset($_COOKIE['refresh_token'])
    ) {
        //авторизованы

        //запишем токен из кук (чтоб не авторизовываться 300 раз)
        OdnoklassnikiSDK::$access_token = $_COOKIE['access_token'];
        OdnoklassnikiSDK::$refresh_token = $_COOKIE['refresh_token'];



        // получили пользователя
        $current_user = OdnoklassnikiSDK::makeRequest("users.getCurrentUser", array("fields" => "name,pic_5"));


        $_GET['action'] = isset($_GET['action']) ? $_GET['action'] : 'list';//действие по умолчанию, если не пришло другое
        switch ($_GET['action']) {

            case 'edit':
                $result = OdnoklassnikiSDK::makeRequest("photos.deletePhoto",array('id'=>$_GET['id']));

                echo "<pre>";
                print_r ($result);
                echo "</pre>";
                $content = 'edit.php';//подключили view с редактированием
                    break;


            case 'delete':
                $result = OdnoklassnikiSDK::makeRequest("photos.deletePhoto",array('id'=>$_GET['id']));

                echo "<pre>";
                print_r ($result);
                echo "</pre>";
                $content = 'delete.php';//подключили view с удалением
                    break;


            case 'list':
                $result = OdnoklassnikiSDK::makeRequest("photos.getPhotos");
                echo "<pre>";
//                print_r ($result);
                echo "</pre>";
                $content = 'list.php';//подключили view со списком

                    break;


        }
        include 'views/template.php';
    } else {
    //не авторизованы
        if (!is_null(OdnoklassnikiSDK::getCode())) {
            /*
            throw new Exception(
                print_r(
                    !empty($a[self::PARAMETER_NAME_ACCESS_TOKEN]) && !empty($a[self::PARAMETER_NAME_REFRESH_TOKEN])
                )
            );

                $uid = $current_user['uid'];//id пользователя в одноклассниках


            echo "<pre>";
                print_r ($result);
            echo "</pre>";



            */
            if (OdnoklassnikiSDK::changeCodeToToken(OdnoklassnikiSDK::getCode())) {
                // сделать что-то, если аторизация удалась

                //запишем куки с токенами и обновим страницу
                setcookie("access_token", OdnoklassnikiSDK::$access_token, time()+3600*5);// 5 часов
                setcookie("refresh_token", OdnoklassnikiSDK::$refresh_token, time()+3600*5);// 5 часов

                header("Location: localhost/mailru/index.php?");
            } else {
                OdnoklassnikiSDK::showError("Не удалось получить токен");
            }
        } else {
            header("Location: https://connect.ok.ru/oauth/authorize?client_id=" . OdnoklassnikiSDK::$app_id
                . "&scope=VALUABLE_ACCESS;LONG_ACCESS_TOKEN&response_type=code&redirect_uri=" . OdnoklassnikiSDK::$redirect_url);

        }

    }
}
?>
