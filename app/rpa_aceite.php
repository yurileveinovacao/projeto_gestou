<?php
// FEA-009 Fase 5 — Tela pública de aceite digital de RPA pelo autônomo (Opção B)
// NÃO requer login. Acesso via token único enviado por email + autenticação dupla por CPF.

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../admin/iuds_pdo.php';

date_default_timezone_set('America/Sao_Paulo');

$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$erro = null;
$rpa = null;

if ($token === '' || strlen($token) !== 64 || !ctype_xdigit($token)) {
    $erro = 'Link inválido ou malformado.';
} else {
    $arr = selectGESRPA_by_token($token);
    if (!is_array($arr) || !isset($arr[0]['id_rpa'])) {
        $erro = 'Link inválido, já utilizado ou expirado. Solicite à empresa um novo link de aceite.';
    } else {
        $rpa = $arr[0];
        if ($rpa['status'] === 'assinado' || $rpa['status'] === 'enviado_fin' || $rpa['status'] === 'pago') {
            $erro = 'Este RPA já foi assinado em ' . date('d/m/Y H:i', strtotime($rpa['data_assinatura'])) . '. Nada a fazer aqui.';
            $rpa = null;
        } elseif ($rpa['status'] === 'cancelado') {
            $erro = 'Este RPA foi cancelado e não pode mais ser assinado.';
            $rpa = null;
        } elseif ($rpa['status'] !== 'autorizado') {
            $erro = 'Este RPA não está em estado de aceite (status atual: ' . $rpa['status'] . ').';
            $rpa = null;
        } elseif (!empty($rpa['token_validade']) && strtotime($rpa['token_validade']) < time()) {
            $erro = 'Este link expirou em ' . date('d/m/Y H:i', strtotime($rpa['token_validade'])) . '. Solicite à empresa um novo link de aceite.';
            $rpa = null;
        }
    }
}

$cpf_fmt = $rpa ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $rpa['autonomo_cpf']) : '';
$data_servico_fmt = $rpa ? date('d/m/Y', strtotime($rpa['data_servico'])) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>Gestou — Aceite Digital de RPA</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../admin/vendor_sweeetalert/sweetalert2.min.css">
    <script src="../admin/vendor_sweeetalert/sweetalert2.all.min.js"></script>
    <style>
        body { background: #f5f7fa; }
        .container-aceite { max-width: 700px; margin: 40px auto; }
        .card-aceite { background: #fff; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 32px; }
        h1 { color: #1a73e8; font-size: 22pt; margin-bottom: 0.5em; }
        .info-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 12px 16px; margin: 20px 0; }
        .info-grid > div:nth-child(odd) { font-weight: bold; color: #555; text-align: right; }
        .info-grid > div:nth-child(even) { color: #222; }
        .valor-destaque { font-size: 24pt; color: #28a745; font-weight: bold; }
        .pdf-link { display: inline-block; margin: 4px 8px 4px 0; padding: 8px 16px; background: #f0f0f0; border-radius: 4px; color: #1a73e8; text-decoration: none; }
        .pdf-link:hover { background: #e0e0e0; }
        .termo { background: #fffbe6; border-left: 4px solid #f0b400; padding: 16px; margin: 20px 0; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container-aceite">
        <div class="card-aceite">
            <h1><i class="fas fa-file-signature"></i> Aceite Digital — RPA</h1>

            <?php if ($erro): ?>
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($erro); ?>
                </div>
                <p class="text-muted small">Se você acredita que isso é um engano, entre em contato com a empresa que enviou o link.</p>
            <?php else: ?>

                <p>Olá! Você foi convidado(a) a aceitar digitalmente o pagamento abaixo. Confira os dados, marque o termo de aceite e confirme.</p>

                <div class="info-grid">
                    <div>Empresa:</div>           <div><?php echo htmlspecialchars($rpa['empresa_fantasia'] ?: $rpa['empresa_nome']); ?></div>
                    <div>Autônomo:</div>          <div><?php echo htmlspecialchars($rpa['autonomo_nome']); ?></div>
                    <div>CPF:</div>               <div><?php echo $cpf_fmt; ?></div>
                    <div>Data do serviço:</div>   <div><?php echo $data_servico_fmt; ?></div>
                    <div>Serviço:</div>           <div><?php echo htmlspecialchars($rpa['cargo'] ?? '-'); ?> <?php echo $rpa['setor_nome'] ? '— ' . htmlspecialchars($rpa['setor_nome']) : ''; ?></div>
                </div>

                <div class="text-center my-4">
                    <div>Você receberá via PIX (chave <?php echo htmlspecialchars($rpa['autonomo_pix']); ?>):</div>
                    <div class="valor-destaque">R$ <?php echo number_format($rpa['valor_liquido'], 2, ',', '.'); ?></div>
                    <small class="text-muted">
                        Bruto: R$ <?php echo number_format($rpa['valor_bruto'], 2, ',', '.'); ?> &nbsp;|&nbsp;
                        INSS retido (<?php echo number_format($rpa['perc_imposto'], 2, ',', '.'); ?>%): R$ <?php echo number_format($rpa['valor_inss'], 2, ',', '.'); ?>
                    </small>
                </div>

                <h6 class="text-primary mt-4">Documentos</h6>
                <p class="small">Leia atentamente antes de aceitar:</p>
                <?php foreach (['autorizacao' => 'Autorização', 'contrato' => 'Contrato (Art. 442-B)', 'recibo' => 'Recibo'] as $tipo => $label):
                    if ($rpa[$tipo . '_pdf_path']): ?>
                    <a href="rpa_aceite_pdf.php?token=<?php echo urlencode($token); ?>&tipo=<?php echo $tipo; ?>" target="_blank" class="pdf-link">
                        <i class="fas fa-file-pdf"></i> <?php echo $label; ?>
                    </a>
                <?php endif; endforeach; ?>

                <hr class="mt-4">

                <form id="form-aceite" autocomplete="off">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES); ?>">

                    <div class="form-group mt-3">
                        <label for="cpf"><strong>Confirme seu CPF para autenticação dupla:</strong></label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                    </div>

                    <div class="termo">
                        <label>
                            <input type="checkbox" id="termo" required>
                            Li e aceito os termos de prestação de serviço autônomo (art. 442-B CLT). Reconheço que este aceite digital tem valor probatório equivalente à assinatura à mão para fins operacionais e que minha confirmação será registrada com IP, navegador e horário para fins de auditoria.
                        </label>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" id="btn-aceitar" class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-check"></i> Aceitar e assinar digitalmente
                        </button>
                    </div>
                </form>

            <?php endif; ?>

            <p class="text-center text-muted small mt-4" style="border-top: 1px solid #ccc; padding-top: 12px;">
                Sistema GESTOU — Aceite Digital • <?php echo date('d/m/Y H:i'); ?>
            </p>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>

    <?php if (!$erro && $rpa): ?>
    <script>
        var cpf = document.getElementById('cpf');
        if (cpf) VMasker(cpf).maskPattern('999.999.999-99');

        var termo = document.getElementById('termo');
        var btn = document.getElementById('btn-aceitar');
        if (termo && btn) {
            termo.addEventListener('change', function () { btn.disabled = !termo.checked; });
        }

        $('#form-aceite').on('submit', function (e) {
            e.preventDefault();
            if (!termo.checked) {
                Swal.fire('Atenção', 'Você precisa marcar o termo de uso para aceitar.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Confirma o aceite?',
                html: 'Você está prestes a <b>assinar digitalmente</b> este RPA.<br>Esta ação é registrada e auditável (IP, navegador, horário) e <b>não pode ser desfeita</b>.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, aceitar e assinar',
                cancelButtonText: 'Cancelar'
            }).then(function (res) {
                if (!res.isConfirmed) return;

                $.post('controller/rpa_aceite_post.php', $('#form-aceite').serialize(), function (resp) {
                    try { resp = typeof resp === 'string' ? JSON.parse(resp) : resp; } catch (e) {}
                    if (resp && resp.status === 'sucesso') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Aceite registrado!',
                            html: 'Obrigado, ' + (resp.nome || '') + '!<br>Seu aceite foi registrado em ' + (resp.data_assinatura || '') + '.<br><br>A empresa será notificada para liberar o pagamento.',
                            confirmButtonText: 'Fechar',
                            allowOutsideClick: false
                        }).then(function () {
                            document.getElementById('form-aceite').style.display = 'none';
                        });
                    } else if (resp && resp.status === 'cpf_invalido') {
                        Swal.fire('CPF não confere', 'O CPF informado não corresponde ao cadastro deste RPA.', 'error');
                    } else {
                        Swal.fire('Erro', (resp && resp.mensagem) || 'Falha ao registrar aceite. Tente novamente.', 'error');
                    }
                });
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>
