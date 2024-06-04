<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); 
use Bitrix\Main\Localization\Loc as Loc;
?>

<section class="block-certificate">
    <h3><?=Loc::getMessage('CERTIFICATE_ACTIVATION');?></h3>
    <?if($USER->IsAuthorized()):?>
        <div class="block-form">
            <form id="form-send" action="/ajax/form.php" method="post">
                <div class="">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="block-form--line">
                                <input type="text" name="certificate" id="certificate" class="form-control" placeholder="<?=Loc::getMessage('ENTER_THE_CERTIFICATE_NUMBER');?>" required>
                                <div class="msg"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <button class="btn btn-primary" type="submit"><?=Loc::getMessage('ACTIVATE');?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?else:?>
        <p><?=Loc::getMessage('LOGIN');?></p>
        <?$APPLICATION->IncludeComponent(
            "bitrix:system.auth.form",
            "",
            Array(
                "REGISTER_URL" => "register.php",
                "FORGOT_PASSWORD_URL" => "",
                "PROFILE_URL" => "profile.php",
                "SHOW_ERRORS" => "Y" 
            )
        );?>
    <?endif;?>
</section>
