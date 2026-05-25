<?php
// FEA-009 Fase 6 — Export XLSX mensal de RPAs pra contabilidade
// Layout baseado na planilha RPA.MARÇO.xlsx da Jéssica (TRYP/SE HOTEIS)

require '../restrito.php';
require_once "../iuds_pdo.php";
require_once "../util.php";
require '../vendor_phpspreadsheet/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$hoje = new DateTime('now');
$mes = isset($_GET['mes']) ? (int) $_GET['mes'] : (int) $hoje->format('m');
$ano = isset($_GET['ano']) ? (int) $_GET['ano'] : (int) $hoje->format('Y');

// Busca completa via SQL direto (precisa de mais campos que selectGESRPA_lista oferece)
global $pdo;
$sql = 'SELECT r.id_rpa, r.data_servico, r.hora_ini, r.hora_fim, r.diarias,
               r.valor_liquido, r.valor_bruto, r.justificativa, r.status,
               r.data_envio_fin, r.data_pgto,
               a.nome AS aut_nome, a.cpf AS aut_cpf, a.rg AS aut_rg, a.data_nasc AS aut_nasc,
               a.etnia AS aut_etnia, a.endereco AS aut_endereco, a.bairro AS aut_bairro,
               a.cidade AS aut_cidade, a.uf AS aut_uf,
               r.cargo, d.nome AS setor_nome
        FROM public."GESRPA" r
        INNER JOIN public."GESAUT" a ON a.id_aut = r.id_aut
        LEFT JOIN public."GESDEP" d  ON d.id_dep = r.id_dep
        WHERE r.id_emp =:id_emp
          AND date_part(\'month\', r.data_servico) =:mes
          AND date_part(\'year\', r.data_servico)  =:ano
        ORDER BY r.data_servico, r.id_rpa';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_emp' => $id_emp_default, ':mes' => $mes, ':ano' => $ano]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('RPAs ' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '-' . $ano);

// Cabeçalho (18 colunas conforme planilha original da Jéssica)
$cabecalho = [
    'Envio Financeiro', 'Data Início', 'Data Fim', 'Diárias', 'Valor Líquido', 'Valor c/ Imposto',
    'Horas', 'Nome', 'Cargo', 'Setor', 'Data Pgto', 'Justificativa', 'Assinado',
    'Endereço', 'CPF', 'RG', 'Nascimento', 'Etnia'
];
foreach ($cabecalho as $i => $titulo) {
    $col = chr(65 + $i); // A, B, C, ...
    $sheet->setCellValue($col . '1', $titulo);
}
$sheet->getStyle('A1:R1')->applyFromArray([
    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A73E8']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);
foreach (range('A', 'R') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Linhas
$linha = 2;
foreach ($rows as $r) {
    $cpf_fmt = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $r['aut_cpf']);
    $horas = '';
    if ($r['hora_ini'] && $r['hora_fim']) {
        $ini = strtotime($r['hora_ini']);
        $fim = strtotime($r['hora_fim']);
        if ($fim > $ini) {
            $diff = ($fim - $ini) / 3600;
            $horas = number_format($diff, 1, ',', '');
        }
    }
    $endereco_completo = trim(implode(', ', array_filter([
        $r['aut_endereco'], $r['aut_bairro'], $r['aut_cidade'], $r['aut_uf']
    ])));

    $sheet->setCellValue('A' . $linha, $r['data_envio_fin'] ? date('d/m/Y', strtotime($r['data_envio_fin'])) : '');
    $sheet->setCellValue('B' . $linha, date('d/m/Y', strtotime($r['data_servico'])));
    $sheet->setCellValue('C' . $linha, date('d/m/Y', strtotime($r['data_servico'])));
    $sheet->setCellValue('D' . $linha, (int) $r['diarias']);
    $sheet->setCellValueExplicit('E' . $linha, number_format($r['valor_liquido'], 2, ',', '.'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValueExplicit('F' . $linha, number_format($r['valor_bruto'], 2, ',', '.'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue('G' . $linha, $horas);
    $sheet->setCellValue('H' . $linha, $r['aut_nome']);
    $sheet->setCellValue('I' . $linha, $r['cargo'] ?? '');
    $sheet->setCellValue('J' . $linha, $r['setor_nome'] ?? '');
    $sheet->setCellValue('K' . $linha, $r['data_pgto'] ? date('d/m/Y', strtotime($r['data_pgto'])) : '');
    $sheet->setCellValue('L' . $linha, $r['justificativa'] ?? '');
    $sheet->setCellValue('M' . $linha, in_array($r['status'], ['assinado', 'enviado_fin', 'pago'], true) ? 'Sim' : 'Não');
    $sheet->setCellValue('N' . $linha, $endereco_completo);
    $sheet->setCellValue('O' . $linha, $cpf_fmt);
    $sheet->setCellValue('P' . $linha, $r['aut_rg'] ?? '');
    $sheet->setCellValue('Q' . $linha, $r['aut_nasc'] ? date('d/m/Y', strtotime($r['aut_nasc'])) : '');
    $sheet->setCellValue('R' . $linha, $r['aut_etnia'] ?? '');
    $linha++;
}

// Bordas
if (count($rows) > 0) {
    $sheet->getStyle('A1:R' . ($linha - 1))->applyFromArray([
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']],
        ],
    ]);
}

// Resumo no rodapé
$linha_resumo = $linha + 1;
$sheet->setCellValue('A' . $linha_resumo, 'RESUMO');
$sheet->setCellValue('A' . ($linha_resumo + 1), 'Total RPAs:');
$sheet->setCellValue('B' . ($linha_resumo + 1), count($rows));
$total_bruto = array_sum(array_column($rows, 'valor_bruto'));
$total_liquido = array_sum(array_column($rows, 'valor_liquido'));
$sheet->setCellValue('A' . ($linha_resumo + 2), 'Total Bruto:');
$sheet->setCellValueExplicit('B' . ($linha_resumo + 2), 'R$ ' . number_format($total_bruto, 2, ',', '.'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet->setCellValue('A' . ($linha_resumo + 3), 'Total Líquido:');
$sheet->setCellValueExplicit('B' . ($linha_resumo + 3), 'R$ ' . number_format($total_liquido, 2, ',', '.'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$sheet->getStyle('A' . $linha_resumo . ':B' . ($linha_resumo + 3))->getFont()->setBold(true);

// Filename
$meses_nome = [1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',
               7=>'Julho',8=>'Agosto',9=>'Setembro',10=>'Outubro',11=>'Novembro',12=>'Dezembro'];
$filename = 'RPAs_' . strtoupper($meses_nome[$mes]) . '_' . $ano . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
