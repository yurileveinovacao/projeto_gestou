<?php

//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

require_once "util.php";

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Call opening page">
    <meta name="author" content="Junior">

    <title>GESTOU PORTAL - Fale conosco</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
    <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
    <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once 'menu_lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- TOPBAR -->
                <?php include_once "barra_superior.php";

                include_once "pagina_restrita.php"; ?>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                <!-- Begin card shadow mb-4  -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Fale conosco</h6>
                    </div>

                    <!-- Begin Form Chamado -->
                    <div class="card-body">
                        <form class="called-form" action="ajuda.php" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="tipochamado">Tipo de Chamado</label>
                                    <select class="form-control" name="tipochamado" id="tipochamado" required>
                                        <option value="" selected>Escolha uma opção</option>
                                        <option value="D">Duvida</option>
                                        <option value="P">Problema</option>
                                        <option value="S">Sugestão</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="descricao">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" maxlength="2000" required></textarea>
                                </div>
                            </div>

                            <!-- INÍCIO BOTÃO ENVIAR -->
                            <div class="form-group">
                                <div class="textalign-right">
                                    <button type="submit" name="enviar_chamado" class="btn btn-organograma"><i class="fas fa-upload"></i> Enviar</button>
                                </div>
                            </div>
                            <!-- FIM BOTÃO ENVIAR -->
                        </form>
                    </div><!-- End Form Chamado -->


                </div><!-- End card shadow mb-4  -->
            </div><!-- End Page Content -->
        </div>

        <!-- Footer -->
        <?php

        include_once "footer.php"

        ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php

if (isset($_REQUEST['enviar_chamado'])) {
    try {

        $tipochamado = $_POST["tipochamado"];
        $chamado = $_POST["descricao"];
        $chamado = mb_strtoupper($chamado, 'UTF-8');
        $today = date('Y-m-d H:i:s');
        $status = 'A';
        $id_usa = $_SESSION['id_usa'];

        switch ($tipochamado) {

            case ('D'):
                $tipochamado_email = 'Duvida';
                break;
            case ('P'):
                $tipochamado_email = 'Problema';
                break;
            case ('S'):
                $tipochamado_email = 'Sugestão';
                break;
        }

        foreach (selectGESUSA_ajuda($id_usa_default) as $ajuda_email) {
            $nome_email_ajuda = $ajuda_email["nome"];
            $email_email_ajuda = $ajuda_email["email"];
            $empresa_email_ajuda = $ajuda_email["nome_empresa"];
            $cnpj_email_ajuda = $ajuda_email["cnpj_empresa"];
        }

        try {

            $insert_GESCHA = insertGESCHA($id_emp_default, $status, $today, $tipochamado);

            $id_cha = $insert_GESCHA['pk'];
        } catch (PDOException $erro) {

            die(($_SESSION['erro_importação'] = '0 - ' . $erro) . (header('Location: erro/erro_1')));
        }

        try {

            insertGESCHI($chamado, $id_cha, NULL, $id_usa, $today);
        } catch (PDOException $erro) {

            die(($_SESSION['erro_importação'] = '1 - ' . $erro) . (header('Location: erro/erro_1')));
        }


        require "email_ajuda.php";

        echo "<script language=javascript> 
        Swal.fire({
            icon: 'success',
            title: 'Enviado com sucesso!'
        }).then((result) => {
            if (result.isConfirmed) {
              location.href='ajuda';
            }
          })
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

?>