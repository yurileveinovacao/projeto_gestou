<?php
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

// Visualizar justificativa
if (isset($_POST['btn_visualizar'])) {
    $id = intval($_POST['id_justificativa']);
    $_SESSION['id_justificativa_update'] = $id;

    foreach (selectJustificativa_id($id) as $linha) {
        $tipo_raw = $linha['tipo'];
        $tipos = array('ausencia_ponto' => 'Ausência de Ponto', 'falta' => 'Falta', 'falta_atestado' => 'Falta com Atestado');
        $tipo = isset($tipos[$tipo_raw]) ? $tipos[$tipo_raw] : $tipo_raw;
        $data_oc = (new DateTime($linha['data_ocorrencia']))->format('d/m/Y');
        $hora = $linha['hora_ocorrencia'];
        $mensagem = $linha['mensagem'];
        $arquivo = $linha['arquivo_path'];
        $status = $linha['status'];
        $resposta = $linha['resposta_admin'];
        $colaborador = $linha['colaborador_nome'];

        $retorno = '';
        $retorno .= '<div class="form-row mb-2">';
        $retorno .= '<div class="col-md-6"><strong>Colaborador:</strong> ' . htmlspecialchars($colaborador) . '</div>';
        $retorno .= '<div class="col-md-6"><strong>Tipo:</strong> ' . $tipo . '</div>';
        $retorno .= '</div>';
        $retorno .= '<div class="form-row mb-2">';
        $retorno .= '<div class="col-md-6"><strong>Data:</strong> ' . $data_oc . '</div>';
        if (!empty($hora)) {
            $retorno .= '<div class="col-md-6"><strong>Hora:</strong> ' . $hora . '</div>';
        }
        $retorno .= '</div>';
        if (!empty($mensagem)) {
            $retorno .= '<div class="form-row mb-2"><div class="col-md-12"><strong>Mensagem:</strong><br>' . nl2br(htmlspecialchars($mensagem)) . '</div></div>';
        }
        if (!empty($arquivo)) {
            $retorno .= '<div class="form-row mb-2"><div class="col-md-12"><strong>Anexo:</strong> <a href="../upload/' . $arquivo . '" target="_blank" class="btn btn-sm btn-outline-primary">Ver anexo</a></div></div>';
        }
        if (!empty($resposta)) {
            $retorno .= '<hr>';
            $retorno .= '<div class="form-row mb-2"><div class="col-md-12"><strong>Resposta do Admin:</strong><br>' . nl2br(htmlspecialchars($resposta)) . '</div></div>';
        }

        echo $retorno;
    }
}

// Aprovar justificativa
if (isset($_POST['btn_aprovar'])) {
    try {
        $id = $_SESSION['id_justificativa_update'];
        $resposta = isset($_POST['resposta']) ? strtoupper(trim($_POST['resposta'])) : null;
        $respondido_em = date('Y-m-d H:i:s');
        $respondido_por = $id_usa_default;

        updateJustificativa_status($id, 'aprovada', $resposta, $respondido_em, $respondido_por);

        // Email ao colaborador
        foreach (selectJustificativa_id($id) as $linha) {
            $email_colab = $linha['colaborador_email'];
            $nome_colab = $linha['colaborador_nome'];
            $tipo_raw = $linha['tipo'];
            $tipos = array('ausencia_ponto' => 'Ausência de Ponto', 'falta' => 'Falta', 'falta_atestado' => 'Falta com Atestado');
            $tipo = isset($tipos[$tipo_raw]) ? $tipos[$tipo_raw] : $tipo_raw;
            $data_oc = (new DateTime($linha['data_ocorrencia']))->format('d/m/Y');

            if (!empty($email_colab)) {
                try {
                    require_once __DIR__.'/../vendor_envio_email/autoload.php';
                    require_once __DIR__.'/../../config/mail.php';
                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    configureMailer($mail);
                    $mail->addAddress($email_colab);
                    $mail->isHTML(true);
                    $mail->Subject = 'Gestou - Justificativa Aprovada';
                    $mail->Body = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;"><div style="background-color:#4A0E8F;padding:20px;text-align:center;"><h2 style="color:#FFD700;margin:0;">GESTOU</h2></div><div style="padding:20px;border:1px solid #e3e6f0;"><h3 style="color:#28a745;">Justificativa Aprovada</h3><p>Sua justificativa foi <strong>aprovada</strong>.</p><table style="width:100%;border-collapse:collapse;margin:15px 0;"><tr style="background:#f8f9fc;"><td style="padding:10px;border:1px solid #e3e6f0;"><strong>Tipo</strong></td><td style="padding:10px;border:1px solid #e3e6f0;">' . $tipo . '</td></tr><tr><td style="padding:10px;border:1px solid #e3e6f0;"><strong>Data</strong></td><td style="padding:10px;border:1px solid #e3e6f0;">' . $data_oc . '</td></tr>' . (!empty($resposta) ? '<tr style="background:#f8f9fc;"><td style="padding:10px;border:1px solid #e3e6f0;"><strong>Resposta</strong></td><td style="padding:10px;border:1px solid #e3e6f0;">' . htmlspecialchars($resposta) . '</td></tr>' : '') . '</table></div><div style="background:#f8f9fc;padding:10px;text-align:center;font-size:11px;color:#999;">Email automatico - Gestou</div></div>';
                    $mail->send();
                } catch (\Exception $e) {
                    // log error silently
                }
            }
        }

        echo '1';
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

// Reprovar justificativa
if (isset($_POST['btn_reprovar'])) {
    try {
        $id = $_SESSION['id_justificativa_update'];
        $resposta = isset($_POST['resposta']) ? strtoupper(trim($_POST['resposta'])) : null;
        $respondido_em = date('Y-m-d H:i:s');
        $respondido_por = $id_usa_default;

        updateJustificativa_status($id, 'reprovada', $resposta, $respondido_em, $respondido_por);

        // Email ao colaborador
        foreach (selectJustificativa_id($id) as $linha) {
            $email_colab = $linha['colaborador_email'];
            $nome_colab = $linha['colaborador_nome'];
            $tipo_raw = $linha['tipo'];
            $tipos = array('ausencia_ponto' => 'Ausência de Ponto', 'falta' => 'Falta', 'falta_atestado' => 'Falta com Atestado');
            $tipo = isset($tipos[$tipo_raw]) ? $tipos[$tipo_raw] : $tipo_raw;
            $data_oc = (new DateTime($linha['data_ocorrencia']))->format('d/m/Y');

            if (!empty($email_colab)) {
                try {
                    require_once __DIR__.'/../vendor_envio_email/autoload.php';
                    require_once __DIR__.'/../../config/mail.php';
                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                    configureMailer($mail);
                    $mail->addAddress($email_colab);
                    $mail->isHTML(true);
                    $mail->Subject = 'Gestou - Justificativa Reprovada';
                    $mail->Body = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;"><div style="background-color:#4A0E8F;padding:20px;text-align:center;"><h2 style="color:#FFD700;margin:0;">GESTOU</h2></div><div style="padding:20px;border:1px solid #e3e6f0;"><h3 style="color:#e74a3b;">Justificativa Reprovada</h3><p>Sua justificativa foi <strong>reprovada</strong>.</p><table style="width:100%;border-collapse:collapse;margin:15px 0;"><tr style="background:#f8f9fc;"><td style="padding:10px;border:1px solid #e3e6f0;"><strong>Tipo</strong></td><td style="padding:10px;border:1px solid #e3e6f0;">' . $tipo . '</td></tr><tr><td style="padding:10px;border:1px solid #e3e6f0;"><strong>Data</strong></td><td style="padding:10px;border:1px solid #e3e6f0;">' . $data_oc . '</td></tr>' . (!empty($resposta) ? '<tr style="background:#f8f9fc;"><td style="padding:10px;border:1px solid #e3e6f0;"><strong>Resposta</strong></td><td style="padding:10px;border:1px solid #e3e6f0;">' . htmlspecialchars($resposta) . '</td></tr>' : '') . '</table></div><div style="background:#f8f9fc;padding:10px;text-align:center;font-size:11px;color:#999;">Email automatico - Gestou</div></div>';
                    $mail->send();
                } catch (\Exception $e) {
                    // log error silently
                }
            }
        }

        echo '1';
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
