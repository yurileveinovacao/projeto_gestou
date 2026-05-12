<?php
// FEA-008: helper de geração de PDF a partir de template HTML com variáveis dinâmicas

use Dompdf\Dompdf;

require_once __DIR__.'/../vendor_dompdf/autoload.php';

function _sanitizeTemplateHtml($html)
{
    $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html);
    $html = preg_replace('/<iframe\b[^>]*>.*?<\/iframe>/is', '', $html);
    $html = preg_replace('/<object\b[^>]*>.*?<\/object>/is', '', $html);
    $html = preg_replace('/<embed\b[^>]*\/?>/is', '', $html);
    $html = preg_replace('/\son\w+\s*=\s*"[^"]*"/i', '', $html);
    $html = preg_replace("/\son\w+\s*=\s*'[^']*'/i", '', $html);
    return $html;
}

function _substituirVariaveisTemplate($html, $dados)
{
    $get = function ($k) use ($dados) { return isset($dados[$k]) ? $dados[$k] : ''; };
    $esc = function ($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); };

    $matric = !empty($dados['cod_integracao']) ? $dados['cod_integracao'] : (isset($dados['id_usu']) ? $dados['id_usu'] : '');
    $admiss = !empty($dados['dataadmissao']) ? date('d/m/Y', strtotime($dados['dataadmissao'])) : '';

    $cep_raw = preg_replace('/\D/', '', (string)$get('cep'));
    $cep_fmt = strlen($cep_raw) === 8 ? substr($cep_raw, 0, 5).'-'.substr($cep_raw, 5) : $get('cep');

    $vars = [
        '{nome_colaborador}' => $esc($get('nome')),
        '{cpf}'              => $esc($get('cpf')),
        '{rg}'               => $esc($get('rg')),
        '{matricula}'        => $esc($matric),
        '{cargo}'            => $esc($get('funcao')),
        '{setor}'            => $esc($get('depto_nome')),
        '{empresa}'          => $esc($get('empresa_nome')),
        '{cnpj}'             => $esc($get('empresa_cnpj')),
        '{ctps}'             => $esc($get('ctps')),
        '{pis}'              => $esc($get('pis')),
        '{titulo_eleitor}'   => $esc($get('titulo_eleitor')),
        '{endereco}'         => $esc($get('endereco')),
        '{numero}'           => $esc($get('numero')),
        '{complemento}'      => $esc($get('complemento')),
        '{bairro}'           => $esc($get('bairro')),
        '{cep}'              => $esc($cep_fmt),
        '{cidade}'           => $esc($get('cidade_nome')),
        '{uf}'               => $esc($get('uf_sigla')),
        '{telefone}'         => $esc($get('telefone')),
        '{celular}'          => $esc($get('celular')),
        '{data_admissao}'    => $admiss,
        '{data_hoje}'        => date('d/m/Y'),
    ];

    return strtr($html, $vars);
}

function gerarPdfTemplate($conteudo_html, $titulo, $dados_colaborador, $raiz_cnpj, $file_id)
{
    $html  = _sanitizeTemplateHtml($conteudo_html);
    $html  = _substituirVariaveisTemplate($html, $dados_colaborador);
    $tit_safe = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');

    $wrapper = '<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>'.$tit_safe.'</title>
<style>
@page { margin: 2cm; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12pt; color: #222; line-height: 1.5; }
h1.titulo-doc { font-size: 16pt; text-align: center; margin: 0 0 1.5em 0; padding-bottom: 0.4em; border-bottom: 2px solid #444; }
p { margin: 0 0 0.8em 0; }
table { border-collapse: collapse; }
table td, table th { padding: 4pt 8pt; }
.rodape-doc { margin-top: 3em; font-size: 9pt; color: #666; text-align: right; border-top: 1px solid #ccc; padding-top: 0.5em; }
</style>
</head>
<body>
<h1 class="titulo-doc">'.$tit_safe.'</h1>
'.$html.'
<div class="rodape-doc">Documento gerado em '.date('d/m/Y H:i').'</div>
</body>
</html>';

    $dompdf = new Dompdf(["enable_remote" => false]);
    $dompdf->loadHtml($wrapper, 'UTF-8');
    $dompdf->setPaper("A4", "portrait");
    $dompdf->render();
    $output = $dompdf->output();

    $dir = __DIR__.'/../../upload/beneficios/recibos_diversos/'.$raiz_cnpj;
    if (!file_exists($dir)) {
        $umaskOld = umask(0);
        mkdir($dir, 0777, true);
        umask($umaskOld);
    }
    $nome_arquivo = $raiz_cnpj.'_'.$file_id.'_recibodiversos.pdf';
    if (file_put_contents($dir.'/'.$nome_arquivo, $output) === false) {
        throw new Exception('Falha ao gravar PDF em '.$dir.'/'.$nome_arquivo.' (verifique permissões)');
    }

    return $nome_arquivo;
}
