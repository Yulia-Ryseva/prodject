<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc as Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

class CertificateListComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    { 
        return $arParams;
    }

    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->getListCertificate();
            $this->getResult();
        } 
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('iblock')) {
            throw new SystemException(Loc::getMessage('IBLOCK_MODULE_NOT_INSTALLED'));
        }
    }

    protected function getListCertificate() {

        global $USER;
        $elements = \Bitrix\Iblock\Elements\ElementCertificateTable::getList([
            'select' => ['ID', 'NAME', 'IBLOCK_ID', 'ACTIVATION_' => 'ACTIVATION', 'USER_' => 'USER', 'DATE_' => 'DATE'],
            'filter' => ['=ACTIVE' => 'Y', 'IBLOCK_ID' => $this->arParams["IBLOCK_ID"], "USER_VALUE" => $USER->GetID(), "ACTIVATION_VALUE" => "1"],
        ])->fetchAll();

        foreach ($elements as $element) {

            $arCetrificateList[$element["ID"]] = [
                "ID"    => $element["ID"],
                "NAME"  => $element["NAME"],
                "DATE"  => strtolower(FormatDate("d F Y h:m:s", MakeTimeStamp($element["DATE_VALUE"])))
            ];
            $this->arResult["CETRIFICATE_LIST"] = $arCetrificateList;
        }
    }

    protected function getResult()
    {
        $this->IncludeComponentTemplate();
    }
}
?>