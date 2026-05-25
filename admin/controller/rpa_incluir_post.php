<?php
// FEA-009 Fase 3 — Inclusão de RPA + geração dos 3 PDFs
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";
require_once "../helpers/rpa_pdf.php";
require_once "../helpers/rpa_email.php";

header('Content-Type: application/json');

try {
    $id_aut         = (int) ($_POST['id_aut'] ?? 0);
    $id_dep         = !empty($_POST['id_dep']) ? (int) $_POST['id_dep'] : null;
    $cargo          = trim($_POST['cargo'] ?? '');
    $data_servico   = $_POST['data_servico'] ?? '';
    $hora_ini       = $_POST['hora_ini'] ?? '';
    $hora_fim       = $_POST['hora_fim'] ?? '';
    $diarias        = max(1, (int) ($_POST['diarias'] ?? 1));
    $valor_liquido  = (float) ($_POST['valor_liquido'] ?? 0);
    $perc_imposto   = (float) ($_POST['perc_imposto'] ?? 12.36);
    $justificativa  = trim($_POST['justificativa'] ?? '');
    $confirmar_alerta = !empty($_POST['confirmar_alerta']);

    if ($id_aut <= 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Selecione o autônomo.']);
        exit;
    }
    if ($valor_liquido <= 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Valor líquido deve ser maior que zero.']);
        exit;
    }
    if (empty($data_servico) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_servico)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Data do serviço inválida.']);
        exit;
    }

    // Multi-tenant: autônomo deve pertencer à empresa
    $aut = selectGESAUT($id_aut, $id_emp_default);
    if (!is_array($aut) || !isset($aut[0]['id_aut'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Autônomo não encontrado nesta empresa.']);
        exit;
    }
    if ((int)$aut[0]['ativo'] !== 1) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Autônomo está inativo.']);
        exit;
    }

    // Validação CLT: diárias no mês/ano do serviço
    $mes = (int) date('m', strtotime($data_servico));
    $ano = (int) date('Y', strtotime($data_servico));
    $diarias_existentes = selectGESRPA_diarias_mes($id_aut, $id_emp_default, $mes, $ano);
    $total_diarias = $diarias_existentes + $diarias;

    $cfg = selectGESRPACFG($id_emp_default);
    $limite_alerta   = (int) ($cfg['limite_dias_alerta']   ?? 3);
    $limite_bloqueio = (int) ($cfg['limite_dias_bloqueio'] ?? 4);

    if ($total_diarias >= $limite_bloqueio) {
        echo json_encode([
            'status'   => 'bloqueio_clt',
            'mensagem' => "Autônomo já tem $diarias_existentes diárias no mês. Adicionar $diarias ultrapassa o limite de $limite_bloqueio (risco de vínculo CLT). Cadastre como CLT ou utilize outro autônomo."
        ]);
        exit;
    }
    if ($total_diarias >= $limite_alerta && !$confirmar_alerta) {
        echo json_encode([
            'status'   => 'alerta_clt',
            'mensagem' => "Autônomo terá $total_diarias diárias no mês (existentes: $diarias_existentes, novas: $diarias). Limite seguro: " . ($limite_alerta - 1) . "."
        ]);
        exit;
    }

    // Cálculo
    $valor_bruto = round($valor_liquido * (1 + $perc_imposto / 100), 2);
    $valor_inss  = round($valor_bruto - $valor_liquido, 2);

    // Normalização
    $cargo = $cargo !== '' ? mb_strtoupper($cargo, 'UTF-8') : null;
    $hora_ini = $hora_ini !== '' ? $hora_ini : null;
    $hora_fim = $hora_fim !== '' ? $hora_fim : null;
    $justificativa = $justificativa !== '' ? $justificativa : null;

    // INSERT
    $id_rpa = insertGESRPA(
        $id_emp_default, $id_aut, $id_dep, $cargo,
        $data_servico, $hora_ini, $hora_fim, $diarias,
        $valor_liquido, $perc_imposto, $valor_bruto, $valor_inss,
        $justificativa, $id_usa_default
    );

    if (!$id_rpa) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Falha ao salvar RPA.']);
        exit;
    }

    // Gera os 3 PDFs
    try {
        gerarPDFsRPA($id_rpa, $id_emp_default);
    } catch (Exception $pdfErr) {
        // Log mas não falha o INSERT (PDFs podem ser regerados depois)
        error_log('[FEA-009] Falha gerando PDFs do RPA ' . $id_rpa . ': ' . $pdfErr->getMessage());
    }

    // FEA-009 Fase 4: notifica Líderes RH por email (não-blocking)
    try {
        enviarEmailAprovacaoRPA($id_rpa, $id_emp_default);
    } catch (Exception $emailErr) {
        error_log('[FEA-009] Falha enviando email de aprovação do RPA ' . $id_rpa . ': ' . $emailErr->getMessage());
    }

    echo json_encode(['status' => 'sucesso', 'id_rpa' => $id_rpa]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
