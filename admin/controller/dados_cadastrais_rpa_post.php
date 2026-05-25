<?php
// FEA-009 Fase 6 — Salva config de RPA da empresa (GESRPACFG)
require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util2.php";

header('Content-Type: application/json');

try {
    $campos = [];

    if (isset($_POST['valor_liquido_padrao'])) {
        $v = (float) $_POST['valor_liquido_padrao'];
        if ($v < 0.01) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Valor padrão deve ser > 0.']);
            exit;
        }
        $campos['valor_liquido_padrao'] = $v;
    }
    if (isset($_POST['perc_imposto_padrao'])) {
        $p = (float) $_POST['perc_imposto_padrao'];
        if ($p < 0 || $p > 100) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Percentual de imposto inválido.']);
            exit;
        }
        $campos['perc_imposto_padrao'] = $p;
    }
    if (isset($_POST['limite_dias_alerta'])) {
        $a = max(1, (int) $_POST['limite_dias_alerta']);
        $campos['limite_dias_alerta'] = $a;
    }
    if (isset($_POST['limite_dias_bloqueio'])) {
        $b = max(1, (int) $_POST['limite_dias_bloqueio']);
        $campos['limite_dias_bloqueio'] = $b;
    }
    if (isset($campos['limite_dias_alerta'], $campos['limite_dias_bloqueio']) &&
        $campos['limite_dias_alerta'] >= $campos['limite_dias_bloqueio']) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Alerta deve ser menor que o bloqueio.']);
        exit;
    }

    // Templates HTML — vazio significa "remover override e usar padrão embutido"
    foreach (['texto_autorizacao_html', 'texto_contrato_html', 'texto_recibo_html'] as $tpl) {
        if (isset($_POST[$tpl])) {
            $val = trim($_POST[$tpl]);
            $campos[$tpl] = $val !== '' ? $val : null;
        }
    }

    upsertGESRPACFG($id_emp_default, $campos, $id_usa_default);
    echo json_encode(['status' => 'sucesso']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}
