<?php
// FEA-009 Fase 3 — Geração de PDFs do RPA (autorização, contrato, recibo)
// Templates padrão embutidos como fallback quando GESRPACFG.texto_*_html está vazio.
// Admin pode sobrescrever via /admin/dados_cadastrais.php aba RPA (Fase 6).

use Dompdf\Dompdf;

require_once __DIR__ . '/../vendor_dompdf/autoload.php';
require_once __DIR__ . '/../iuds_pdo.php';

// =============================================================================
// Templates HTML padrão (fallback) — usam placeholders {chave}
// =============================================================================

function _rpa_template_default_autorizacao()
{
    return <<<'HTML'
<p><strong>{empresa_nome}</strong>, CNPJ {empresa_cnpj}, AUTORIZA o pagamento ao prestador autônomo abaixo identificado, referente ao serviço prestado.</p>

<p><strong>Prestador:</strong> {nome_autonomo}<br>
<strong>CPF:</strong> {cpf}<br>
<strong>RG:</strong> {rg}</p>

<p><strong>Serviço:</strong> {cargo}<br>
<strong>Setor:</strong> {setor}<br>
<strong>Data do serviço:</strong> {data_servico}<br>
<strong>Horário:</strong> {hora_ini} às {hora_fim}<br>
<strong>Diárias:</strong> {diarias}<br>
<strong>Justificativa:</strong> {justificativa}</p>

<table style="width: 100%; border: 1px solid #888; margin: 1.5em 0;">
  <tr><th style="text-align:left; padding:8pt; background:#f0f0f0;">Composição financeira</th><th style="text-align:right; padding:8pt; background:#f0f0f0;">Valor (R$)</th></tr>
  <tr><td style="padding:8pt;">Valor bruto</td><td style="text-align:right; padding:8pt;">{valor_bruto}</td></tr>
  <tr><td style="padding:8pt;">(-) INSS retido na fonte ({perc_imposto}%)</td><td style="text-align:right; padding:8pt;">{valor_inss}</td></tr>
  <tr style="background:#eef;"><td style="padding:8pt; font-weight:bold;">Líquido a pagar via PIX</td><td style="text-align:right; padding:8pt; font-weight:bold;">{valor_liquido}</td></tr>
</table>

<p><strong>Chave PIX:</strong> {pix}</p>

<p>Por este documento, fica autorizado o Departamento Financeiro a efetuar o pagamento conforme acima detalhado.</p>

<p>{data_hoje}</p>
HTML;
}

function _rpa_template_default_contrato()
{
    return <<<'HTML'
<p style="text-align: justify;">Pelo presente instrumento particular, de um lado <strong>{empresa_nome}</strong>, pessoa jurídica de direito privado, inscrita no CNPJ sob o nº {empresa_cnpj}, doravante denominada simplesmente <strong>CONTRATANTE</strong>; e de outro lado <strong>{nome_autonomo}</strong>, CPF {cpf}, RG {rg}, residente em {endereco}, bairro {bairro}, {cidade}/{uf}, CEP {cep}, doravante denominado <strong>CONTRATADO</strong>, têm entre si justo e acordado o presente Contrato de Prestação de Serviços Autônomos, que se regerá pelas cláusulas e condições seguintes:</p>

<p><strong>CLÁUSULA 1ª — DO OBJETO.</strong> O CONTRATADO prestará à CONTRATANTE serviço de natureza eventual e pontual, sem vínculo empregatício, no âmbito do art. 442-B da CLT, com a seguinte descrição: <strong>{cargo}</strong> no setor {setor}.</p>

<p><strong>CLÁUSULA 2ª — DA EXECUÇÃO.</strong> O serviço será prestado em <strong>{data_servico}</strong>, no horário das {hora_ini} às {hora_fim}, totalizando {diarias} diária(s). Justificativa do serviço: {justificativa}.</p>

<p><strong>CLÁUSULA 3ª — DA REMUNERAÇÃO.</strong> Pelo serviço prestado, a CONTRATANTE pagará ao CONTRATADO o valor líquido de <strong>R$ {valor_liquido}</strong>, mediante transferência via PIX (chave: {pix}). Sobre o valor bruto de R$ {valor_bruto} incide retenção previdenciária de {perc_imposto}% (R$ {valor_inss}), conforme legislação vigente.</p>

<p><strong>CLÁUSULA 4ª — DA INEXISTÊNCIA DE VÍNCULO EMPREGATÍCIO.</strong> As partes reconhecem expressamente que o presente contrato não gera vínculo empregatício, dada a natureza eventual e pontual da prestação de serviço, nos termos do art. 442-B da Consolidação das Leis do Trabalho (CLT). Não há subordinação jurídica, exclusividade, habitualidade ou onerosidade caracterizadora de relação de emprego.</p>

<p><strong>CLÁUSULA 5ª — DOS ENCARGOS TRIBUTÁRIOS.</strong> Os encargos previdenciários (INSS) serão retidos e recolhidos pela CONTRATANTE. Demais tributos eventualmente devidos pelo CONTRATADO em razão deste contrato são de sua exclusiva responsabilidade.</p>

<p><strong>CLÁUSULA 6ª — DO FORO.</strong> Fica eleito o foro da cidade de {cidade} para dirimir quaisquer questões oriundas do presente contrato.</p>

<p>E, por estarem assim ajustados, firmam o presente instrumento em via digital, com aceite registrado eletronicamente.</p>

<p>{data_hoje}</p>

<table style="width: 100%; margin-top: 2em;">
  <tr>
    <td style="width: 50%; text-align: center; padding-top: 3em; border-top: 1px solid #333;">{empresa_nome}<br><small>CONTRATANTE</small></td>
    <td style="width: 50%; text-align: center; padding-top: 3em; border-top: 1px solid #333;">{nome_autonomo}<br><small>CPF {cpf}<br>CONTRATADO</small></td>
  </tr>
</table>
HTML;
}

function _rpa_template_default_recibo()
{
    return <<<'HTML'
<p style="text-align: justify;">Pelo presente, eu <strong>{nome_autonomo}</strong>, CPF {cpf}, RG {rg}, residente em {endereco}, bairro {bairro}, {cidade}/{uf}, CEP {cep}, declaro ter recebido de <strong>{empresa_nome}</strong>, CNPJ {empresa_cnpj}, a importância discriminada abaixo, referente à prestação de serviço autônomo realizada em {data_servico} no setor de {setor} ({cargo}).</p>

<table style="width: 100%; border: 1px solid #333; margin: 2em 0;">
  <tr>
    <th style="text-align:left; padding:10pt; background:#444; color:#fff;">Discriminação</th>
    <th style="text-align:right; padding:10pt; background:#444; color:#fff;">Valor (R$)</th>
  </tr>
  <tr>
    <td style="padding:10pt; border-bottom: 1px solid #ccc;">Valor bruto da prestação de serviço</td>
    <td style="text-align:right; padding:10pt; border-bottom: 1px solid #ccc;">{valor_bruto}</td>
  </tr>
  <tr>
    <td style="padding:10pt; border-bottom: 1px solid #ccc;">(-) INSS retido na fonte ({perc_imposto}%)</td>
    <td style="text-align:right; padding:10pt; border-bottom: 1px solid #ccc;">{valor_inss}</td>
  </tr>
  <tr style="background:#eee;">
    <td style="padding:10pt; font-weight: bold;">VALOR LÍQUIDO RECEBIDO</td>
    <td style="text-align:right; padding:10pt; font-weight: bold;">{valor_liquido}</td>
  </tr>
</table>

<p><strong>Forma de pagamento:</strong> PIX — chave {pix}.</p>

<p style="text-align: justify;">Para maior clareza, firmo o presente recibo, dando à CONTRATANTE plena, geral e irrevogável quitação pelos serviços prestados, nada mais tendo a reclamar a qualquer título.</p>

<p>{data_hoje}</p>

<p style="margin-top: 3em; text-align: center; padding-top: 1em; border-top: 1px solid #333;">{nome_autonomo}<br><small>CPF {cpf}</small></p>
HTML;
}

// =============================================================================
// Sanitização e substituição de placeholders
// =============================================================================

function _rpa_sanitize_html($html)
{
    $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html);
    $html = preg_replace('/<iframe\b[^>]*>.*?<\/iframe>/is', '', $html);
    $html = preg_replace('/<object\b[^>]*>.*?<\/object>/is', '', $html);
    $html = preg_replace('/<embed\b[^>]*\/?>/is', '', $html);
    $html = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $html);
    $html = preg_replace("/\son\w+\s*=\s*'[^']*'/i", '', $html);
    return $html;
}

function _rpa_substituir_placeholders($html, array $dados)
{
    $esc = function ($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); };

    $cpf_raw = preg_replace('/\D/', '', (string)($dados['cpf'] ?? ''));
    $cpf_fmt = strlen($cpf_raw) === 11
        ? substr($cpf_raw,0,3).'.'.substr($cpf_raw,3,3).'.'.substr($cpf_raw,6,3).'-'.substr($cpf_raw,9)
        : ($dados['cpf'] ?? '');

    $cep_raw = preg_replace('/\D/', '', (string)($dados['cep'] ?? ''));
    $cep_fmt = strlen($cep_raw) === 8 ? substr($cep_raw,0,5).'-'.substr($cep_raw,5) : ($dados['cep'] ?? '');

    $data_servico_fmt = !empty($dados['data_servico'])
        ? date('d/m/Y', strtotime($dados['data_servico']))
        : '';

    $fmtMoeda = function ($v) {
        return number_format((float)$v, 2, ',', '.');
    };

    $vars = [
        '{nome_autonomo}'  => $esc($dados['nome_autonomo'] ?? ''),
        '{cpf}'            => $esc($cpf_fmt),
        '{rg}'             => $esc($dados['rg'] ?? ''),
        '{email}'          => $esc($dados['email'] ?? ''),
        '{pix}'            => $esc($dados['pix'] ?? ''),
        '{endereco}'       => $esc($dados['endereco'] ?? ''),
        '{cep}'            => $esc($cep_fmt),
        '{bairro}'         => $esc($dados['bairro'] ?? ''),
        '{cidade}'         => $esc($dados['cidade'] ?? ''),
        '{uf}'             => $esc($dados['uf'] ?? ''),
        '{empresa_nome}'   => $esc($dados['empresa_nome'] ?? ''),
        '{empresa_cnpj}'   => $esc($dados['empresa_cnpj'] ?? ''),
        '{cargo}'          => $esc($dados['cargo'] ?? ''),
        '{setor}'          => $esc($dados['setor'] ?? ''),
        '{data_servico}'   => $data_servico_fmt,
        '{hora_ini}'       => $esc($dados['hora_ini'] ?? ''),
        '{hora_fim}'       => $esc($dados['hora_fim'] ?? ''),
        '{diarias}'        => $esc($dados['diarias'] ?? '1'),
        '{justificativa}'  => $esc($dados['justificativa'] ?? ''),
        '{valor_bruto}'    => $fmtMoeda($dados['valor_bruto'] ?? 0),
        '{valor_inss}'     => $fmtMoeda($dados['valor_inss'] ?? 0),
        '{valor_liquido}'  => $fmtMoeda($dados['valor_liquido'] ?? 0),
        '{perc_imposto}'   => number_format((float)($dados['perc_imposto'] ?? 12.36), 2, ',', '.'),
        '{id_rpa}'         => $esc($dados['id_rpa'] ?? ''),
        '{data_hoje}'      => date('d/m/Y'),
    ];

    return strtr($html, $vars);
}

// =============================================================================
// Renderização e gravação
// =============================================================================

function _rpa_render_pdf($html_bruto, $titulo, array $dados)
{
    $html = _rpa_sanitize_html($html_bruto);
    $html = _rpa_substituir_placeholders($html, $dados);
    $titulo_safe = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');

    $wrapper = '<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>' . $titulo_safe . '</title>
<style>
@page { margin: 2cm; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11pt; color: #222; line-height: 1.5; }
h1.titulo-doc { font-size: 16pt; text-align: center; margin: 0 0 1.5em 0; padding-bottom: 0.4em; border-bottom: 2px solid #444; }
p { margin: 0 0 0.8em 0; }
table { border-collapse: collapse; }
table td, table th { padding: 4pt 8pt; }
.rodape-doc { margin-top: 3em; font-size: 9pt; color: #666; text-align: right; border-top: 1px solid #ccc; padding-top: 0.5em; }
</style>
</head>
<body>
<h1 class="titulo-doc">' . $titulo_safe . '</h1>
' . $html . '
<div class="rodape-doc">RPA #' . ($dados['id_rpa'] ?? '') . ' — gerado em ' . date('d/m/Y H:i') . '</div>
</body>
</html>';

    $dompdf = new Dompdf(["enable_remote" => false]);
    $dompdf->loadHtml($wrapper, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    return $dompdf->output();
}

function _rpa_salvar_pdf($conteudo_binario, $raiz_cnpj, $ano_mes, $id_rpa, $tipo)
{
    $rel = 'upload/rpa/' . $raiz_cnpj . '/' . $ano_mes;
    $base = __DIR__ . '/../../' . $rel;
    if (!is_dir($base)) {
        $umaskOld = umask(0);
        @mkdir($base, 0775, true);
        umask($umaskOld);
    }
    $arquivo = $id_rpa . '_' . $tipo . '.pdf';
    $full = $base . '/' . $arquivo;
    if (file_put_contents($full, $conteudo_binario) === false) {
        throw new Exception('Falha ao gravar PDF: ' . $full);
    }
    return $rel . '/' . $arquivo;
}

// =============================================================================
// API pública: gera os 3 PDFs do RPA e atualiza GESRPA.*_pdf_path
// =============================================================================

function gerarPDFsRPA($id_rpa, $id_emp)
{
    $rpa = selectGESRPA($id_rpa, $id_emp);
    if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
        throw new Exception('RPA não encontrado.');
    }
    $r = $rpa[0];

    // Carrega config (auto-init se necessário)
    $cfg = selectGESRPACFG($id_emp);

    // Dados da empresa (nome + cnpj) — busca via buscaRaizCNPJ pra cnpj raiz, e por nome via outra query
    global $pdo;
    $stmt = $pdo->prepare('SELECT nome, cnpj FROM public."GESEMP" WHERE id_emp =:id_emp');
    $stmt->execute([':id_emp' => $id_emp]);
    $emp = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['nome' => '', 'cnpj' => ''];
    $raiz_cnpj = preg_replace('/\D/', '', $emp['cnpj']);
    if (strlen($raiz_cnpj) === 14) {
        $raiz_cnpj = substr($raiz_cnpj, 0, 8);
    }

    // Monta dados do template
    $dados = [
        'id_rpa'           => $r['id_rpa'],
        'nome_autonomo'    => $r['autonomo_nome'],
        'cpf'              => $r['autonomo_cpf'],
        'email'            => $r['autonomo_email'],
        'pix'              => $r['autonomo_pix'],
        'cargo'            => $r['cargo'],
        'setor'            => $r['setor_nome'] ?? '',
        'data_servico'     => $r['data_servico'],
        'hora_ini'         => $r['hora_ini'],
        'hora_fim'         => $r['hora_fim'],
        'diarias'          => $r['diarias'],
        'justificativa'    => $r['justificativa'],
        'valor_bruto'      => $r['valor_bruto'],
        'valor_inss'       => $r['valor_inss'],
        'valor_liquido'    => $r['valor_liquido'],
        'perc_imposto'     => $r['perc_imposto'],
        'empresa_nome'     => $emp['nome'],
        'empresa_cnpj'     => $emp['cnpj'],
        // Endereço do autônomo: precisa de query adicional
    ];

    // Busca dados completos do autônomo (endereço etc.)
    $stmt2 = $pdo->prepare('SELECT rg, endereco, cep, bairro, cidade, uf FROM public."GESAUT" WHERE id_aut =:id_aut AND id_emp =:id_emp');
    $stmt2->execute([':id_aut' => $r['id_aut'], ':id_emp' => $id_emp]);
    $aut = $stmt2->fetch(PDO::FETCH_ASSOC) ?: [];
    $dados = array_merge($dados, [
        'rg'       => $aut['rg'] ?? '',
        'endereco' => $aut['endereco'] ?? '',
        'cep'      => $aut['cep'] ?? '',
        'bairro'   => $aut['bairro'] ?? '',
        'cidade'   => $aut['cidade'] ?? '',
        'uf'       => $aut['uf'] ?? '',
    ]);

    $ano_mes = date('Y-m', strtotime($r['data_servico']));

    // Templates: usa do banco se não vazio, senão fallback
    $tpl_auth = !empty($cfg['texto_autorizacao_html']) ? $cfg['texto_autorizacao_html'] : _rpa_template_default_autorizacao();
    $tpl_ctt  = !empty($cfg['texto_contrato_html'])    ? $cfg['texto_contrato_html']    : _rpa_template_default_contrato();
    $tpl_rec  = !empty($cfg['texto_recibo_html'])      ? $cfg['texto_recibo_html']      : _rpa_template_default_recibo();

    // Gera e salva
    $pdf_auth = _rpa_render_pdf($tpl_auth, 'Autorização de Pagamento — RPA',     $dados);
    $pdf_ctt  = _rpa_render_pdf($tpl_ctt,  'Contrato de Prestação de Serviços — Art. 442-B CLT', $dados);
    $pdf_rec  = _rpa_render_pdf($tpl_rec,  'Recibo de Pagamento Autônomo',       $dados);

    $path_auth = _rpa_salvar_pdf($pdf_auth, $raiz_cnpj, $ano_mes, $id_rpa, 'autorizacao');
    $path_ctt  = _rpa_salvar_pdf($pdf_ctt,  $raiz_cnpj, $ano_mes, $id_rpa, 'contrato');
    $path_rec  = _rpa_salvar_pdf($pdf_rec,  $raiz_cnpj, $ano_mes, $id_rpa, 'recibo');

    // Atualiza GESRPA com paths
    updateGESRPA_pdf_paths($id_rpa, $id_emp, [
        'autorizacao_pdf_path' => $path_auth,
        'contrato_pdf_path'    => $path_ctt,
        'recibo_pdf_path'      => $path_rec,
    ]);

    return [
        'autorizacao' => $path_auth,
        'contrato'    => $path_ctt,
        'recibo'      => $path_rec,
    ];
}

// =============================================================================
// FEA-009 Fase 5: PDF de evidência do aceite digital (Opção B)
// =============================================================================

function gerarPDFEvidenciaRPA($id_rpa, $id_emp, $token_hash, $ip, $user_agent, $data_aceite)
{
    $rpa = selectGESRPA($id_rpa, $id_emp);
    if (!is_array($rpa) || !isset($rpa[0]['id_rpa'])) {
        throw new Exception('RPA não encontrado para gerar evidência.');
    }
    $r = $rpa[0];

    global $pdo;
    $stmt = $pdo->prepare('SELECT nome, cnpj FROM public."GESEMP" WHERE id_emp =:id_emp');
    $stmt->execute([':id_emp' => $id_emp]);
    $emp = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['nome' => '', 'cnpj' => ''];

    $raiz_cnpj = preg_replace('/\D/', '', $emp['cnpj']);
    if (strlen($raiz_cnpj) === 14) $raiz_cnpj = substr($raiz_cnpj, 0, 8);

    $cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $r['autonomo_cpf']);
    $data_servico_fmt = date('d/m/Y', strtotime($r['data_servico']));
    $data_aceite_fmt = date('d/m/Y \à\s H:i:s', strtotime($data_aceite));
    $hash_partial = substr($token_hash, 0, 16) . '...' . substr($token_hash, -16);

    $titulo_safe = 'Evidência de Aceite Digital — RPA #' . (int) $id_rpa;

    $wrapper = '<!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><title>' . htmlspecialchars($titulo_safe) . '</title>
<style>
@page { margin: 2cm; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11pt; color: #222; line-height: 1.6; }
h1.titulo-doc { font-size: 16pt; text-align: center; margin: 0 0 1.5em 0; padding-bottom: 0.4em; border-bottom: 2px solid #c00; color: #c00; }
.box { border: 2px solid #888; padding: 1.5em; margin: 1.5em 0; background: #fafafa; }
.box-titulo { font-weight: bold; color: #c00; margin-bottom: 0.8em; }
table.dados { width: 100%; border-collapse: collapse; }
table.dados td { padding: 6pt 8pt; border-bottom: 1px solid #ddd; vertical-align: top; }
table.dados td:first-child { width: 35%; font-weight: bold; background: #f0f0f0; }
.codigo { font-family: monospace; font-size: 10pt; word-break: break-all; }
.rodape-doc { margin-top: 3em; font-size: 9pt; color: #666; text-align: center; border-top: 1px solid #ccc; padding-top: 0.5em; }
</style></head>
<body>
<h1 class="titulo-doc">EVIDÊNCIA DE ACEITE DIGITAL</h1>

<p>Este documento certifica que o aceite digital do Recibo de Pagamento Autônomo (RPA) identificado abaixo foi registrado eletronicamente pelo prestador de serviço, mediante autenticação por CPF + token de uso único enviado por email, marcação expressa de termo de uso e confirmação dupla.</p>

<div class="box">
  <div class="box-titulo">DECLARAÇÃO FORMAL DE ACEITE</div>
  <p>Em <strong>' . $data_aceite_fmt . '</strong>, o(a) prestador(a) autônomo(a) abaixo identificado(a) acessou o link de aceite digital deste RPA, marcou expressamente o termo de uso, confirmou a operação em modal de confirmação dupla, e registrou seu aceite com plena ciência das informações apresentadas.</p>
</div>

<table class="dados">
  <tr><td>RPA</td><td>#' . (int) $r['id_rpa'] . '</td></tr>
  <tr><td>Empresa contratante</td><td>' . htmlspecialchars($emp['nome']) . ' — CNPJ ' . htmlspecialchars($emp['cnpj']) . '</td></tr>
  <tr><td>Autônomo</td><td>' . htmlspecialchars($r['autonomo_nome']) . '</td></tr>
  <tr><td>CPF</td><td>' . htmlspecialchars($cpf_fmt) . '</td></tr>
  <tr><td>Email cadastrado (destinatário)</td><td>' . htmlspecialchars($r['autonomo_email']) . '</td></tr>
  <tr><td>Data do serviço</td><td>' . $data_servico_fmt . '</td></tr>
  <tr><td>Valor líquido pago</td><td>R$ ' . number_format($r['valor_liquido'], 2, ',', '.') . '</td></tr>
  <tr><td>Valor bruto / INSS retido</td><td>R$ ' . number_format($r['valor_bruto'], 2, ',', '.') . ' / R$ ' . number_format($r['valor_inss'], 2, ',', '.') . ' (' . number_format($r['perc_imposto'], 2, ',', '.') . '%)</td></tr>
</table>

<h3 style="color: #c00; margin-top: 1.5em;">Trilha de evidência técnica</h3>
<table class="dados">
  <tr><td>Hash do token (parcial)</td><td class="codigo">' . htmlspecialchars($hash_partial) . '</td></tr>
  <tr><td>IP de origem do aceite</td><td class="codigo">' . htmlspecialchars($ip ?? '-') . '</td></tr>
  <tr><td>User-Agent (navegador)</td><td class="codigo">' . htmlspecialchars($user_agent ?? '-') . '</td></tr>
  <tr><td>Timestamp do aceite</td><td>' . $data_aceite_fmt . '</td></tr>
</table>

<p style="margin-top: 2em; font-size: 10pt; color: #555;">
Este documento constitui assinatura eletrônica simples nos termos do art. 4º, I da Lei 14.063/2020, com valor probatório aceito pela Justiça do Trabalho para documentos operacionais. O aceite foi registrado de forma auditável, com identificação dupla (CPF + token), marcação expressa de termo de uso, confirmação dupla via modal, e captura de metadados técnicos (IP, navegador, timestamp).
</p>

<div class="rodape-doc">Evidência gerada automaticamente pelo sistema GESTOU em ' . date('d/m/Y H:i:s') . '</div>
</body></html>';

    $dompdf = new Dompdf(["enable_remote" => false]);
    $dompdf->loadHtml($wrapper, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $output = $dompdf->output();

    $ano_mes = date('Y-m', strtotime($r['data_servico']));
    $path = _rpa_salvar_pdf($output, $raiz_cnpj, $ano_mes, $id_rpa, 'evidencia');

    updateGESRPA_pdf_paths($id_rpa, $id_emp, ['evidencia_pdf_path' => $path]);

    return $path;
}
