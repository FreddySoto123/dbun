<?php
require_once BASE_PATH . '/Model/UsuarioModel.php';
require_once BASE_PATH . '/Model/CitaModel.php';
require_once BASE_PATH . '/Model/HorarioModel.php';
require_once BASE_PATH . '/libs/tcpdf/tcpdf.php';
require_once BASE_PATH . '/libs/phpspreadsheet/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// ================================================================
class DashboardController {
    private $usuarioModel;
    private $citaModel;
    private $horarioModel;
   public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login');
            exit();
        }
        if ($_SESSION['user_role'] != 3) {
            header('Location: ' . BASE_URL . '/index.php?controller=Login&error=access_denied');
            exit();
        }
        $this->usuarioModel = new UsuarioModel();
        $this->citaModel = new CitaModel();
        $this->horarioModel = new HorarioModel();
    }public function index() {
        $totalUsuarios = $this->usuarioModel->count();
        $totalCitas = $this->citaModel->count();
        $totalHorarios = $this->horarioModel->count();
        $ultimasCitas = $this->citaModel->getLatest(5);
        $citasPorTipo = $this->citaModel->getCitasPorTipo();
        $usuariosPorTipo = $this->usuarioModel->getUsuariosPorTipo();
        $promedioCitasPorEstudiante = $this->citaModel->getPromedioCitasPorEstudiante();
        $pageTitle = "Dashboard";
        $activePage = "dashboard";
        require BASE_PATH . '/View/templates/header.php';
        require BASE_PATH . '/View/dashboard/index.php';
        require BASE_PATH . '/View/templates/footer.php';
    }    public function exportarPDF() {
        $citas = $this->citaModel->getAll();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Sistema DBUN');
        $pdf->SetTitle('Reporte de Citas');
        $pdf->SetSubject('Listado de Últimas Citas Reservadas');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 15, 'Reporte de Citas Reservadas', 0, true, 'C', 0, '', 0, false, 'M', 'M');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(45, 7, 'Fecha y Hora', 1);
        $pdf->Cell(60, 7, 'Estudiante', 1);
        $pdf->Cell(35, 7, 'Tipo de Consulta', 1);
        $pdf->Cell(30, 7, 'Estado', 1);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 9);
        foreach ($citas as $cita) {
            $nombreCompleto = trim(($cita['estudiante_nombre'] ?? '') . ' ' . ($cita['estudiante_apellido'] ?? ''));
            $pdf->Cell(45, 6, $cita['FechaCita'] . ' ' . $cita['HoraCita'], 1);
            $pdf->Cell(60, 6, $nombreCompleto, 1);
            $pdf->Cell(35, 6, $cita['TipoConsulta'], 1);
            $pdf->Cell(30, 6, $cita['Estado'], 1);
            $pdf->Ln();
        }
        $pdf->Output('reporte_citas.pdf', 'D');
        exit();
    }    public function exportarExcel() {
        $citas = $this->citaModel->getAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Citas Reservadas');
        $sheet->setCellValue('A1', 'Fecha y Hora');
        $sheet->setCellValue('B1', 'Estudiante');
        $sheet->setCellValue('C1', 'Profesional');
        $sheet->setCellValue('D1', 'Tipo de Consulta');
        $sheet->setCellValue('E1', 'Estado');
        $row = 2;
        foreach ($citas as $cita) {
            $nombreEstudiante = trim(($cita['estudiante_nombre'] ?? '') . ' ' . ($cita['estudiante_apellido'] ?? ''));
            $nombreProfesional = trim(($cita['profesional_nombre'] ?? '') . ' ' . ($cita['profesional_apellido'] ?? ''));

            $sheet->setCellValue('A' . $row, $cita['FechaCita'] . ' ' . $cita['HoraCita']);
            $sheet->setCellValue('B' . $row, $nombreEstudiante);
            $sheet->setCellValue('C' . $row, $nombreProfesional);
            $sheet->setCellValue('D' . $row, $cita['TipoConsulta']);
            $sheet->setCellValue('E' . $row, $cita['Estado']);
            $row++;
        }
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="reporte_citas.xlsx"');
         header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}