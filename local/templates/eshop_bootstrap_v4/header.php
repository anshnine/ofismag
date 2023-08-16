<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/" . SITE_TEMPLATE_ID . "/header.php");
CUtil::InitJSCore(array('window'));
CUtil::InitJSCore(array('ajax', 'popup', 'fx'));

\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
use Bitrix\Main\Page\Asset;

if (isset($_GET["theme"]) && in_array($_GET["theme"], array("blue", "green", "yellow", "red"))) {
    COption::SetOptionString("main", "wizard_eshop_bootstrap_theme_id", $_GET["theme"], false, SITE_ID);
}
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "green", SITE_ID);

$curPage = $APPLICATION->GetCurPage(true);

?><!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/wait_press_button.js"); ?>
    <!--    --><? //$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/wait_press_button.js");?>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_DIR ?>favicon.ico"/>
    <? $APPLICATION->ShowHead(); ?>
</head>
<body class="bx-background-image bx-theme-<?= $theme ?>" <? $APPLICATION->ShowProperty("backgroundImage"); ?>>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<? $APPLICATION->IncludeComponent(
    "bitrix:eshop.banner",
    "",
    array()
); ?>


<div class="bx-wrapper" id="bx_eshop_wrap">
    <header class="bx-header">
        <div class="bx-header-section container">
            <!--region bx-header-->
            <div class="row pt-0 pt-md-3 mb-3 align-items-center" style="position: relative;">
                <div class="d-block d-md-none bx-menu-button-mobile" data-role='bx-menu-button-mobile-position'></div>
                <div class="col-12 col-md-auto bx-header-logo">
                    <a class="bx-logo-block d-none d-md-block" href="<?= SITE_DIR ?>">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR . "include/company_logo.php"),
                            false
                        ); ?>
                    </a>
                    <a class="bx-logo-block d-block d-md-none text-center" href="<?= SITE_DIR ?>">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR . "include/company_logo_mobile.php"
                            ),
                            false
                        ); ?>
                    </a>

                </div>

                <div class="col-auto d-none d-md-block bx-header-personal">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:sale.basket.basket.line",
                        "bootstrap_v4",
                        array(
                            "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                            "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                            "SHOW_PERSONAL_LINK" => "N",
                            "SHOW_NUM_PRODUCTS" => "Y",
                            "SHOW_TOTAL_PRICE" => "Y",
                            "SHOW_PRODUCTS" => "N",
                            "POSITION_FIXED" => "N",
                            "SHOW_AUTHOR" => "Y",
                            "PATH_TO_REGISTER" => SITE_DIR . "login/",
                            "PATH_TO_PROFILE" => SITE_DIR . "personal/"
                        ),
                        false,
                        array()
                    ); ?>

                    <div class="col-auto d-none d-md-block" id="compare_list_count">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.compare.list",
                            "compare_top",
                            array(
                                "IBLOCK_TYPE" => "catalog", //Сюда ваш тип инфоблока каталога
                                "IBLOCK_ID" => "2", //Сюда ваш ID инфоблока каталога
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "AJAX_OPTION_HISTORY" => "N",
                                "DETAIL_URL" => "#SECTION_CODE#",
                                "COMPARE_URL" => "/catalog/compare.php",
                                "NAME" => "CATALOG_COMPARE_LIST",
                                "AJAX_OPTION_ADDITIONAL" => ""
                            ),
                            false
                        );
                        ?>
                    </div>
                </div>

                <div class="col bx-header-contact">
                    <div class="d-flex align-items-center justify-content-between justify-content-md-center flex-column flex-sm-row flex-md-column flex-lg-row">
                        <div class="p-lg-3 p-1">
                            <div class="bx-header-phone-block">
                                <i class="bx-header-phone-icon"></i>
                                <span class="bx-header-phone-number">
									<? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_DIR . "include/telephone.php"
                                        ),
                                        false
                                    ); ?>
								</span>
                            </div>
                        </div>
                        <div class="p-lg-3 p-1">
                            <div class="bx-header-worktime">
                                <div class="bx-worktime-title"><?= GetMessage('HEADER_WORK_TIME'); ?></div>
                                <div class="bx-worktime-schedule">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_DIR . "include/schedule.php"
                                        ),
                                        false
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--endregion-->
            <!--region menu-->
            <div class="row mb-4 d-none d-md-block">
                <div class="col">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bootstrap_v4",
                        array(
                            "ROOT_MENU_TYPE" => "left",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "36000000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_THEME" => "site",
                            "CACHE_SELECTED_ITEMS" => "N",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MAX_LEVEL" => "3",
                            "CHILD_MENU_TYPE" => "left",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => "bootstrap_v4"
                        ),
                        false
                    ); ?>
                </div>
            </div>

            <!--endregion-->

            <!--region search.title -->
            <? if ($curPage != SITE_DIR . "index.php"): ?>
                <div class="row mb-4">
                    <div class="col">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:search.title",
                            "bootstrap_v4",
                            array(
                                "NUM_CATEGORIES" => "1",
                                "TOP_COUNT" => "5",
                                "CHECK_DATES" => "N",
                                "SHOW_OTHERS" => "N",
                                "PAGE" => SITE_DIR . "catalog/",
                                "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                                "CATEGORY_0" => array(
                                    0 => "iblock_catalog",
                                ),
                                "CATEGORY_0_iblock_catalog" => array(
                                    0 => "all",
                                ),
                                "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                                "SHOW_INPUT" => "Y",
                                "INPUT_ID" => "title-search-input",
                                "CONTAINER_ID" => "search",
                                "PRICE_CODE" => array(
                                    0 => "BASE",
                                ),
                                "SHOW_PREVIEW" => "Y",
                                "PREVIEW_WIDTH" => "75",
                                "PREVIEW_HEIGHT" => "75",
                                "CONVERT_CURRENCY" => "Y"
                            ),
                            false
                        ); ?>
                    </div>
                </div>
            <? endif ?>
            <!--endregion-->

            <!--region breadcrumb-->
            <? if ($curPage != SITE_DIR . "index.php"): ?>
                <div class="row mb-4">
                    <div class="col" id="navigation">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:breadcrumb",
                            "universal",
                            array(
                                "START_FROM" => "0",
                                "PATH" => "",
                                "SITE_ID" => "-"
                            ),
                            false,
                            array('HIDE_ICONS' => 'Y')
                        ); ?>
                    </div>
                </div>
                <h1 id="pagetitle"><? $APPLICATION->ShowTitle(false); ?></h1>
            <? endif ?>
            <!--endregion-->
        </div>

        <div class="custom_modal" id="custom_modal">
            <div class="modal__main d-flex flex-column" id="modal__main">
                <h3>Форма отправки ошибки на сайте</h3>
                <p>Вы выделили:<br><b id="selected-text"></b></p>
                <textarea id="correct-variant" placeholder="Введите правильный вариант"></textarea>
                <p>Ссылка на страницу, где была обнаружена ошибка:</p>
                <p id="src_url"></p>
                <button id="send-button" class="send-button">Отправить</button>
                <button class="modal__close">&#10006</button>
            </div>
            <div class="success_modal d-none" id="success_modal">
                <p> Сообщение успешно отправлено! Спасибо Вам за помощь в улучшении качества нашего контента!</p>
                <button class="success__modal__close">&#10006</button>
            </div>
            <div class="failure_modal d-none">
                <p> Сообщение не отправлено, попробуйте пожалуйста позже</p>
                <button class="failure__modal__close">&#10006</button>
            </div>
        </div>

    </header>

    <div class="workarea">

        <div class="container bx-content-section">
            <div class="row">

                <? $needSidebar = preg_match("~^" . SITE_DIR . "(catalog|personal\/cart|personal\/order\/make)/~", $curPage); ?>
                <div class="bx-content <?= ($needSidebar ? "col" : "col-md-9 col-sm-8") ?>">