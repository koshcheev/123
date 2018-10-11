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
        && isset($_COOKIE['user_name'])
    ) {
        //авторизованы
        Crud::doCrud();


    } else {

        //не авторизованы
        if (!is_null(OdnoklassnikiSDK::getCode())) {
//            print_r(OdnoklassnikiSDK::changeCodeToToken(OdnoklassnikiSDK::getCode()));
//            echo "<pre>";/
//                print_r ($result);
//            echo "</pre>";

            if (OdnoklassnikiSDK::changeCodeToToken(OdnoklassnikiSDK::getCode())) {
                // сделать что-то, если аторизация удалась

                // получили пользователя
                $current_user = OdnoklassnikiSDK::makeRequest("users.getCurrentUser", array("fields" => "name,pic_5"));
                OdnoklassnikiSDK::$user_name = $current_user['name'];

//                OdnoklassnikiSDK::showError(isset($_GET['setcookie']));
                //запишем куки с токенами и обновим страницу
                setcookie("access_token", OdnoklassnikiSDK::$access_token, time() + 3600 * 5);// 5 часов
                setcookie("refresh_token", OdnoklassnikiSDK::$refresh_token, time() + 3600 * 5);// 5 часов
                setcookie("user_name", OdnoklassnikiSDK::$user_name, time() + 3600 * 5);// 5 часов

                Crud::doCrud();
//                header("Location: localhost:85/odnoklassniki.loc/index.php?die=1");

            } else {
                OdnoklassnikiSDK::showError("Не удалось получить токен");
            }
        } else {
            header("Location: https://connect.ok.ru/oauth/authorize?client_id=" . OdnoklassnikiSDK::$app_id
                . "&scope=VALUABLE_ACCESS;LONG_ACCESS_TOKEN&response_type=code&redirect_uri=" . OdnoklassnikiSDK::$redirect_url);

        }

    }
}
class Crud
{

    public static function doCrud()
    {
        //запишем токен из кук в переменные для запросов
        OdnoklassnikiSDK::$access_token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : OdnoklassnikiSDK::$access_token;
        OdnoklassnikiSDK::$refresh_token = isset($_COOKIE['refresh_token']) ? $_COOKIE['refresh_token'] : OdnoklassnikiSDK::$refresh_token;
        OdnoklassnikiSDK::$user_name = isset($_COOKIE['user_name']) ? $_COOKIE['user_name'] : OdnoklassnikiSDK::$user_name;


        $_GET['action'] = isset($_GET['action']) ? $_GET['action'] : 'list';//действие по умолчанию, если не пришло другое

        switch ($_GET['action']) {

            case 'logout':
                //удаляем куки - разавторизовываемся
                setcookie("access_token", '', -1);
                setcookie("refresh_token", '', -1);
                setcookie("user_name", '', -1);

                $message = "Вы разавторизовались";
                $content = 'message.php';//подключили view c сообщением
                break;

            case 'add':
                $content = 'add.php';//подключили view c добавлением
                break;

            case 'create':
                $result = OdnoklassnikiSDK::makeRequest("photos.createAlbum",
                    array(
                        'title' => $_GET['title'],
                        'type' => 'PUBLIC'
                    )
                );

//                echo "<pre>";
//                print_r ($result);
//                echo "</pre>";
                $message = "Альбом " . $_GET['title'] . " создан";
                $content = 'message.php';//подключили view c сообщением
                break;

            case 'save':
                $result = OdnoklassnikiSDK::makeRequest("photos.editPhoto",
                    array(
                        'photo_id' => $_GET['id'],
                        'description' => $_GET['desc'],
                    )
                );
                $message = "Описание фотографии обновлено";
                $content = 'message.php';//подключили view c сообщением
                break;

            case 'edit':
                $content = 'edit.php';//подключили view с редактированием
                break;


            case 'delete':
                $result = OdnoklassnikiSDK::makeRequest("photos.deletePhoto",
                    array(
                        'photo_id' => $_GET['id']
                    )
                );

                $message = "Фотография удалена";
                $content = 'message.php';//подключили view c сообщением
                break;


            case 'list':
                $result = OdnoklassnikiSDK::makeRequest("photos.getPhotos");
                $content = 'list.php';//подключили view со списком

                break;
        }

        include 'views/template.php';
    }
}
?>
