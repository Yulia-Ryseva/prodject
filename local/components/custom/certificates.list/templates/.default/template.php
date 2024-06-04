<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); 
use Bitrix\Main\Localization\Loc as Loc;
?>

<?if($USER->IsAuthorized()):?>
    <div class="certificate-list">
        <?if($arResult["CETRIFICATE_LIST"]):?>
            <h3><?=Loc::getMessage('CERTIFICATE_LIST');?></h3>
            <div class="block-list">
                <?$i = 1;?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?=Loc::getMessage('NUMBER');?></th>
                            <th scope="col"><?=Loc::getMessage('DATE');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach($arResult["CETRIFICATE_LIST"] as $list):?>
                            <tr>
                                <th scope="row"><?=$i;?></th>
                                <td><?=$list["NAME"];?></td>
                                <td><?=$list["DATE"];?></td>
                            </tr>
                            <?$i++;?>
                        <?endforeach;?>
                    </tbody>
                </table>
            </div>
        <?else:?>
            <h3><?=Loc::getMessage('CERTIFICATE_NO');?></h3>
        <?endif;?>
    </div>
<?endif;?>