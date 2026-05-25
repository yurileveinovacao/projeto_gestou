<?php
// FEA-009 Fase 5 — Email para o autônomo com link de aceite digital

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor_envio_email/autoload.php';
require_once __DIR__ . '/../../config/mail.php';
require_once __DIR__ . '/../iuds_pdo.php';

/**
 * Gera token de aceite (7 dias validade) e envia email ao autônomo com o link.
 * Não-blocking: erros são logados sem propagar.
 *
 * @return array ['enviado' => bool, 'token' => string|null, 'erro' => string|null]
 */
function enviarEmailAceiteAutonomo($id_rpa, $id_emp)
{
    $resultado = ['enviado' => false, 'token' => null, 'erro' => null];

    try {
        $rpa_arr = selectGESRPA($id_rpa, $id_emp);
        if (!is_array($rpa_arr) || !isset($rpa_arr[0]['id_rpa'])) {
            $resultado['erro'] = "RPA $id_rpa não encontrado";
            return $resultado;
        }
        $r = $rpa_arr[0];

        if (empty($r['autonomo_email'])) {
            $resultado['erro'] = 'Autônomo sem email cadastrado';
            error_log("[FEA-009] RPA $id_rpa: autônomo sem email — não envia aceite");
            return $resultado;
        }

        // Gera token e atualiza GESRPA
        $token = gerarTokenAceiteRPA($id_rpa, $id_emp);
        $resultado['token'] = $token;

        // Nome da empresa
        global $pdo;
        $stmt = $pdo->prepare('SELECT nome, nomefantasia FROM public."GESEMP" WHERE id_emp =:id_emp');
        $stmt->execute([':id_emp' => $id_emp]);
        $emp = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['nome' => '', 'nomefantasia' => ''];
        $empresa_nome = $emp['nomefantasia'] ?: $emp['nome'];

        $base_url = rtrim(getenv('APP_URL') ?: 'https://gestou.com.br', '/');
        $link = $base_url . '/app/rpa_aceite.php?token=' . urlencode($token);

        $data_servico_fmt = date('d/m/Y', strtotime($r['data_servico']));
        $valor_liq_fmt = number_format($r['valor_liquido'], 2, ',', '.');

        $subject = sprintf('[GESTOU] Aceite digital do seu RPA — %s', $empresa_nome);

        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.5;">
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
  <h2 style="color: #1a73e8; border-bottom: 2px solid #1a73e8; padding-bottom: 8px;">RPA aprovado — aguarda seu aceite digital</h2>

  <p>Olá <strong>' . htmlspecialchars($r['autonomo_nome']) . '</strong>,</p>

  <p>A empresa <strong>' . htmlspecialchars($empresa_nome) . '</strong> aprovou o Recibo de Pagamento Autônomo (RPA) referente ao serviço prestado em <strong>' . $data_servico_fmt . '</strong>, no valor líquido de <strong>R$ ' . $valor_liq_fmt . '</strong> (pago via PIX).</p>

  <p>Para finalizar o processo e receber o pagamento, acesse o link abaixo para conferir os dados e registrar seu aceite digital:</p>

  <p style="text-align: center; margin: 30px 0;">
    <a href="' . htmlspecialchars($link, ENT_QUOTES) . '" style="display: inline-block; padding: 14px 28px; background: #1a73e8; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 16px;">Acessar e aceitar RPA</a>
  </p>

  <p style="font-size: 13px; color: #555;">
    <strong>Importante:</strong> este link é válido por 7 dias. Após o aceite, o pagamento será processado pelo financeiro da empresa.
    Se você não reconhecer este RPA, favor desconsiderar este email ou contatar a empresa diretamente.
  </p>

  <p style="font-size: 11px; color: #888; border-top: 1px solid #ccc; padding-top: 12px; margin-top: 30px;">
    Email automático do sistema GESTOU. Não responda a este email.<br>
    Caso o botão acima não funcione, copie e cole o link no seu navegador:<br>
    <span style="word-break: break-all;">' . htmlspecialchars($link) . '</span>
  </p>
</div>
</body></html>';

        $mail = new PHPMailer(true);
        configureMailer($mail);
        $mail->addAddress($r['autonomo_email'], $r['autonomo_nome']);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->CharSet = 'UTF-8';
        $mail->send();
        $resultado['enviado'] = true;
    } catch (Exception $e) {
        $resultado['erro'] = $e->getMessage();
        error_log("[FEA-009] Falha enviando email de aceite do RPA $id_rpa: " . $e->getMessage());
    }

    return $resultado;
}
