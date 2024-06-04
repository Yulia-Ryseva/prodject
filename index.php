<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?>

<?$APPLICATION->IncludeComponent(
    "custom:certificates.active", 
    "", 
    [
        "IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "certificates",
    ],
	false
);?>

<?$APPLICATION->IncludeComponent(
    "custom:certificates.list", 
    "", 
    [
        "IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "certificates",
    ],
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>