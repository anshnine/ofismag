<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arParams["ERROR_MESSAGE"] = ""; // сообщение о неудачном запросе
$arParams["SUCCESS_MESSAGE"] = ""; // сообщение об успешном добавлении товара в корзину
$arParams["AMOUNT_MESSAGE"] = ""; // сообщение о превышении остатка

$arProductId = array();

if (isset($_POST["product_id"])) {
    $productId = intval($_POST["product_id"]);
    $arProductId[] = $productId;
}

if (!empty($arProductId)) {
    $arProductFields = array(
        "ID" => $arProductId,
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
    );

    $arProductSelect = array(
        "ID",
        "NAME",
    );

    $arProductFilter = array(
        "ID" => $arProductId,
    );

    $arProducts = CIBlockElement::GetList(
        array(),
        $arProductFilter,
        false,
        false,
        $arProductSelect
    );


    // Получаем цену
    $price_result = CPrice::GetList(
        array(),
        array(
            "PRODUCT_ID" => $productId,
            "CATALOG_GROUP_ID" => 1
        )
    );
    while ($arPrices = $price_result->Fetch()) {
        $myPricesa = $arPrices["PRICE"];
        $myPricesa = substr($myPricesa, 0, -3);
        $myPricesa = number_format($myPricesa, 0, '.', ' ');
    }

    // получаем остатки
    $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
        'filter' => array('=PRODUCT_ID' => $productId, '=STORE.ACTIVE' => 'Y'),
        'select' => array('AMOUNT'),
    ));
    while ($arStoreProduct = $rsStoreProduct->fetch()) {
        $goodRest = $arStoreProduct["AMOUNT"];
    }

    while ($arProduct = $arProducts->GetNext()) {
        $arResult["PRODUCTS"][$arProduct["ID"]] = array(
            "NAME" => $arProduct["NAME"],
            "PRICE" => $myPricesa . ' руб.',
            "AMOUNT" => $goodRest,
        );
    }
    if (empty($arResult["PRODUCTS"])) {
        $arParams["ERROR_MESSAGE"] = "Товар не найден";
    }

}

if (isset($_POST["ACTION"]) && $_POST["ACTION"] == "ADD_TO_CART") {

    $productId = intval($_POST["product_id"]);
    $quantity = intval($_POST["quantity"]);

    if ($productId > 0 && $quantity > 0) {
        if ($quantity > $goodRest) {
            LocalRedirect($APPLICATION->GetCurPage(false) . "?added_to_cart=false");
        } else {
            Add2BasketByProductID($productId, $quantity);
            LocalRedirect($APPLICATION->GetCurPage(false) . "?added_to_cart=true");
        }
    } else {
        $arResult["AMOUNT_MESSAGE"] = "Ошибка ввода данных";
    }
}
if (isset($_GET["added_to_cart"]) && $_GET["added_to_cart"] == "true") {
    $arParams["SUCCESS_MESSAGE"] = "Товар успешно добавлен в корзину";
}
if (isset($_GET["added_to_cart"]) && $_GET["added_to_cart"] == "false") {
    $arParams["SUCCESS_MESSAGE"] = "Столько товара нет на складе";
}


$this->IncludeComponentTemplate(array(
    "ERROR_MESSAGE" => $arParams["ERROR_MESSAGE"],
    "SUCCESS_MESSAGE" => $arParams["SUCCESS_MESSAGE"],
    "AMOUNT_MESSAGE" => $arParams["AMOUNT_MESSAGE"],
));