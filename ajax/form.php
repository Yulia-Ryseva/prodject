<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
$certificate = htmlspecialchars($_REQUEST["certificate"]);

if($certificate > 0) {
    \Bitrix\Main\Loader::includeModule('iblock');

    $elements = \Bitrix\Iblock\Elements\ElementCertificateTable::getList([
        'select' => ['ID', 'NAME', 'IBLOCK_ID', 'ACTIVATION_' => 'ACTIVATION'],
        'filter' => ['=ACTIVE' => 'Y', '=NAME' => $certificate],
    ])->fetchAll();

    foreach ($elements as $element) {
        $idElement = $element["ID"];
        $nameElement = $element["NAME"];
        $idBlock = $element["IBLOCK_ID"];
        $activeElement = $element["ACTIVATION_VALUE"];
    }

    if($idElement) {

        if($activeElement) {
            $result = array(
                'text'  => 'Сертификат уже активирован.',
                'textStatus' => 'error'
            );
        } else {
            CIBlockElement::SetPropertyValuesEx($idElement, false, array("USER" => $USER->GetID()));

            $dbEnumList = CIBlockProperty::GetPropertyEnum("ACTIVATION", ['sort' => 'asc'], ["IBLOCK_ID"=>$idBlock]);
            while($arEnumList = $dbEnumList->GetNext()) {
                if($arEnumList["XML_ID"] == "Y") {
                    $IdProp = $arEnumList["ID"];
                }
            }

            CIBlockElement::SetPropertyValuesEx($idElement, false, array("ACTIVATION" => $IdProp));
            $date = ConvertTimeStamp(false, "FULL");
            CIBlockElement::SetPropertyValuesEx($idElement, false, array("DATE" => $date));

            $result = array(
                'text'  => 'Сертификат активирован.',
                'textStatus' => 'success'
            );

            $arRes = \Custom\GetPdf::agentLoad($idElement);

            $arFile = CFile::MakeFileArray($arRes["URL"]);
            $arFile["MODULE_ID"] = "main";
            $fileId = CFile::SaveFile($arFile, "tmp/pdf");
            \Bitrix\Main\Mail\Event::sendImmediate(array( 
                "EVENT_NAME" => 'SEND_CERTIFICATE',
                "LID" => "s1", 
                "C_FIELDS" => [
                    "MAIL" => $USER->GetEmail(),
                    "NAME" => $nameElement,
                    "DATE" => $date,
                ],
                "FILE" => [
                    $fileId
                ],
            ));    
            
            if($fileId) {
                CFile::Delete($fileId);
                \Bitrix\Main\IO\File::deleteFile($arRes['FILE']);
            }

        }        
    } else {
        $result = array(
            'text'  => 'Сертификат не найден.',
            'textStatus' => 'error'
        );
    }
     
    echo json_encode($result);
}