<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../img/logo.jpg', 10, 8, 60);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('BITACORA DE ATENCIÓN'), 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function GeneratePatientTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 12);
        $pageWidth = $this->GetPageWidth();
        $tableWidth = 0;
        $columnWidths = [20, 58, 58, 58]; // Anchura de las columnas

        // Calcular el ancho total de la tabla
        foreach ($columnWidths as $width) {
            $tableWidth += $width;
        }

        // Calcular la posición de inicio para centrar la tabla
        $startX = ($pageWidth - $tableWidth) / 2;

        // Mover a la posición de inicio
        $this->SetX($startX);

        // Dibujar los encabezados
        foreach ($header as $index => $col) {
            $this->Cell($columnWidths[$index], 7, $col, 1, 0, 'C');
        }
        $this->Ln();

        // Dibujar las filas de datos
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            $this->SetX($startX);
            $this->Cell($columnWidths[0], 6, $row['numero'], 1, 0, 'C');
            $this->Cell($columnWidths[1], 6, $row['nombre'], 1, 0, 'C');
            $this->Cell($columnWidths[2], 6, $row['apellidos'], 1, 0, 'C');
            $this->Cell($columnWidths[3], 6, $row['fecha'], 1, 0, 'C');
            $this->Ln();
        }
    }
}
?>
