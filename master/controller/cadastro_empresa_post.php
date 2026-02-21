<?php

//Faz a requisição da Sessão
require '../restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "../iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "../util.php";


if (isset($_POST['btn-submit'])) {

    // Chama a função para validar os POSTs
    $nomeValido = validarCampo($_POST['nome'], 5);
    $nomeFantasiaValido = validarCampo($_POST['nomefantasia'], 5);
    $cnpjValido = validarCampo($_POST['cnpj'], 18);
    $tipoValido = validarCampo($_POST['tipo'], 1);
    $emailValido = validarEmail($_POST['email']);
    if (!empty($_POST['resp_financeiro'])) {
        $respFinanceiroValido = validarCampo($_POST['resp_financeiro'], 3);
    } else {
        $respFinanceiroValido = true;
    }
    $emailFinanceiroValido = validarEmail($_POST['email_financeiro']);
    $cidadeValido = validarCampo($_POST['cidade'], 1);
    if (!empty($_POST['lay_folha'])) {
        $lay_folhaValido = validarCampo($_POST['lay_folha'], 3);
    } else {
        $lay_folhaValido = true;
    }
    if (!empty($_POST['lay_folha'])) {
        $lay_folhaValido = validarCampo($_POST['lay_folha'], 3);
    } else {
        $lay_folhaValido = true;
    }
    if (!empty($_POST['lay_folha'])) {
        $lay_folhaValido = validarCampo($_POST['lay_folha'], 3);
    } else {
        $lay_folhaValido = true;
    }

    $respRhValido = validarCampo($_POST['resp_rh'], 1);
    $respOuvidoriaValido = validarCampo($_POST['resp_ouvidoria'], 1);

    try {
        $nome = $_POST["nome"]; //REQUIRED
        $cnpj = $_POST["CNPJ"]; //REQUIRED
        $endereco = $_POST["endereco"];
        $numero = $_POST["numero"];
        $bairro = $_POST["bairro"];
        $cep = $_POST["cep"];
        $complemento = $_POST["complemento"];
        $layout_folha = $_POST["lay_folha"];
        $cidade = $_POST["cidade"]; //id_mun //REQUIRED
        $telefone = $_POST["telefone"];
        $email = $_POST["email"];
        $layout_ponto = $_POST["lay_ponto"];
        $id_tus_imp = $_POST["id_tus_imp"]; //REQUIRED
        $id_tus_ace = $_POST["id_tus_ace"]; //REQUIRED
        $layout_irrf = $_POST["lay_irrf"];
        $contato = $_POST["contato"];
        $validacao_gestor = $_POST["validacao_gestor"];
        $tipo = $_POST["tipo"]; //REQUIRED
        $nomefantasia = $_POST["nomefantasia"]; //REQUIRED
        $resp_financeiro = $_POST["resp_financeiro"];
        $email_financeiro = $_POST["email_financeiro"];

        $situac = 1;
        $imagem_update = NULL;

        // INICIO FORMATAÇÃO DE DADOS

        if ($id_tus_imp == 2) {
            $id_per_imp = 1;
        } else if ($id_tus_imp == 3) {
            $id_per_imp = 2;
        }

        if ($id_tus_ace == 2) {
            $id_per_ace = 1;
        } else if ($id_tus_ace == 3) {
            $id_per_ace = 2;
        }

        if ($email == "") {
            $email = NULL;
        }

        if ($contato == "") {
            $contato = NULL;
        } else {
            $contato = mb_strtoupper($contato, 'UTF-8');
        }

        if ($telefone == "") {
            $telefone = NULL;
        } else {
            $telefone = preg_replace('/\D+/', '', $telefone);
        }

        if ($endereco == "") {
            $endereco = NULL;
        }

        if ($bairro == "") {
            $bairro = NULL;
        }

        if ($numero == "") {
            $numero = NULL;
        }

        if ($complemento == "") {
            $complemento = NULL;
        }

        if ($cep == "") {
            $cep = NULL;
        } else {
            $cep = preg_replace('/\D+/', '', $cep);
        }

        if ($layout_folha == "") {
            $layout_folha = NULL;
        }

        if ($layout_ponto == "") {
            $layout_ponto = NULL;
        }

        if ($layout_irrf == "") {
            $layout_irrf = NULL;
        }

        if ($resp_financeiro == "") {
            $resp_financeiro = NULL;
        }

        if ($email_financeiro == "") {
            $email_financeiro = NULL;
        }

        if ($validacao_gestor == "") {
            $validacao_gestor = 0;
        }

        $nome = mb_strtoupper($nome, 'UTF-8');
        $nomefantasia = mb_strtoupper($nomefantasia, 'UTF-8');
        $endereco = mb_strtoupper($endereco, 'UTF-8');
        $bairro = mb_strtoupper($bairro, 'UTF-8');
        $numero = mb_strtoupper($numero, 'UTF-8');
        $complemento = mb_strtoupper($complemento, 'UTF-8');
        $layout_folha = mb_strtoupper($layout_folha, 'UTF-8');
        $layout_ponto = mb_strtoupper($layout_ponto, 'UTF-8');
        $layout_irrf = mb_strtoupper($layout_irrf, 'UTF-8');

        // FIM FORMATAÇÃO DE DADOS

        /*
        //Imprimir valores na tela para conferencia:        
        echo 'Nome: ' . $nome . '<br>';
        echo 'CNPJ: ' . $cnpj . '<br>';
        echo 'Endereço: ' . $endereco . '<br>';
        echo 'Numero: ' . $numero . '<br>';
        echo 'Bairro: ' . $bairro . '<br>';
        echo 'Cep: ' . $cep . '<br>';
        echo 'Complemento: ' . $complemento . '<br>';
        echo 'Folha: ' . $layout_folha . '<br>';
        echo 'Cidade: ' . $cidade . '<br>';
        echo 'Telefone: ' . $telefone . '<br>';
        echo 'Email: ' . $email . '<br>';
        echo 'Ponto: ' . $layout_ponto . '<br>';
        echo 'Id_per_imp: ' . $id_per_imp . '<br>';
        echo 'Id_per_ace: ' . $id_per_ace . '<br>';
        echo 'IRRF: ' . $layout_irrf . '<br>';
        echo 'Contato: ' . $contato . '<br>';
        echo 'Validação Gestor: ' . $validacao_gestor . '<br>';
        echo 'Tipo: ' . $tipo . '<br>';
        echo 'Nome Fantasia: ' . $nomefantasia . '<br>';
        echo 'Resp Financeiro: ' . $resp_financeiro . '<br>';
        echo 'Email Financeiro: ' . $email_financeiro . '<br>';
        echo 'Situac: ' . $situac . '<br>';
        echo 'Iamgem: ' . $imagem_update . '<br>';
        echo 'Datinc: ' . $datinc . '<br>';
        echo 'Datatu: ' . $datatu . '<br>';
        echo 'ID_Mas: ' . $id_mas_default . '<br><br><br>'; */

        // Gera a raiz do CNPJ
        $cnpj_exp = explode('/', $cnpj);
        $raiz = preg_replace('/\D+/', '', $cnpj_exp[0]);

        // Define os diretorios que serão criados
        $diretorio = [
            // Pastas em Beneficios
            '../upload/beneficios/holerite/' . $raiz,
            '../upload/beneficios/irrf/' . $raiz,
            '../upload/beneficios/ponto/' . $raiz,
            '../upload/beneficios/recibos_diversos/' . $raiz,

            // Pastas em Beneficios
            '../upload/cadastro/' . $raiz,

            // Pastas em Empresa
            '../upload/empresa/' . $raiz,

            // Pastas em Mensagens
            '../upload/mensagens/notificacoes/mural_aviso/' . $raiz,
            '../upload/mensagens/notificacoes/notificacoes/' . $raiz,
            '../upload/mensagens/solicitacoes/' . $raiz,

            // Pastas em Utilidades
            '../upload/utilidades/treinamentos/' . $raiz,
        ];

        // Cria os diretorios
        foreach ($diretorio as $pasta) {

            if (!file_exists($pasta)) {

                mkdir($pasta, 0700, true);

                // echo 'Pasta ' . $pasta . ' criada <br>';
            } else {

                // echo 'Pasta ' . $pasta . ' já existe <br>';
            }
        }



        //chamar função de insert
        $insertGESEMP_MASTER = insertGESEMP_MASTER(
            $nome,
            $cnpj,
            $endereco,
            $numero,
            $bairro,
            $cep,
            $situac,
            $complemento,
            $imagem_update,
            $layout_folha,
            $cidade,
            $telefone,
            $datinc,
            $datatu,
            $id_mas_default,
            $email,
            $layout_ponto,
            $id_per_imp,
            $id_per_ace,
            $layout_irrf,
            $contato,
            $validacao_gestor,
            $tipo,
            $nomefantasia,
            $resp_financeiro,
            $email_financeiro
        );

        $id_emp = $insertGESEMP_MASTER['pk'];

        $lay_h = 'VIS';
        $lay_p = 'VIS';
        $lay_i = 'VIS';


        insertGESLAY($id_emp, $lay_h, $lay_p, $lay_i);


        echo "<script language=javascript>
                 alert('Empresa adicionada com Sucesso!');
                 location.href = 'alterar_empresa?al=" .  $id_emp . "';
                 </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();

        echo "<script language=javascript>
        alert('Erro!');
        
    </script>";
    }
}


/**
 * 
 * Funções de validação
 * 
 */

// Valida se o campo preenche o requisito minimo de caracteres
function validarCampo($campo, $minLength)
{
    return !empty($campo) && strlen($campo) >= $minLength;
}

// Valida se é um e-mail
function validarEmail($email)
{
    if (!empty($email)) {

        return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email);
    } else {

        return true;
    }
}
