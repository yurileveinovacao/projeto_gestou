<?php

//Faz a requisição da Sessão
// require 'util.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Create Account</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        // include_once 'menu_lateral.php';

        ?>

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index">
                <div class="sidebar-brand-icon">
                    <img src="../img/logo_gestou.png" height="40"></img>
                </div>
                <div class="sidebar-brand-text mx-3">
                    <div class="fonte-texto-gestou" style="font-size: 20px;">GESTOU</div><sup>Portal Admin</sup>
                </div>

            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index">
                    <i class="fas fa-home fa-1x"></i>
                    <span>Principal</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menus
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?php echo $target; ?>" aria-expanded="true" aria-controls="<?php echo $target; ?>">
                    <i class="<?php echo $icone; ?>"></i>
                    <span><?php echo $descri; ?></span>
                </a>
                <div id="<?php echo $target; ?>" class="collapse" aria-labelledby="headingEmpresa" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <a class="collapse-item" href="<?php echo $link; ?>"><?php echo $descri_item; ?></a>

                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php

                // include_once 'barra_superior.php';

                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create account</h6>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">

                                <h1 class="h3 mb-0 text-gray-800">Empresa</h1>

                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="razaosocial">Razão social</label>
                                        <input type="text" class="form-control" style="text-transform:uppercase" id="razaosocial" name="razaosocial" minlength="3" maxlength="255" required>
                                        <div class="invalid-feedback">
                                            Inválido! Min. 3 caracteres!
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cnpj">CNPJ</label>
                                        <input type="text" class="form-control" id="cnpj" attrname="cnpj" name="cnpj" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}">
                                        <div class="invalid-feedback">
                                            Inválido!
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="qtdcolaboradores">Quantidade de colaboradores</label>
                                        <input type="text" class="form-control" id="qtdcolaboradores" attrname="qtdcolaboradores" name="qtdcolaboradores">
                                    </div>
                                </div>

                                <h1 class="h3 mb-0 text-gray-800">Admin</h1>

                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" style="text-transform:uppercase" id="nome" name="nome" minlength="3" maxlength="255" required>
                                        <div class="invalid-feedback">
                                            Inválido! Min. 3 caracteres!
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cpf">CPF</label>
                                        <input type="text" class="form-control" id="cpf" attrname="cpf" name="cpf" pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" required>
                                        <div class="invalid-feedback">
                                            Inválido!
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="email">E-mail</label>
                                        <input type="text" class="form-control" id="email" attrname="email" name="email" required>
                                        <div class="invalid-feedback">
                                            Inválido!
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="telefone">Telefone</label>
                                        <input type="text" class="form-control" id="telefone" attrname="telefone" name="telefone" required>
                                        <div class="invalid-feedback">
                                            Inválido!
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="textalign-right">
                                        <button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-save mr-sm-2"></i> Salvar</button>
                                        <button type="button" id="add-form" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-plus mr-sm-2"></i> Coligada</button>
                                    </div>
                                </div>

                            </div>

                            <!-- HTML -->
                            <div id="form-container">

                                <!-- DataTales Example -->
                                <!-- <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Coligada 1</h6>
                                    </div>
                                    <div class="card-body">

                                        <div class="col-md-12">

                                            <h1 class="h3 mb-0 text-gray-800">Empresa</h1>

                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="razaosocial">Razão social</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="razaosocial" name="razaosocial" minlength="3" maxlength="255" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Min. 3 caracteres!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="cnpj">CNPJ</label>
                                                    <input type="text" class="form-control" id="cnpj" attrname="cnpj" name="cnpj" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}">
                                                    <div class="invalid-feedback">
                                                        Inválido!
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="qtdcolaboradores">Quantidade de colaboradores</label>
                                                    <input type="text" class="form-control" id="qtdcolaboradores" attrname="qtdcolaboradores" name="qtdcolaboradores">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> -->

                            </div>

                            <!-- DataTales Example -->
                            <!-- <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Coligada 2</h6>
                                </div>
                                <div class="card-body">

                                    <div class="col-md-12">

                                        <h1 class="h3 mb-0 text-gray-800">Empresa</h1>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="razaosocial">Razão social</label>
                                                <input type="text" class="form-control" style="text-transform:uppercase" id="razaosocial" name="razaosocial" minlength="3" maxlength="255" required>
                                                <div class="invalid-feedback">
                                                    Inválido! Min. 3 caracteres!
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="cnpj">CNPJ</label>
                                                <input type="text" class="form-control" id="cnpj" attrname="cnpj" name="cnpj" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}">
                                                <div class="invalid-feedback">
                                                    Inválido!
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="qtdcolaboradores">Quantidade de colaboradores</label>
                                                <input type="text" class="form-control" id="qtdcolaboradores" attrname="qtdcolaboradores" name="qtdcolaboradores">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> -->

                        </div>
                    </div>

                </div>
            </div>

            <!-- End of Main Content -->

            <!-- Footer -->
            <?php

            // include_once "footer.php"

            ?>
            <!-- End of Footer -->

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

</body>

</html>

<script>
    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA cnpj
    var cnpjMask = ['99.999.999/9999-99', '99.999.999/9999-99'];
    var cnpj = document.querySelector('input[id=cnpj]');
    VMasker(cnpj).maskPattern(cnpjMask[0]);
    cnpj.addEventListener('input', inputHandler.bind(undefined, cnpjMask, 18), false);

    // MÁSCARA TEL
    var telMask = ['(999) 99999-9999', '(999) 99999-9999'];
    var tel = document.querySelector('input[attrname=telefone]');
    VMasker(tel).maskPattern(telMask[0]);
    tel.addEventListener('input', inputHandler.bind(undefined, telMask, 16), false);

    // jQuery
    $(document).ready(function() {
        const formContainer = $("#form-container");
        let formCounter = 0;

        function criarFormulario(id) {
            const form = $(`
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Coligada ${id}</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12">

                        <h1 class="h3 mb-0 text-gray-800">Empresa</h1>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="razaosocial-${id}">Razão social</label>
                                <input type="text" class="form-control" style="text-transform:uppercase" id="razaosocial-${id}" name="razaosocial-${id}" minlength="3" maxlength="255" required>
                                <div class="invalid-feedback">
                                    Inválido! Min. 3 caracteres!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cnpj-${id}">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj-${id}" attrname="cnpj-${id}" name="cnpj-${id}" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}">
                                <div class="invalid-feedback">
                                    Inválido!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="qtdcolaboradores-${id}">Quantidade de colaboradores</label>
                                <input type="text" class="form-control" id="qtdcolaboradores-${id}" attrname="qtdcolaboradores-${id}" name="qtdcolaboradores-${id}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="textalign-right">
                                <button type="button" class="btn btn-organograma btn-icon-split-organograma remove-form"><i class="fas fa-trash mr-sm-2"></i> Excluir</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

    `);

            form.find(".remove-form").click(() => {
                form.remove();
            });

            return form;
        }

        $("#add-form").click(() => {
            formCounter++;
            const form = criarFormulario(formCounter);
            formContainer.append(form);

            // FUNÇÃO MÁSCARAS
            function inputHandler(masks, max, event) {
                var c = event.target;
                var v = c.value.replace(/\D/g, '');
                var m = c.value.length > max ? 1 : 0;
                VMasker(c).unMask();
                VMasker(c).maskPattern(masks[m]);
                c.value = VMasker.toPattern(v, masks[m]);
            }

            // MÁSCARA cnpjcoligada
            var cnpjcoligadaMask = ['99.999.999/9999-99', '99.999.999/9999-99'];
            var cnpjcoligada = document.querySelector('input[id=cnpj-' + formCounter + ']');
            VMasker(cnpjcoligada).maskPattern(cnpjcoligadaMask[0]);
            cnpjcoligada.addEventListener('input', inputHandler.bind(undefined, cnpjcoligadaMask, 18), false);

        });
    });
</script>