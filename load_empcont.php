<?php

require 'config.php';

$columns = ['Incrementable', 'CvePersonal', 'CtaBanco', 'CveContrato', 'TipoEmpleado', 'Inicio', 'Fin', 'UltDia', 'CodCategoria', 'PrimaVac', 'HrsMen', 'Nombre'];
$table = "frontempcont";

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

$sql = "SELECT " . implode(", ", $columns) . "
FROM  $table
$where ";
$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['Incrementable'] . '</td>';
        $html .= '<td>' . $row['CvePersonal'] . '</td>';
        $html .= '<td>' . $row['Nombre'] . '</td>';
        $html .= '<td>' . $row['CtaBanco'] . '</td>';
        $html .= '<td>' . $row['CveContrato'] . '</td>';
        $html .= '<td>' . $row['TipoEmpleado'] . '</td>';
        $html .= '<td>' . $row['Inicio'] . '</td>';
        $html .= '<td>' . $row['Fin'] . '</td>';
        $html .= '<td>' . $row['UltDia'] . '</td>';
        $html .= '<td>' . $row['CodCategoria'] . '</td>';
        $html .= '<td>' . $row['PrimaVac'] . '</td>';
        $html .= '<td>' . $row['HrsMen'] . '</td>';

        $Incrementable = $row['Incrementable'];
        $CvePersonal = $row['CvePersonal'];

        $html .= '<td>
        <a href="editar_empcont.php?Incrementable=' . $Incrementable . '"><img src="img/expedientes/editar.png" height="40" width="40" /></a>
        </td>';

        $html .= '<td><img src="img/expedientes/eliminar.png" height="40" width="40" title="Eliminar"></td>';
        $html .= '</td>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="11">Sin resultados</td>';
    $html .= '</td>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
