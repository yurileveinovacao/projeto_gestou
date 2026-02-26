<?php
    
    require_once 'restrito.php';
    require_once __DIR__.'/../config/database.php';
    require_once 'raiz_cnpj_pdo.php';
    require_once 'iuds_pdo.php';

    $id_emp_default = $_SESSION['id_emp_default'];
    $controle = $_SESSION['controleModal'];
   
    $retorno = '';
    $compl = ''; 

    //Cabeçalho tabela
    $retorno .= '<table class="table table-sm">';
    $retorno .= '<thead>';
    $retorno .= '<tr>';
    $retorno .= '<th scope="col">Cód. Evento</th>';
    $retorno .= '<th scope="col">ID Evento</th>';
    $retorno .= '<th scope="col">Descrição</th>';
    $retorno .= '<th scope="col">Ação</th>';
    $retorno .= '</tr>';
    $retorno .= '</thead>';
    $retorno .= '<tbody>';


    //Consulta para retornar dados dos eventos da empresa default
    foreach (selectGESEVE_ID_EMP($id_emp_default) as $resultados ) {

    //Definir background para tipo eventos indefinidos
    if($resultados['tipo'] == 'P'){
        $retorno .= '<tr style="background-color: #ffffbf;">';    
    }else{
        $retorno .= '<tr>';
    }
        //Montar linhas tabela para vencimentos e descontos
        $retorno .= '<td>' . $resultados['codevento'] . '</td>';

        //Definir background para tipo eventos indefinidos
        if($resultados['tipo'] == 'P'){
            $retorno .= '<td>' . '<input type="text" name="id_eve_'. $resultados['id_eve'] .'" value=' . $resultados['id_eve'] . ' readonly style="border-style: hidden; outline: none; text-align: left; width: 100px; color: #8b90a3; background-color: #ffffbf;"></td>';    
        }else{
            $retorno .= '<td>' . '<input type="text" name="id_eve_'. $resultados['id_eve'] .'" value=' . $resultados['id_eve'] . ' readonly style="border-style: hidden; outline: none; text-align: left; width: 100px; color: #8b90a3;"></td>';
        }
        $retorno .= '<td>' . $resultados['nome'] . '</td>';
        $retorno .= '<td>';
        $retorno .= '<form id="form' . $resultados['id_eve'] . '" method="post" >';
            switch ($resultados['tipo']) {
                case 'P':
                    $retorno .= '<button type="submit" id="btn-mais" name="btn-mais" id_evento="'. $resultados['id_eve'] .'" class="btn btn-secondary clic_evento_mais"><i class="fas fa-plus"></i></button> &nbsp;';
                    $retorno .= '<button type="submit" id="btn-menos" name="btn-menos" id_evento="'. $resultados['id_eve'] .'" class="btn btn-secondary clic_evento_menos"><i class="fas fa-minus"></i></button>';
                    break;
                case 'D':
                    $retorno .= '<button type="submit" id="btn-mais" name="btn-mais" id_evento="'. $resultados['id_eve'] .'" class="btn btn-secondary clic_evento_mais"><i class="fas fa-plus"></i></button> &nbsp;';
                    $retorno .= '<button type="submit" id="btn-menos" name="btn-menos" id_evento="'. $resultados['id_eve'] .'" class="btn btn-danger clic_evento_menos"><i class="fas fa-minus"></i></button>';
                    break;
                case 'V':
                    $retorno .= '<button type="submit" id="btn-mais" name="btn-mais" id_evento="'. $resultados['id_eve'] .'" class="btn btn-primary clic_evento_mais"><i class="fas fa-plus"></i></button> &nbsp;';
                    $retorno .= '<button type="submit" id="btn-menos" name="btn-menos" id_evento="'. $resultados['id_eve'] .'" class="btn btn-secondary clic_evento_menos"><i class="fas fa-minus"></i></button> ';
                    break;
            }

            //adicionar javaScript do submit
            $compl .= '$("#form' . $resultados['id_eve'] . '").submit(function(event){';
            //$compl .= 'event.preventDefault();';
            $compl .= '});';     
            
        //fechar form
        $retorno .= '</form>';    

        //fechar td
        $retorno .= '</td>';
    }

    //fechar outras tags
    $retorno .= '</tr>';
    $retorno .= '</tbody>';
    $retorno .= '</table>';

    $retorno .= '<script type="text/javascript">';
        //$retorno .= 'alert(\' ' . $controle . '\');'; 

        //adicionar javaScript clic_mais
        $retorno .= '$(document).ready(function(){';
            $retorno .= '$(document).on(\'click\',\'.clic_evento_mais\',function(){';
                //$retorno .= 'alert(\'Entrei na função clic_mais\');';               
                $retorno .= 'var id_recebido = $(this).attr("id_evento");'; 
                $retorno .= 'var dados = {id_recebido: id_recebido, tipo: "V"};';
                $retorno .= '$.post(\'atualizar_acao_evento.php\',{ param: dados });';
                $retorno .= 'ocultarModal();';
                $retorno .= 'exibirModal();';
            $retorno .= '});';       
        $retorno .= '});'; 
        
        //adicionar javaScript clic_menos
        $retorno .= '$(document).ready(function(){';
            $retorno .= '$(document).on(\'click\',\'.clic_evento_menos\',function(){';
                //$retorno .= 'alert(\'Entrei na função clic_menos\');'; 
                $retorno .= 'var id_recebido = $(this).attr("id_evento");'; 
                $retorno .= 'var dados = {id_recebido: id_recebido, tipo: "D"};';
                $retorno .= '$.post(\'atualizar_acao_evento.php\',{ param: dados });';
                $retorno .= 'ocultarModal();';
                $retorno .= 'exibirModal();';
            $retorno .= '});';       
        $retorno .= '});';

        
        //adicionar funcao post com retorno
        $retorno .= 'function executarPost(){';
            $retorno .= 'alert(\'Entrei na função executar post\');';               
            $retorno .= '$.post(\'visualizar_acao_eventos.php\', null , function(retorna){ $("#visuAcaoEvento").html(retorna); $(\'#visuAcaoModalEvento\').modal(\'show\');});';    
        $retorno .= '}';

        //adicionar funcao exibir modal verificando variavel de sessao
        if($controle == 1){
            $_SESSION['controleModal'] = 2;
                $retorno .= 'function exibirModal(){';
                    $retorno .= '$.post(\'visualizar_acao_eventos.php\', null , function(retorna){ $("#visuAcaoEvento2").html(retorna); $(\'#visuAcaoModalEvento2\').modal(\'show\');});';    
                $retorno .= '}';
        }else{
            $_SESSION['controleModal'] = 1;
                $retorno .= 'function exibirModal(){';
                    $retorno .= '$.post(\'visualizar_acao_eventos.php\', null , function(retorna){ $("#visuAcaoEvento").html(retorna); $(\'#visuAcaoModalEvento\').modal(\'show\');});';    
                $retorno .= '}';            
        }

        //adicionar funcao para ocultar modal verificando variavel de sessao
        if($controle == 1){
            $_SESSION['controleModal'] = 2;
                $retorno .= 'function ocultarModal(){';
                    //$retorno .= 'alert(\'Entrei na função ocultar modal 1\');'; 
                    $retorno .= 'var $me = $(visuAcaoModalEvento);';
                    $retorno .= '$me.modal(\'hide\');';
                $retorno .= '}';
        }else{
            $_SESSION['controleModal'] = 1;
                $retorno .= 'function ocultarModal(){';
                    //$retorno .= 'alert(\'Entrei na função ocultar modal 2\');'; 
                    $retorno .= 'var $me = $(visuAcaoModalEvento2);';
                    $retorno .= '$me.modal(\'hide\');';
                $retorno .= '}';            
        } 


        //adicionar javaScript para atualizar pagina pai
        $retorno .= '$(\'#visuAcaoModalEvento\').on(\'hidden.bs.modal\', function () { ';
        $retorno .= 'var urlAtual = window.location.href;' ;
        //$retorno .= 'window.location.href=urlAtual;';
        $retorno .= '});'; 

        //adicionar javascript form
        $retorno .= $compl;
   
    $retorno .= '</script>';
   
    //retorno da função
    echo $retorno; 
    
if (isset($_REQUEST['de'])) {
    try {
        $tipo = "D";
        $id_eve = $_REQUEST["de"];
        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['ve'])) {
      try {
        $tipo = "V";
        $id_eve = $_REQUEST["ve"];
        updateGESEVE_SITUAC($tipo, $id_emp_default, $id_eve, $datatu, $id_usa_default);
      } catch (PDOException $erro) {
          echo $erro->getMessage();
      }
}
 
?>