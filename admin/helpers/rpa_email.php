<?php
// FEA-009 Fase 4 — Email de aprovação para Líderes RH quando RPA é criado

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor_envio_email/autoload.php';
require_once __DIR__ . '/../../config/mail.php';
require_once __DIR__ . '/../iuds_pdo.php';

/**
 * Envia email para cada Líder RH ativo da empresa, comunicando RPA pendente de aprovação.
 * Não-blocking: erros são apenas logados, não propagados.
 *
 * @return array ['enviados' => N, 'erros' => [...]] (pra debug/log)
 */
function enviarEmailAprovacaoRPA($id_rpa, $id_emp)
{
    $resultado = ['enviados' => 0, 'erros' => []];

    try {
        // Busca RPA + dados relacionados
        $rpa_arr = selectGESRPA($id_rpa, $id_emp);
        if (!is_array($rpa_arr) || !isset($rpa_arr[0]['id_rpa'])) {
            $resultado['erros'][] = "RPA $id_rpa não encontrado";
            return $resultado;
        }
        $r = $rpa_arr[0];

        // Identifica destinatários (Líderes RH ativos da empresa, exclui internos id_tus=1)
        $lideres = selectGESUSA_responsaveis_aprovacao($id_emp);
        if (!is_array($lideres) || !isset($lideres[0]['id_usa'])) {
            error_log("[FEA-009] RPA $id_rpa: empresa $id_emp sem Líder RH cadastrado — RPA fica em rascunho até alguém ser promovido");
            return $resultado;
        }

        // Nome da empresa (pra subject e corpo)
        global $pdo;
        $stmt = $pdo->prepare('SELECT nome, nomefantasia FROM public."GESEMP" WHERE id_emp =:id_emp');
        $stmt->execute([':id_emp' => $id_emp]);
        $emp = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['nome' => '', 'nomefantasia' => ''];
        $empresa_nome = $emp['nomefantasia'] ?: $emp['nome'];

        $base_url = rtrim(getenv('APP_URL') ?: 'https://gestou.com.br', '/');
        $link = $base_url . '/admin/rpa_alterar.php?al=' . (int) $id_rpa;

        $cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $r['autonomo_cpf']);
        $data_servico_fmt = date('d/m/Y', strtotime($r['data_servico']));
        $valor_liq_fmt = number_format($r['valor_liquido'], 2, ',', '.');
        $valor_bruto_fmt = number_format($r['valor_bruto'], 2, ',', '.');

        $subject = sprintf('[GESTOU] Novo RPA aguardando aprovação — %s', $r['autonomo_nome']);

        // Corpo HTML enxuto (vs o template grande do recibo de pagamento)
        $body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.5;">
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
  <h2 style="color: #1a73e8; border-bottom: 2px solid #1a73e8; padding-bottom: 8px;">RPA pendente de aprovação</h2>

  <p>Olá,</p>
  <p>Um novo Recibo de Pagamento Autônomo (RPA) foi cadastrado na empresa <strong>' . htmlspecialchars($empresa_nome) . '</strong> e aguarda sua aprovação.</p>

  <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
    <tr><td style="padding: 8px; background: #f0f0f0;"><strong>RPA #</strong></td><td style="padding: 8px;">' . (int) $r['id_rpa'] . '</td></tr>
    <tr><td style="padding: 8px; background: #f0f0f0;"><strong>Autônomo</strong></td><td style="padding: 8px;">' . htmlspecialchars($r['autonomo_nome']) . ' (' . $cpf_fmt . ')</td></tr>
    <tr><td style="padding: 8px; background: #f0f0f0;"><strong>Setor</strong></td><td style="padding: 8px;">' . htmlspecialchars($r['setor_nome'] ?? '-') . '</td></tr>
    <tr><td style="padding: 8px; background: #f0f0f0;"><strong>Data do serviço</strong></td><td style="padding: 8px;">' . $data_servico_fmt . '</td></tr>
    <tr><td style="padding: 8px; background: #f0f0f0;"><strong>Justificativa</strong></td><td style="padding: 8px;">' . htmlspecialchars($r['justificativa'] ?? '-') . '</td></tr>
    <tr><td style="padding: 8px; background: #f0f0f0;"><strong>Valor bruto</strong></td><td style="padding: 8px;">R$ ' . $valor_bruto_fmt . '</td></tr>
    <tr style="background: #e8f0fe;"><td style="padding: 8px;"><strong>Valor líquido (PIX)</strong></td><td style="padding: 8px; font-weight: bold;">R$ ' . $valor_liq_fmt . '</td></tr>
  </table>

  <p style="text-align: center; margin: 30px 0;">
    <a href="' . htmlspecialchars($link, ENT_QUOTES) . '" style="display: inline-block; padding: 12px 24px; background: #1a73e8; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold;">Acessar RPA para aprovação</a>
  </p>

  <p style="font-size: 12px; color: #666; border-top: 1px solid #ccc; padding-top: 12px; margin-top: 30px;">
    Este é um email automático do sistema GESTOU. Você está recebendo porque é Líder RH na empresa ' . htmlspecialchars($empresa_nome) . '.
  </p>
</div>
</body></html>';

        // Envia 1 email para cada Líder
        foreach ($lideres as $lider) {
            if (empty($lider['email'])) continue;
            try {
                $mail = new PHPMailer(true);
                configureMailer($mail);
                $mail->addAddress($lider['email'], $lider['nome']);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->CharSet = 'UTF-8';
                $mail->send();
                $resultado['enviados']++;
            } catch (Exception $e) {
                $resultado['erros'][] = $lider['email'] . ': ' . $e->getMessage();
                error_log("[FEA-009] Falha enviando email pra Líder RH " . $lider['email'] . " sobre RPA $id_rpa: " . $e->getMessage());
            }
        }
    } catch (Exception $e) {
        $resultado['erros'][] = 'fatal: ' . $e->getMessage();
        error_log("[FEA-009] Falha fatal em enviarEmailAprovacaoRPA $id_rpa: " . $e->getMessage());
    }

    return $resultado;
}
