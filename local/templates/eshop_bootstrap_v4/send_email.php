<?php
require($_SERVER["DOCUMENT_ROOT"] . "/desktop_app/headers.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
function debug($object)
{
    ob_start();
    print_r($object);
    $contents = ob_get_contents();
    ob_end_clean();
    error_log($contents, 3, $_SERVER["DOCUMENT_ROOT"] . "/debug.log");
}

if (CModule::IncludeModule("iblock")) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["correctVariantInput"]) && $_POST["correctVariantInput"] != "undefined") {
            $correctVariant = trim($_POST["correctVariantInput"]);
        }
        if (isset($_POST["selectedText"]) && $_POST["selectedText"] != "underfined") {
            $selectedText = trim($_POST["selectedText"]);
        }
        if (isset($_POST["srcUrlSpan"]) && $_POST["srcUrlSpan"] != "underfined") {
            $src_url = trim($_POST["srcUrlSpan"]);
        }
        if (isset($selectedText) && isset($src_url)) {
            try {
                CEvent::Send("SEND_ERROR", "s1", array("TEXT_WITH_ERROR" => $selectedText, "URL" => $src_url, "CORRECT" => $correctVariant));
            } catch (Exception $e) {
                debug($e->getMessage());
            }
        }
    }

}