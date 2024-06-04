<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_REQUEST["AJAX"] == "Y") {
    $APPLICATION->IncludeComponent(
        "custom:certificates.list", 
        "", 
        [
            "IBLOCK_ID" => "1",
            "IBLOCK_TYPE" => "certificates",
        ],
        false
    );
}