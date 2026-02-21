<?php

if (isset($_POST["id_recebido"])) {

    require_once 'restrito.php';
    require_once 'util.php';
    require_once 'iuds_pdo.php';

    $id_usu = $_POST["id_recebido"];
    $id_emp_default = $_SESSION['id_emp_default'];

    foreach (select_VW_ANIVERSARIOS_SEM_FILTRO_EMAIL($id_usu, $id_emp_default) as $info_email) {

        $nome_usuario = $info_email["nome"];
        $foto_empresa = $info_email["imagem_empresa"];
        $foto_usuario = $info_email["imagem_funcionario"];
        $prox_aniversario = $info_email["prox_aniversario"];
        $prox_aniversario = new DateTime($info_email["prox_aniversario"]);
    }

    $retorno = '';
    $retorno .= '<div class="es-wrapper-color" style="background-color:#FFF;width:100%;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0" id="my-node">
        <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
            <tr style="border-collapse:collapse">
                <td align="center" style="padding:0;Margin:0">
                    <table class="es-header-body" style="border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                        <tr style="border-collapse:collapse">
                            <td style="Margin:0;padding-top:20px;padding-bottom:20px;padding-right:20px;" align="left">
                                <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border-spacing:0px;float:left">
                                    <tr style="border-collapse:collapse">
                                        <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:270px">
                                            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="border-collapse:collapse;border-spacing:0px">
                                                <tr style="border-collapse:collapse">
                                                    <td class="es-m-txt-c" style="padding:0;Margin:0;font-size:0" align="left">
                                                        <img src="../upload/empresa/' . $foto_empresa . '" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="100" height="100">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse:collapse;border-spacing:0px;float:right">
                                    <tr style="border-collapse:collapse">
                                        <td align="left" style="padding:0;Margin:0;width:270px">
                                            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="border-collapse:collapse;border-spacing:0px">
                                                <tr style="border-collapse:collapse">
                                                    <td class="es-m-txt-c" style="padding:0;Margin:0;font-size:0" align="right">
                                                        <img src="../img/images_email/logo_gestou_escrita_amarelo.png" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="200" height="100">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
        <tr style="border-collapse:collapse">
            <td align="center" style="padding:0;Margin:0">
                <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                    <tr style="border-collapse:collapse">
                        <td style="padding:0;Margin:0;background-position:center top;background-color:#202447" bgcolor="#202447" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                    <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                                        <table style="border-collapse:collapse;border-spacing:0px;" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                            <tr style="border-collapse:collapse">
                                                <img src="../img/images_email/baloons.gif" width="100%" height="400">
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="border-collapse:collapse">
                        <td style="Margin:0;padding-bottom:10px;padding-top:20px;padding-left:20px;padding-right:20px;background-position:center top" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed">
                                <tr style="border-collapse:collapse">
                                    <td valign="top" align="center" style="padding:0;Margin:0;">
                                        <table style="border-collapse:collapse;border-spacing:0px;background-position:left top" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-txt-c" align="center" style="padding:0;Margin:0;padding-bottom:10px">
                                                    <h2 style="Margin:0;line-height:29px;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#040404">
                                                        FELIZ ANIVERSÁRIO </h2>
                                                </td>
                                            </tr>
                                            <tr style="border-collapse:collapse">
                                                <td style="padding: 36px;Margin:0;font-size:0" align="center">
                                                    <img src="../upload/cadastro/' . $foto_usuario . '" alt style="display:block;background-color: #fff;border: 2px solid #fff;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; border-radius: 50% !important; box-shadow: 0px 0px 20px gray" width="200" height="200">
                                                </td>
                                            </tr>
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-txt-c" align="center" style="padding:0;Margin:0">
                                                    <h3 style="Margin:0;line-height:24px;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#040404" id="nome_usuario">
                                                        ' . $nome_usuario . '
                                                    </h3>
                                                </td>
                                            </tr>
                                            <tr style="border-collapse:collapse">
                                                <td align="center" style="padding:0;Margin:0;padding-bottom:5px">
                                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;line-height:21px;color:#999999;font-size:14px">
                                                        <strong> ' . $prox_aniversario->format("d/m/Y") . ' </strong>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
    <tr style="border-collapse:collapse">
        <td align="center" style="padding:0;Margin:0">
            <table class="es-footer-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                <tr style="border-collapse:collapse">
                    <td style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color: #202447">
                        <table class="es-right" style="border-collapse:collapse;border-spacing:0px;float:center;background-position:left top" cellspacing="0" cellpadding="0" align="center">
                            <tr style="border-collapse:collapse">
                                <td align="left" style="padding:0;Margin:0;width:172px">
                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="border-collapse:collapse;border-spacing:0px">
                                        <tr style="border-collapse:collapse">
                                            <td class="es-m-txt-c" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;font-size:0" align="center">
                                                <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="border-collapse:collapse;border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                                                            <a target="_blank" href="https://www.facebook.com/gestouapp/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;text-decoration:none;color:#FFFFFF;font-size:14px">
                                                                <img title="Facebook" src="../img/images_email/facebook-circle-colored.png" alt="Fb" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                                            </a>
                                                        </td>
                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                                                            <a target="_blank" href="https://www.instagram.com/gestouapp/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;text-decoration:none;color:#FFFFFF;font-size:14px">
                                                                <img title="Instagram" src="../img/images_email/instagram-circle-colored.png" alt="In" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                                            </a>
                                                        </td>
                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                                                            <a target="_blank" href="https://www.youtube.com/channel/UCafVyh2mkZEMMjc68op94NA/featured" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;text-decoration:none;color:#FFFFFF;font-size:14px">
                                                                <img title="Youtube" src="../img/images_email/youtube-circle-colored.png" alt="Yt" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr style="border-collapse:collapse">
                                            <td align="center" style="padding:0;Margin:0">
                                                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-family:helvetica, helvetica neue, arial, verdana, sans-serif;line-height:21px;color:#FFFFFF;font-size:14px">
                                                    <a target="_blank" href="https://www.gestou.com.br/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;text-decoration:none;color:#FFFFFF;font-size:14px">https://www.gestou.com.br/</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</div>';

//retorno da função
echo $retorno;

}
