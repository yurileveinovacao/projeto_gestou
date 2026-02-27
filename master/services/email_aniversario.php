<?php
// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// Carregar o autoloader do composer
require '../vendor_envio_email/autoload.php';
require_once __DIR__.'/../../config/mail.php';
require_once "../iuds_pdo.php";
// Instância da classe
$mail = new PHPMailer(true);
try {
  require_once "envio_email_aniversario.php";
  configureMailer($mail);

  //IMPORTAÇÃO DAS IMAGENS
  $mail->AddEmbeddedImage('../img/imagens_email/facebook-circle-colored.png', 'facebook');
  $mail->AddEmbeddedImage('../img/imagens_email/instagram-circle-colored.png', 'instagram');
  $mail->AddEmbeddedImage('../img/imagens_email/youtube-circle-colored.png', 'youtube');
  $mail->AddEmbeddedImage('../img/imagens_email/logo_gestou_escrita_amarelo.png', 'logogestou');
  $mail->AddEmbeddedImage('../img/imagens_email/baloons.gif', 'baloons');
  $mail->AddEmbeddedImage('../../upload/empresa/' . $imagem_empresa_email . '', 'logoempresa');
  $mail->AddEmbeddedImage('../../upload/cadastro/' . $imagem_funcionario_email . '', 'foto');

  $data_atual = date("d/m/Y");

  // if ($tipo_email == "H") {
  //   $mail->AddEmbeddedImage('../img/images_email/recibo_holerite.png', 'topo');
  //   $beneficio = "RECIBO DE PAGAMENTO";
  // } elseif ($tipo_email == "P") {
  //   $mail->AddEmbeddedImage('../img/images_email/recibo_pontos.png', 'topo');
  //   $beneficio = "ESPELHO DE PONTO";
  // } elseif ($tipo_email == "I") {
  //   $mail->AddEmbeddedImage('../img/images_email/recibo_irrf.png', 'topo');
  //   $beneficio = "INFORME DE RENDIMENTOS";
  // } elseif ($tipo_email == "R") {
  //   $mail->AddEmbeddedImage('../img/images_email/recibo_diversos.png', 'topo');
  //   $beneficio = "RECIBO DIVERSOS";
  // }

  // Define o destinatário
  $mail->addAddress("$email_funcionario", "$nome_email");
  // Conteúdo da mensagem
  $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
  $mail->Subject = 'FELIZ ANIVERSÁRIO ' . $nome_email . '';
  $mail->Body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
  
  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>E-mail Aniversário</title>
    <!--[if (mso 16)]>    <style type="text/css">    a {text-decoration: none;}    </style>    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if gte mso 9]>
  <xml>
      <o:OfficeDocumentSettings>
      <o:AllowPNG></o:AllowPNG>
      <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
    <style type="text/css">
      #outlook a {
        padding: 0;
      }
  
      .ExternalClass {
        width: 100%;
      }
  
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
        line-height: 100%;
      }
  
      .es-button {
        text-decoration: none !important;
      }
  
      a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }
  
      .es-desk-hidden {
        display: none;
        float: left;
        overflow: hidden;
        width: 0;
        max-height: 0;
        line-height: 0;
      }
  
      [data-ogsb] .es-button {
        border-width: 0 !important;
        padding: 10px 30px 10px 30px !important;
      }
  
      [data-ogsb] .es-button.es-button-1 {
        padding: 10px 30px !important;
      }
  
      @media only screen and (max-width:600px) {
  
        p,
        ul li,
        ol li,
        a {
          line-height: 150% !important
        }
  
        h1,
        h2,
        h3,
        h1 a,
        h2 a,
        h3 a {
          line-height: 120% !important
        }
  
        h1 {
          font-size: 28px !important;
          text-align: center
        }
  
        h2 {
          font-size: 26px !important;
          text-align: center
        }
  
        h3 {
          font-size: 20px !important;
          text-align: center
        }
  
        .es-header-body h1 a,
        .es-content-body h1 a,
        .es-footer-body h1 a {
          font-size: 28px !important
        }
  
        .es-header-body h2 a,
        .es-content-body h2 a,
        .es-footer-body h2 a {
          font-size: 26px !important
        }
  
        .es-header-body h3 a,
        .es-content-body h3 a,
        .es-footer-body h3 a {
          font-size: 20px !important
        }
  
        .es-menu td a {
          font-size: 12px !important
        }
  
        .es-header-body p,
        .es-header-body ul li,
        .es-header-body ol li,
        .es-header-body a {
          font-size: 12px !important
        }
  
        .es-content-body p,
        .es-content-body ul li,
        .es-content-body ol li,
        .es-content-body a {
          font-size: 14px !important
        }
  
        .es-footer-body p,
        .es-footer-body ul li,
        .es-footer-body ol li,
        .es-footer-body a {
          font-size: 14px !important
        }
  
        .es-infoblock p,
        .es-infoblock ul li,
        .es-infoblock ol li,
        .es-infoblock a {
          font-size: 11px !important
        }
  
        *[class="gmail-fix"] {
          display: none !important
        }
  
        .es-m-txt-c,
        .es-m-txt-c h1,
        .es-m-txt-c h2,
        .es-m-txt-c h3 {
          text-align: center !important
        }
  
        .es-m-txt-r,
        .es-m-txt-r h1,
        .es-m-txt-r h2,
        .es-m-txt-r h3 {
          text-align: right !important
        }
  
        .es-m-txt-l,
        .es-m-txt-l h1,
        .es-m-txt-l h2,
        .es-m-txt-l h3 {
          text-align: left !important
        }
  
        .es-m-txt-r img,
        .es-m-txt-c img,
        .es-m-txt-l img {
          display: inline !important
        }
  
        .es-button-border {
          display: block !important
        }
  
        a.es-button,
        button.es-button {
          font-size: 14px !important;
          display: block !important;
          border-left-width: 0px !important;
          border-right-width: 0px !important
        }
  
        .es-btn-fw {
          border-width: 10px 0px !important;
          text-align: center !important
        }
  
        .es-adaptive table,
        .es-btn-fw,
        .es-btn-fw-brdr,
        .es-left,
        .es-right {
          width: 100% !important
        }
  
        .es-content table,
        .es-header table,
        .es-footer table,
        .es-content,
        .es-footer,
        .es-header {
          width: 100% !important;
          max-width: 600px !important
        }
  
        .es-adapt-td {
          display: block !important;
          width: 100% !important
        }
  
        .adapt-img {
          width: 100% !important;
          height: auto !important
        }
  
        .es-m-p0 {
          padding: 0px !important
        }
  
        .es-m-p0r {
          padding-right: 0px !important
        }
  
        .es-m-p0l {
          padding-left: 0px !important
        }
  
        .es-m-p0t {
          padding-top: 0px !important
        }
  
        .es-m-p0b {
          padding-bottom: 0 !important
        }
  
        .es-m-p20b {
          padding-bottom: 20px !important
        }
  
        .es-mobile-hidden,
        .es-hidden {
          display: none !important
        }
  
        tr.es-desk-hidden,
        td.es-desk-hidden,
        table.es-desk-hidden {
          width: auto !important;
          overflow: visible !important;
          float: none !important;
          max-height: inherit !important;
          line-height: inherit !important
        }
  
        tr.es-desk-hidden {
          display: table-row !important
        }
  
        table.es-desk-hidden {
          display: table !important
        }
  
        td.es-desk-menu-hidden {
          display: table-cell !important
        }
  
        .es-menu td {
          width: 1% !important
        }
  
        table.es-table-not-adapt,
        .esd-block-html table {
          width: auto !important
        }
  
        table.es-social {
          display: inline-block !important
        }
  
        table.es-social td {
          display: inline-block !important
        }
      }
    </style>
  </head>
  
  <body style="width:100%;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
    <div class="es-wrapper-color" style="background-color:#F6F6F6">
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
                              <img src="cid:logoempresa" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="100" height="100">
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
                              <img src="cid:logogestou" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="100" height="100">
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
                  <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                    <tr style="border-collapse:collapse">
                      <td style="padding:0;Margin:0;background-position:center top;background-color:#202447" bgcolor="#202447" align="left">
                        <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
                          <tr style="border-collapse:collapse">
                            <td valign="top" align="center" style="padding:0;Margin:0;width:600px">
                              <table style="border-collapse:collapse;border-spacing:0px;" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                <tr style="border-collapse:collapse">
                                  <img src="cid:baloons" width="100%" height="400">
                                  </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr style="border-collapse:collapse">
                      <td style="Margin:0;padding-bottom:10px;padding-top:20px;padding-left:20px;padding-right:20px;background-position:center top" align="left">
                        <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
                          <tr style="border-collapse:collapse">
                            <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                              <table style="border-collapse:collapse;border-spacing:0px;background-position:left top" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                <tr style="border-collapse:collapse">
                                  <td class="es-m-txt-c" align="center" style="padding:0;Margin:0;padding-bottom:10px">
                                    <h2 style="Margin:0;line-height:29px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#040404">
                                      FELIZ ANIVERSÁRIO </h2>
                                  </td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                  <td style="padding: 36px;Margin:0;font-size:0" align="center">
                                    <img src="cid:foto" alt style="display:block;background-color: #fff;border: 2px solid #fff;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; border-radius: 50% !important; box-shadow: 0px 0px 20px gray" width="200" height="200">
                                  </td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                  <td class="es-m-txt-c" align="center" style="padding:0;Margin:0">
                                    <h3 style="Margin:0;line-height:24px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:20px;font-style:normal;font-weight:bold;color:#040404">
                                      ' . $nome_email . '</h3>
                                  </td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                  <td align="center" style="padding:0;Margin:0;padding-bottom:5px">
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;color:#999999;font-size:14px">
                                      <strong>' . $data_atual . '</strong>
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
            <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
              <tr style="border-collapse:collapse">
                <td align="center" style="padding:0;Margin:0">
                  <table class="es-footer-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width: 600px;">
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
                                            <img title="Facebook" src="cid:facebook" alt="Fb" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                          </a>
                                        </td>
                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                                          <a target="_blank" href="https://www.instagram.com/gestouapp/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;text-decoration:none;color:#FFFFFF;font-size:14px">
                                            <img title="Instagram" src="cid:instagram" alt="In" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                          </a>
                                        </td>
                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px">
                                          <a target="_blank" href="https://www.youtube.com/channel/UCafVyh2mkZEMMjc68op94NA/featured" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;text-decoration:none;color:#FFFFFF;font-size:14px">
                                            <img title="Youtube" src="cid:youtube" alt="Yt" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                          </a>
                                        </td>
                                        <!-- <td valign="top" align="center" style="padding:0;Margin:0"><img title="Skype" src="images/skype-circle-colored.png" alt="Skype" width="24" height="24" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                        </td> -->
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                  <td align="center" style="padding:0;Margin:0">
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;color:#FFFFFF;font-size:14px">
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
            </table>'.
            // <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
            //   <tr style="border-collapse:collapse">
            //     <td align="center" style="padding:0;Margin:0">
            //       <table class="es-content-body" style="border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
            //         <tr style="border-collapse:collapse">
            //           <td style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;background-position:left top" align="left">
            //             <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
            //               <tr style="border-collapse:collapse">
            //                 <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
            //                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="border-collapse:collapse;border-spacing:0px">
            //                     <tr style="border-collapse:collapse">
            //                       <td class="es-infoblock made_with" style="padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC" align="center">
            //                         <img src="cid:logogestou" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="125" height="57">
            //                       </td>
            //                     </tr>
            //                   </table>
            //                 </td>
            //               </tr>
            //             </table>
            //           </td>
            //         </tr>
            //       </table>
            //     </td>
            //   </tr>
            // </table>
          '</td>
        </tr>
      </table>
    </div>
  </body>
  
  </html>';
  $mail->AltBody = '';
  // Enviar
  $mail->send();
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
