
	<?php

    require "iuds_pdo.php";
    require "util.php";

    $data = array();

    foreach (select_GRELAT($id_emp_default) as $row) {
        $sub_data['id'] = $row['id_rel'];
        $sub_data['name'] = $row['nome'];
        $sub_data['parent_id'] = $row['parent_id'];
        $sub_data['href'] = $row['layout'];

        //QUANDO O PARENT_ID FOR DIFERENTE DE 0 O FILHO RECEBE O ID_REL
        if ($row['parent_id'] != 0) {

            //FILHO
            $sub_data['text'] = "<span id='codigo_rel'>" . $row["id_rel"] . "</span>" . " - " . $row['nome'] . "<input type='hidden' id='link_rel' value=" . $row["layout"] . "></input>";
        } else {

            //PAI
            $sub_data['text'] = $row['nome'];
        }
        $data[] = $sub_data;
    }
    foreach ($data as $key => &$value) {
        $output[$value["id"]] = &$value;
    }
    foreach ($data as $key => &$value) {
        if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
            $output[$value["parent_id"]]["nodes"][] = &$value;
        }
    }
    foreach ($data as $key => &$value) {
        if ($value["parent_id"] && isset($output[$value["parent_id"]])) {
            unset($data[$key]);
        }
    }

    $teste = array();
    $teste = array_merge($teste, $data);

    echo json_encode($teste);
    ?>
