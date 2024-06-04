<?
namespace Custom;
use \Bitrix\Main\Loader;
require_once $_SERVER["DOCUMENT_ROOT"].'/local/lib/FPDF/fpdf.php';

class GetPdf
{
    public $idIblock = 1;

    public function __construct()
    {
        Loader::includeModule('iblock');
    }

    public function startLoad($id)
    {
        if($id) {
            $this->getElement($id); 
              
            $scheme = isset($_SERVER['HTTP_SCHEME']) ? $_SERVER['HTTP_SCHEME'] : (
                (
             (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
              443 == $_SERVER['SERVER_PORT']
                ) ? 'https://' : 'http://'
            
            );
            $urlSite = $scheme . $_SERVER["SERVER_NAME"];

            $pdf = new \FPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->AddPage();
            $pdf->SetTitle("pdf"); 
            $pdf->AddFont('Arial','','arial.php'); 
            $pdf->SetFont('Arial', '', 16);
            $pdf->SetXY(10, 10);
            $pdf->MultiCell(180, 6, iconv('utf-8', 'windows-1251', "Номер сертификата: " . $this->arElement["NAME"]), 0, "L");
            $pdf->SetXY(10, 18);
            $pdf->MultiCell(180, 6, iconv('utf-8', 'windows-1251', "Дата активации сертификата: " . $this->arElement["DATE"]), 0, "L");
            
            $this->filename = time();
            $this->file = "/pdf/" . $this->filename . ".pdf";
            $this->fileout["URL"] = $urlSite . $this->file;
            $this->fileout["FILE"] = $_SERVER["DOCUMENT_ROOT"] . $this->file;
            $pdf->Output($this->fileout["FILE"],'F');
            return $this->fileout;
        } else {
            return 0;
        }
    }

    public function getElement($id) 
    {
        $res = \CIBlockElement::GetList(
            [], 
            [
                'IBLOCK_ID' => $this->idIblock,
                'ID' => $id,
            ],
            false,
            false,
            [
                'ID',
                'IBLOCK_ID',
                'NAME',
            ]
        );
        if ($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            
            $this->arElement = [
                "ID" => $arFields['ID'],
                "NAME" => htmlspecialchars_decode($arFields['NAME']),
            ];

            $this->arElementPropAll = $ob->GetProperties();
            $this->arElement["DATE"] = $this->arElementPropAll["DATE"]["VALUE"];
        } 
    }

    public static function agentLoad($id)
    {
        $obj = new GetPdf();
        return $obj->startLoad($id);
    }
}