<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util2.php";


/**
 * 
 * Funções no Click
 * 
 */
// Se o botão 'btn_colab' estiver definido nos dados POST, execute o código a seguir
if (isset($_POST['btn_colab'])) {

    try {
        foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, 9) as $linha) {

            $situac_menu = $linha['situac'];
        }

        if ($situac_menu == 1) {

            // Defina a variável de sessão 'colaborador_filtro_situac' com o valor 'A'
            $_SESSION["colaborador_filtro_situac"] = 'A';

            echo 1;
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Se o botão 'btn_sol' estiver definido nos dados POST, execute o código a seguir
if (isset($_POST['btn_sol'])) {

    // Defina a variável de sessão 'solicitacao_filtro_situac' com o valor 'E'
    $_SESSION["solicitacao_filtro_situac"] = 'E';
}

// FEA-002: Listagem de experiências vencendo
if (isset($_POST['btn_experiencia'])) {

    $tipo_experiencia = intval($_POST['tipo_experiencia']);
    $registros = selectGESUSU_experiencia_lista($id_emp_default, $tipo_experiencia);
    $count_registros = count($registros);

    $retorno = '';

    if ($count_registros > 0 && isset($registros[0]) && is_array($registros[0])) {

        // Cabeçalho da tabela
        $retorno .= '<table class="table table-sm table-bordered">';
        $retorno .= '<thead class="thead-light"><tr>';
        $retorno .= '<th>Nome</th>';
        $retorno .= '<th>Data Admissão</th>';
        $retorno .= '<th>Venc. 45 dias</th>';
        $retorno .= '<th>Venc. 90 dias</th>';
        $retorno .= '<th>Dias desde admissão</th>';
        $retorno .= '</tr></thead><tbody>';

        foreach ($registros as $linha) {

            $dataadmissao = new DateTime($linha['dataadmissao']);
            $venc45 = new DateTime($linha['vencimento_45d']);
            $venc90 = new DateTime($linha['vencimento_90d']);
            $dias = $linha['dias_desde_admissao'];

            $retorno .= '<tr>';
            $retorno .= '<td>' . $linha['nome'] . '</td>';
            $retorno .= '<td>' . $dataadmissao->format("d/m/Y") . '</td>';
            $retorno .= '<td>' . $venc45->format("d/m/Y") . '</td>';
            $retorno .= '<td>' . $venc90->format("d/m/Y") . '</td>';
            $retorno .= '<td class="text-center">' . $dias . '</td>';
            $retorno .= '</tr>';
        }

        $retorno .= '</tbody></table>';
    } else {

        $retorno .= '<p class="text-center text-muted py-3">Nenhum colaborador encontrado.</p>';
    }

    echo $retorno;
}

// FEA-006: Card Turnover — verificar permissão e retornar dados
if (isset($_POST['btn_turnover'])) {
    // Buscar id_mnu do Turnover
    $id_mnu_turnover = 0;
    $q = $pdo->prepare('SELECT id_mnu FROM public."GESMNU" WHERE descri = \'Turnover\' AND nivel = \'11.1\' AND tipo = \'admin\' LIMIT 1');
    $q->execute();
    $r = $q->fetch(PDO::FETCH_ASSOC);
    if ($r) { $id_mnu_turnover = $r['id_mnu']; }

    $situac_menu = 0;
    if ($id_mnu_turnover > 0) {
        foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, $id_mnu_turnover) as $linha) {
            if (is_array($linha)) { $situac_menu = $linha['situac']; }
        }
    }

    if ($situac_menu != 1) {
        echo '0';
    } else {
        $mes = intval($_POST['mes']);
        $ano = intval($_POST['ano']);
        $geral = selectTurnover_geral($id_emp_default, $mes, $ano);
        $departamentos = selectTurnover_por_departamento($id_emp_default, $mes, $ano);

        $meses_pt = array(1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',7=>'Julho',8=>'Agosto',9=>'Setembro',10=>'Outubro',11=>'Novembro',12=>'Dezembro');

        $retorno = '';
        $retorno .= '<div class="text-center mb-3">';
        $retorno .= '<h4>' . $meses_pt[$mes] . '/' . $ano . '</h4>';
        $retorno .= '<h2 class="text-info">' . number_format($geral['turnover'], 1, ',', '.') . '%</h2>';
        $retorno .= '<small class="text-muted">Admissões: ' . $geral['admissoes'] . ' | Demissões: ' . $geral['demissoes'] . ' | Ativos: ' . $geral['ativos'] . '</small>';
        $retorno .= '</div>';

        $retorno .= '<table class="table table-sm table-bordered">';
        $retorno .= '<thead class="thead-light"><tr><th>Departamento</th><th class="text-center">Admissões</th><th class="text-center">Demissões</th><th class="text-center">Ativos</th><th class="text-center">Turnover %</th></tr></thead><tbody>';

        $total_adm = 0; $total_dem = 0; $total_at = 0;
        foreach ($departamentos as $dep) {
            if (!is_array($dep)) continue;
            $adm = intval($dep['admissoes']);
            $dem = intval($dep['demissoes']);
            $at = intval($dep['ativos']);
            $total_adm += $adm; $total_dem += $dem; $total_at += $at;
            $turn = ($at > 0) ? number_format(($adm + $dem) / 2.0 / $at * 100, 1, ',', '.') . '%' : 'N/A';

            $retorno .= '<tr>';
            $retorno .= '<td>' . htmlspecialchars($dep['departamento']) . '</td>';
            $retorno .= '<td class="text-center">' . $adm . '</td>';
            $retorno .= '<td class="text-center">' . $dem . '</td>';
            $retorno .= '<td class="text-center">' . $at . '</td>';
            $retorno .= '<td class="text-center">' . $turn . '</td>';
            $retorno .= '</tr>';
        }

        $total_turn = ($total_at > 0) ? number_format(($total_adm + $total_dem) / 2.0 / $total_at * 100, 1, ',', '.') . '%' : 'N/A';
        $retorno .= '</tbody><tfoot><tr class="font-weight-bold"><td>Total</td><td class="text-center">' . $total_adm . '</td><td class="text-center">' . $total_dem . '</td><td class="text-center">' . $total_at . '</td><td class="text-center">' . $total_turn . '</td></tr></tfoot>';
        $retorno .= '</table>';

        echo $retorno;
    }
}

// FEA-006: Filtro Turnover (sem verificação de permissão — já verificou no clique)
if (isset($_POST['btn_turnover_filtrar'])) {
    $mes = intval($_POST['mes']);
    $ano = intval($_POST['ano']);
    $geral = selectTurnover_geral($id_emp_default, $mes, $ano);
    $departamentos = selectTurnover_por_departamento($id_emp_default, $mes, $ano);

    $meses_pt = array(1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',7=>'Julho',8=>'Agosto',9=>'Setembro',10=>'Outubro',11=>'Novembro',12=>'Dezembro');

    $retorno = '';
    $retorno .= '<div class="text-center mb-3">';
    $retorno .= '<h4>' . $meses_pt[$mes] . '/' . $ano . '</h4>';
    $retorno .= '<h2 class="text-info">' . number_format($geral['turnover'], 1, ',', '.') . '%</h2>';
    $retorno .= '<small class="text-muted">Admissões: ' . $geral['admissoes'] . ' | Demissões: ' . $geral['demissoes'] . ' | Ativos: ' . $geral['ativos'] . '</small>';
    $retorno .= '</div>';

    $retorno .= '<table class="table table-sm table-bordered">';
    $retorno .= '<thead class="thead-light"><tr><th>Departamento</th><th class="text-center">Admissões</th><th class="text-center">Demissões</th><th class="text-center">Ativos</th><th class="text-center">Turnover %</th></tr></thead><tbody>';

    $total_adm = 0; $total_dem = 0; $total_at = 0;
    foreach ($departamentos as $dep) {
        if (!is_array($dep)) continue;
        $adm = intval($dep['admissoes']);
        $dem = intval($dep['demissoes']);
        $at = intval($dep['ativos']);
        $total_adm += $adm; $total_dem += $dem; $total_at += $at;
        $turn = ($at > 0) ? number_format(($adm + $dem) / 2.0 / $at * 100, 1, ',', '.') . '%' : 'N/A';

        $retorno .= '<tr>';
        $retorno .= '<td>' . htmlspecialchars($dep['departamento']) . '</td>';
        $retorno .= '<td class="text-center">' . $adm . '</td>';
        $retorno .= '<td class="text-center">' . $dem . '</td>';
        $retorno .= '<td class="text-center">' . $at . '</td>';
        $retorno .= '<td class="text-center">' . $turn . '</td>';
        $retorno .= '</tr>';
    }

    $total_turn = ($total_at > 0) ? number_format(($total_adm + $total_dem) / 2.0 / $total_at * 100, 1, ',', '.') . '%' : 'N/A';
    $retorno .= '</tbody><tfoot><tr class="font-weight-bold"><td>Total</td><td class="text-center">' . $total_adm . '</td><td class="text-center">' . $total_dem . '</td><td class="text-center">' . $total_at . '</td><td class="text-center">' . $total_turn . '</td></tr></tfoot>';
    $retorno .= '</table>';

    echo $retorno;
}

// Se o botão 'btn_aniver' estiver definido nos dados POST, execute o código a seguir
if (isset($_POST['btn_aniver'])) {

    $registros = selectGESUSU_aniversariantes($id_emp_default);
    $count_registros = count($registros);


    foreach ($registros as $key => $linha) {

        $datanasc = new DateTime($linha['datanasc']);

        if ($key === ($count_registros - 1)) {

            // se o item atual é o último, use a classe sem o traço
            $retorno .= '<div class="w-100 d-flex flex-row align-items-center" style="padding: 16px;">';
        } else {

            // caso contrário, use a classe com o traço
            $retorno .= '<div class="w-100 d-flex flex-row align-items-center" style="border-bottom: 1px solid #e3e6f0; padding: 16px;">';
        }

        $retorno .= '<div>';
        $retorno .= 'Aniversariante: <span class="text-primary font-weight-bolder">' . $linha['aniversariantes'] . '</span><br>';
        $retorno .= 'Dia: <span class="text-primary font-weight-bolder">' . $datanasc->format("d/m") . '</span>';
        $retorno .= '</div>';
        $retorno .= '<button type="button" id="btn-aniversario" class="btn btn-primary ml-auto" title="Cartão de Aniversário" id_usu="' . $linha['id_usu'] . '">';
        $retorno .= '<i class="fas fa-birthday-cake"></i>';
        $retorno .= '</button><br>';
        $retorno .= '</div>';
    }

    echo $retorno;
}

// Verifica se o campo 'btn_submit' está presente na requisição POST
if (isset($_POST['btn_submit'])) {

    try {
        // Obtém o tamanho do arquivo enviado
        $anexo_size = $_FILES['file']['size'];
        // Obtém o valor do campo 'tipo' enviado
        $tipo = $_POST['tipo'];

        // Verifica se o tamanho do arquivo é maior que zero (ou seja, se foi enviado um arquivo)
        if ($anexo_size > 0) {

            // Obtém o nome original do arquivo
            $anexo_nome = $_FILES['file']['name'];
            // Obtém o caminho temporário do arquivo
            $anexo_temp = $_FILES['file']['tmp_name'];

            // Obtém a extensão do arquivo
            $anexo_ext = formatarValor('LOWER', pathinfo($anexo_nome, PATHINFO_EXTENSION));

            // Verifica se o tamanho do arquivo é maior que 100000000 bytes (ou seja, 100MB)
            if ($anexo_size > 100000000) {

                echo 2; // Retorna '2' como resposta para indicar que o arquivo excede o limite de tamanho
                exit;
            }

            // Formata uma data de nome
            $data_nome = formatarValor('NUM', $datinc);

            // Gera um novo nome para o arquivo
            $anexo_nomeNovo = $raiz_cnpj . '_' . $data_nome . '.' . $anexo_ext;

            // Define o diretório de destino para o upload
            $pasta = '../../master/upload/' . $raiz_cnpj;

            // Verifica se o diretório de destino não existe
            if (!file_exists($pasta)) {

                // Cria o diretório de destino com permissões de acesso
                mkdir($pasta, 0700, true);
            }

            // Move o arquivo do diretório temporário para o diretório de destino
            $mover = move_uploaded_file($anexo_temp, $pasta . '/' . $anexo_nomeNovo);

            // Verifica o valor do campo 'tipo'
            switch ($tipo) {

                case 'btn-importar-holerite':
                    $tipo_modelo = 'H';
                    break;

                case 'btn-importar-ponto':
                    $tipo_modelo = 'P';
                    break;

                case 'btn-importar-irrf':
                    $tipo_modelo = 'I';
                    break;
            }

            // Função para atualizar os modelos com o novo anexo
            updateGESEMP_modelos($id_emp_default, $anexo_nomeNovo, $tipo_modelo);

            echo 1; // Retorna '1' como resposta para indicar sucesso no processamento do arquivo
        } else {

            echo 0; // Retorna '0' como resposta para indicar que nenhum arquivo foi enviado
        }
    } catch (PDOException $erro) {

        echo $erro->getMessage(); // Retorna a mensagem de erro em caso de exceção
    }
}

// Verifica se o botão "btn_colab_visu" foi enviado
if (isset($_POST['btn_colab_visu'])) {

    // Obtém o valor do parâmetro 'tipo' do formulário enviado
    $tipo = $_POST['tipo'];

    // Chama a função selectPAINELRH_colab() para obter registros com base no tipo
    $registros = selectPAINELRH_colab($id_emp_default, $tipo);

    // Obtém o número de registros obtidos
    $count_registros = count($registros);

    // Itera sobre cada registro obtido
    foreach ($registros as $key => $linha) {

        // Verifica se é o último registro
        if ($key === ($count_registros - 1)) {

            // Adiciona estilos CSS diferentes para o último registro e os demais
            $retorno .= '<div class="w-100 d-flex flex-row" style="padding: 0 0 10px 14px;">';
        } else {

            $retorno .= '<div class="w-100 d-flex flex-row" style="border-bottom: 1px solid #e3e6f0; padding: 0 0 10px 14px;">';
        }

        $retorno .= '<div>';
        // Adiciona o nome do registro atual
        $retorno .= '<span class="text-primary font-weight-bolder">' . $linha['nome'] . '</span><br>';

        // Chama a função selectPAINELRH_mensagem() para obter mensagens relacionadas ao usuário
        foreach (selectPAINELRH_mensagem($linha['id_usu'], $tipo, $id_emp_default) as $linha2) {

            // Cria um objeto DateTime com base na data de inclusão da mensagem
            $datinc_mural = new DateTime($linha2['datinc']);

            // Adiciona a data e o título da mensagem, se disponíveis
            $retorno .= '<span class="font-weight-bolder p-2">' . $datinc_mural->format("d/m/Y") . '</span>';

            if (!empty($linha2['titulo'])) {

                $retorno .= ' - <span class="font-weight-bolder p-2">' . $linha2['titulo'] . '</span>';
            }

            $retorno .= '<br>';
        }

        // Fecha as tags divs abertas e adiciona uma quebra de linha se houver um título para a mensagem
        if (!empty($linha2['titulo'])) {

            $retorno .= '</div>';
            $retorno .= '</div><br>';
        } else {

            $retorno = 1;
        }
    }

    // Exibe o valor de retorno contendo os registros e mensagens formatados
    echo $retorno;
}

// Verifica se o botão "grafico" foi enviado
if (isset($_POST['grafico'])) {

    // Inicializa arrays para armazenar os dados do gráfico
    $label = [];
    $dados1 = [];
    $dados2 = [];

    // Define os nomes das tabelas com base em variáveis e concatenações
    $tabela1 = 'public."GESPON1_' . $raiz_cnpj . '"';
    $tabela2 = 'public."GESIM1_' . $raiz_cnpj . '"';
    $tabela3 = 'public."GESIRR_' . $raiz_cnpj . '"';
    $tabela4 = 'public."GESREC_' . $raiz_cnpj . '"';

    // Chama a função selectDOCUMENTOS_grafico() para obter dados do gráfico
    foreach (selectDOCUMENTOS_grafico($tabela1, $tabela2, $tabela3, $tabela4, $id_emp_default) as $linha) {

        // Manipula a sequência para formatar a data no formato desejado
        $sequencia_ex = explode('-', $linha['sequencia']);
        $sequencia = implode('/', array_reverse($sequencia_ex, true));

        // Adiciona os valores obtidos aos arrays correspondentes
        array_push($label, $sequencia);
        array_push($dados1, $linha['total_documentos']);
        array_push($dados2, $linha['total_documentos_visualizados']);
    }

    // Cria um array associativo com os dados do gráfico
    $dado = [
        'label' => $label,
        'dados1' => $dados1,
        'dados2' => $dados2
    ];

    // Converte o array em formato JSON
    $json = json_encode($dado);

    // Exibe o JSON contendo os dados do gráfico
    echo $json;
}

if (isset($_POST['gerar_token'])) {

    try {
        // Gera um novo token hexadecimal aleatório
        $token_hex = bin2hex(random_bytes(16));

        // Formata o valor da data atual
        $time = formatarValor('NUM', $datinc);

        // Concatena o valor formatado da data atual com o token hexadecimal
        $token = $time . $token_hex;

        // Cria um objeto de data e hora com a data atual
        $data_agora = new DateTime($datinc);

        // Adiciona 24 horas à data atual
        $data_agora->modify('+24 hours');

        // Formata a data de vencimento para o formato 'Y-m-d H:i:s'
        $venc_token = $data_agora->format('Y-m-d H:i:s');

        // Atualiza o token, a data de vencimento e a data de atualização no banco de dados
        updateGESEMP_token($id_emp_default, $token, $venc_token, $datatu);

        $venc_token = new DateTime($venc_token);

        $dia_venc = $venc_token->format('d/m/Y');
        $hora_venc = $venc_token->format('H:i');

        // Atribui o novo token gerado à variável de retorno
        $retorno = [$token, $dia_venc, $hora_venc];

        // Converte o array em JSON
        $retorno_json = json_encode($retorno);

        // Retorna o JSON como resposta
        echo $retorno_json;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Verifica se o botão 'btn_abrir_form' foi enviado
if (isset($_POST['btn_abrir_form'])) {

    // Itera sobre o resultado da função selectGESEMP_token($id_emp_default)
    foreach (selectGESEMP_token($id_emp_default) as $select_gesemp_token) {

        // Obtém o valor 'token' e 'vencimento' do array $select_gesemp_token
        $token = $select_gesemp_token['token'];
        $vencimento = $select_gesemp_token['vencimento'];
    }

    // Verifica se a variável $vencimento é menor que $datinc
    if ($vencimento < $datinc) {

        $venc_format = new DateTime($vencimento);

        // Formata a data de vencimento no formato 'd/m/Y \à\s H:i'
        $retorno = $venc_format->format('d/m/Y \à\s H:i');
    } else {
        // Caso contrário, define o retorno como 1
        $retorno = 1;
    }

    // Retorna o valor de $retorno
    echo $retorno;
}


if (isset($_POST['btn_regerar'])) {

    try {

        // Gera um novo token hexadecimal aleatório
        $token_hex = bin2hex(random_bytes(16));

        // Formata o valor da data atual
        $time = formatarValor('NUM', $datinc);

        // Concatena o valor formatado da data atual com o token hexadecimal
        $token = $time . $token_hex;

        // Cria um objeto de data e hora com a data atual
        $data_agora = new DateTime($datinc);

        // Adiciona 24 horas à data atual
        $data_agora->modify('+24 hours');

        // Formata a data de vencimento para o formato 'Y-m-d H:i:s'
        $venc_token = $data_agora->format('Y-m-d H:i:s');

        // Atualiza o token, a data de vencimento e a data de atualização no banco de dados
        updateGESEMP_token($id_emp_default, $token, $venc_token, $datatu);

        echo 1;
    } catch (PDOException $erro) {

        echo $erro->getMessage();
    }
}

// Verifica se a variável 'card_colab_pendentes' está definida na requisição POST
if (isset($_POST['card_colab_pendentes'])) {

    foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, 9) as $linha) {

        $situac_menu = $linha['situac'];
    }

    if ($situac_menu == 1) {

        // Recupera registros de acordo com a função selectGESUSU_dados_aprovacao
        $registros = selectGESUSU_dados_aprovacao($id_emp_default);

        // Conta o número de registros retornados
        $count_registros = count($registros);

        // Itera sobre cada registro retornado
        foreach ($registros as $key => $linha) {

            // Divide o valor do CPF em partes para formatá-lo posteriormente
            $parte1 = substr($linha['cpf'], 0, 3);
            $parte2 = substr($linha['cpf'], 3, 3);
            $parte3 = substr($linha['cpf'], 6, 3);
            $parte4 = substr($linha['cpf'], 9, 2);

            // Formata o CPF com pontos e traço
            $cpf = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;

            // Verifica se é o último registro
            if ($key === ($count_registros - 1)) {

                // Cria um contêiner div para exibir cada registro, adicionando estilos diferentes para o último registro
                $retorno .= '<div class="w-100 d-flex flex-row align-items-center" style="padding: 16px;">';
            } else {
                $retorno .= '<div class="w-100 d-flex flex-row align-items-center" style="border-bottom: 1px solid #e3e6f0; padding: 16px;">';
            }

            $retorno .= '<div>';
            $retorno .= 'Nome: <span class="text-primary font-weight-bolder">' . $linha['nome'] . '</span><br>';
            $retorno .= 'CPF: <span class="text-primary font-weight-bolder">' . $cpf . '</span><br>';
            $retorno .= 'E-mail: <span class="text-primary font-weight-bolder">' . $linha['email'] . '</span>';
            $retorno .= '</div>';
            $retorno .= '<div class="ml-auto">';
            $retorno .= '<button type="button" class="btn btn-success btn-colab-pendente mr-1" style="width: 42px; height: auto;" title="Aprovar" id_usu="' . $linha['id_usu'] . '" tipo="aprovado">';
            $retorno .= '<i class="fas fa-check"></i>';
            $retorno .= '</button>';
            $retorno .= '<button type="button" class="btn btn-danger btn-colab-pendente" style="width: 42px; height: auto;" title="Reprovar" id_usu="' . $linha['id_usu'] . '" tipo="reprovado">';
            $retorno .= '<i class="fas fa-times"></i>';
            $retorno .= '</button><br>';
            $retorno .= '</div>';
            $retorno .= '</div>';
        }

        // Retorna o valor de $retorno contendo o HTML gerado para exibir os registros
        echo $retorno;
    } else {

        echo 0;
    }
}

// Verifica se o botão 'btn_colab_pendente' está definido na requisição POST
if (isset($_POST['btn_colab_pendente'])) {

    try {

        // Obtém os valores de 'id_usu' e 'tipo' da requisição POST
        $id_usu = $_POST['id_usu'];
        $tipo = $_POST['tipo'];

        // Verifica se o valor de 'tipo' é 'aprovado'
        if ($tipo == 'aprovado') {

            // Define os valores de 'bloqueado', 'situac' e 'retorno' para aprovado
            $bloqueado = 0;
            $situac = 1;
            $retorno = 1;
            // Caso contrário, verifica se o valor de 'tipo' é 'reprovado'
        } else if ($tipo == 'reprovado') {

            // Define os valores de 'bloqueado', 'situac' e 'retorno' para reprovado
            $bloqueado = 1;
            $situac = 0;
            $retorno = 2;
        }

        // Verifica se 'id_usu' e 'tipo' não estão vazios
        if (!empty($id_usu) and !empty($tipo)) {

            // Chama a função updateGESUSU_aprovacao para atualizar a aprovação do colaborador
            updateGESUSU_aprovacao($id_usu, $bloqueado, $situac, $datatu);

            // FEA-001: preenche datarescisao automaticamente na reprovação
            if ($situac == 0) {
                updateGESUSU_DATARESCISAO($id_usu, date('Y-m-d'));
            }

            // Verifica se o valor de 'tipo' é 'aprovado'
            if ($tipo == 'aprovado') {

                foreach (selectGESUSU($id_usu) as $linha_email) {

                    $nome_email = $linha_email["nome"];
                    $email_email = $linha_email["email"];

                    require "../email_colaborador_aprovado.php";
                }
            }

            echo $retorno;
        } else {
            // Se 'id_usu' ou 'tipo' estiverem vazios
            echo 'Valor necessario para a atualização não recebido';
        }
    } catch (PDOException $erro) {

        // Em caso de exceção, exibe a mensagem de erro
        echo $erro->getMessage();
    }
}

// VERIFICA SE O USUARIO TEM PERMISSÃO DE ACESSO A PAGINA SELECIONADA
if (isset($_POST['btn_verificar_dados'])) { // Verifica se o botão 'btn_verificar_dados' foi enviado via POST

    try {

        // Obtém o valor do parâmetro 'page' enviado via POST
        $page = $_POST['page'];

        // Verifica o valor de 'page' e define o valor de 'id_mnu' com base nesse valor
        switch ($page) {

            case 'sobre_nos':
                $id_mnu = 3;
                break;

            case 'missao_visao_valores':
                $id_mnu = 4;
                break;

            case 'politicas_codconduta':
                $id_mnu = 5;
                break;

            case 'organograma':
                $id_mnu = 6;
                break;

            case 'notificacoes':
                $id_mnu = 21;
                break;

            case 'mural_avisos':
                $id_mnu = 22;
                break;

            case 'feedback_sugestoes':
                $id_mnu = 37;
                break;

            case 'treinamentos_manuais':
                $id_mnu = 15;
                break;

            case 'solicitacoes':
                $id_mnu = 23;
                break;
        }

        // Obtém as permissões do usuário para o menu selecionado
        foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, $id_mnu) as $linha) {

            $situac_menu = $linha['situac'];
        }

        // Se a permissão for igual a 1, significa que o usuário tem acesso à página selecionada
        if ($situac_menu == 1) {

            echo 1; // Retorna 1 para indicar que o usuário tem permissão
        } else {

            echo 0; // Retorna 0 para indicar que o usuário não tem permissão
        }
    } catch (PDOException $erro) {

        // Em caso de exceção, captura o erro e exibe a mensagem
        echo $erro->getMessage();
    }
}

// Verifica se houve o clique no card de cursos/exames
if (isset($_POST['card_curexa'])) {

    try {
        // Obtém o número de cursos/exames a vencer para a empresa padrão
        foreach (select_VW_CURSOS_A_VENCER_count($id_emp_default) as $select_count_curso_exame) {

            $count_cursos_exames = $select_count_curso_exame['conta'];
        }

        if (!empty($count_cursos_exames)) { // Verifica se há cursos/exames a vencer

            // Obtém os cursos/exames a vencer para a empresa padrão
            $registros = select_VW_CURSOS_A_VENCER_curso($id_emp_default);
            $count_registros = count($registros); // Obtém o número de registros

            foreach ($registros as $key => $linha) {

                // Aplica um estilo diferente para o último registro
                $style = ($key === $count_registros - 1) ? 'padding: 0 0 10px 14px;' : 'border-bottom: 1px solid #e3e6f0; padding: 0 0 10px 14px;';

                // Monta o HTML para exibir as informações do curso/exame
                $retorno .= '<div class="w-100 d-flex flex-row" style="' . $style . '">';
                $retorno .= '<div>';
                $retorno .= '<span class="text-primary font-weight-bolder">' . $linha['curso'] . '</span><br>';

                foreach (select_VW_CURSOS_A_VENCER($id_emp_default, $linha['id_cur']) as $linha2) {

                    $vencimento = new DateTime($linha2['vencimento']);
                    $retorno .= '<span class="font-weight-bolder p-2">' . $vencimento->format("d/m/Y") . '</span>';
                    $retorno .= ' - <span class="font-weight-bolder p-2">' . $linha2['nome'] . '</span>';
                    $retorno .= '<br>';
                }

                $retorno .= '</div>';
                $retorno .= '</div><br>';
            }

            echo $retorno; // Exibe os cursos/exames a vencer formatados
        } else {

            echo 0; // Retorna 0 para indicar que não há cursos/exames a vencer
        }
    } catch (PDOException $erro) {

        // Em caso de exceção, captura o erro e exibe a mensagem
        echo $erro->getMessage();
    }
}

if (isset($_POST['btn_verif_curexa'])) {

    try {
        // Obtém as permissões do usuário para o menu selecionado (ID 54)
        foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, 54) as $select_permissao) {

            $situac_menu = $select_permissao['situac'];
        }

        if ($situac_menu == 1) { // Se o usuário tem permissão para visualizar os cursos/exames

            echo 1;
        } else {

            echo 0;
        }
    } catch (PDOException $erro) {

        // Em caso de exceção, captura o erro e exibe a mensagem
        echo $erro->getMessage();
    }
}
