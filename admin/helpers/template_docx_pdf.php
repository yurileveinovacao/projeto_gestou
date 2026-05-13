<?php
// FEA-008: helper de geração de PDF a partir de template .docx
// Fluxo: PHPWord lê o template, substitui placeholders {variavel}, salva docx temporário,
//        LibreOffice headless converte pra PDF. Resultado vai pra upload/beneficios/recibos_diversos/{cnpj}.

require_once __DIR__ . '/../vendor_phpword/vendor/autoload.php';

function _substituirVariaveisTemplateDocx($tp, $dados)
{
    $get = function ($k) use ($dados) { return isset($dados[$k]) ? (string)$dados[$k] : ''; };
    $matric = !empty($dados['cod_integracao']) ? $dados['cod_integracao'] : (isset($dados['id_usu']) ? $dados['id_usu'] : '');
    $admiss = !empty($dados['dataadmissao']) ? date('d/m/Y', strtotime($dados['dataadmissao'])) : '';
    $cep_raw = preg_replace('/\D/', '', $get('cep'));
    $cep_fmt = strlen($cep_raw) === 8 ? substr($cep_raw, 0, 5) . '-' . substr($cep_raw, 5) : $get('cep');

    $vars = [
        '{nome_colaborador}' => $get('nome'),
        '{cpf}'              => $get('cpf'),
        '{rg}'               => $get('rg'),
        '{matricula}'        => (string)$matric,
        '{cargo}'            => $get('funcao'),
        '{setor}'            => $get('depto_nome'),
        '{empresa}'          => $get('empresa_nome'),
        '{cnpj}'             => $get('empresa_cnpj'),
        '{ctps}'             => $get('ctps'),
        '{pis}'              => $get('pis'),
        '{titulo_eleitor}'   => $get('titulo_eleitor'),
        '{endereco}'         => $get('endereco'),
        '{numero}'           => $get('numero'),
        '{complemento}'      => $get('complemento'),
        '{bairro}'           => $get('bairro'),
        '{cep}'              => $cep_fmt,
        '{cidade}'           => $get('cidade_nome'),
        '{uf}'               => $get('uf_sigla'),
        '{telefone}'         => $get('telefone'),
        '{celular}'          => $get('celular'),
        '{data_admissao}'    => $admiss,
        '{data_hoje}'        => date('d/m/Y'),
    ];

    foreach ($vars as $placeholder => $valor) {
        $tp->setValue($placeholder, $valor);
    }
}

// Executa soffice via proc_open com array de args (não passa pelo shell — sem risco de injection)
function _converterDocxParaPdf($docx_path, $outdir)
{
    $cmd = ['soffice', '--headless', '--convert-to', 'pdf', '--outdir', $outdir, $docx_path];
    $descriptors = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];
    $env = ['HOME' => $outdir, 'PATH' => '/usr/bin:/usr/local/bin:/bin'];
    $proc = proc_open($cmd, $descriptors, $pipes, null, $env);
    if (!is_resource($proc)) {
        throw new Exception('Falha ao iniciar processo soffice.');
    }
    fclose($pipes[0]);
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exit = proc_close($proc);
    if ($exit !== 0) {
        throw new Exception('soffice falhou (exit=' . $exit . '): ' . trim($stderr ?: $stdout));
    }
}

/**
 * Gera o PDF de um template .docx substituindo variáveis pelos dados do colaborador.
 *
 * @param string $arquivo_docx_origem  Caminho absoluto do .docx do template
 * @param array  $dados_colaborador    Dados do colaborador (de selectGESUSU_dados_template)
 * @param string $raiz_cnpj            Raiz do CNPJ da empresa
 * @param string $file_id              Identificador único do PDF gerado
 * @return string                       Nome do arquivo PDF gerado (já gravado no destino final)
 */
function gerarPdfTemplateDocx($arquivo_docx_origem, $dados_colaborador, $raiz_cnpj, $file_id)
{
    if (!file_exists($arquivo_docx_origem)) {
        throw new Exception('Arquivo de template não encontrado: ' . $arquivo_docx_origem);
    }

    $dir_destino = __DIR__ . '/../../upload/beneficios/recibos_diversos/' . $raiz_cnpj;
    if (!file_exists($dir_destino)) {
        $umaskOld = umask(0);
        mkdir($dir_destino, 0777, true);
        umask($umaskOld);
    }

    $tmp_dir = sys_get_temp_dir() . '/fea008_' . uniqid('', true);
    if (!mkdir($tmp_dir, 0777, true)) {
        throw new Exception('Falha ao criar diretório temporário: ' . $tmp_dir);
    }

    try {
        $tp = new \PhpOffice\PhpWord\TemplateProcessor($arquivo_docx_origem);
        _substituirVariaveisTemplateDocx($tp, $dados_colaborador);

        $docx_temp = $tmp_dir . '/output.docx';
        $tp->saveAs($docx_temp);

        _converterDocxParaPdf($docx_temp, $tmp_dir);

        $pdf_temp = $tmp_dir . '/output.pdf';
        if (!file_exists($pdf_temp)) {
            throw new Exception('LibreOffice não gerou o PDF esperado em ' . $pdf_temp);
        }

        $nome_arquivo = $raiz_cnpj . '_' . $file_id . '_recibodiversos.pdf';
        $destino_final = $dir_destino . '/' . $nome_arquivo;

        if (!rename($pdf_temp, $destino_final)) {
            if (!copy($pdf_temp, $destino_final)) {
                throw new Exception('Falha ao gravar PDF final em ' . $destino_final);
            }
            @unlink($pdf_temp);
        }

        return $nome_arquivo;
    } finally {
        if (is_dir($tmp_dir)) {
            foreach (glob($tmp_dir . '/*') as $f) { @unlink($f); }
            @rmdir($tmp_dir);
        }
    }
}
