<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ENT_ProductoController;
use Dompdf\Dompdf;

class PdfService {
    public function GenerarPDF(Request $request){
        $producto=isset($request->producto) ? $request->producto : 'Todos';
        $dateRange=$request->dateRange ? $request->dateRange : 'Sin filtro';
        
        $startDate = '';
        $endDate = '';

        $registros = app(ENT_ProductoController::class)->listarReportes();
        $registros = collect($registros);

        if($producto !== 'Todos'){
            $partes = explode('-', $producto);
            $productoid = trim(end($partes));

            $registros = $registros->filter(function ($registro) use ($productoid) {
                return $registro['id_producto'] == $productoid;
            })->values();
        }

        if ($dateRange !== 'Sin filtro') {
            list($startDate, $endDate) = explode(' - ', $dateRange);

            $registros = $registros->filter(function ($registro) use ($startDate, $endDate) {
                $fechaRegistro = $registro['fecha'];
                return $fechaRegistro >= $startDate && $fechaRegistro <= $endDate;
            })->values();
            
        }

        $tableRows = '';

        foreach ($registros as $registro) {
            $tableRows .= '<tr>';
            $tableRows .= '<td>' . htmlspecialchars($registro['id']) . '</td>';
            $tableRows .= '<td>' . htmlspecialchars($registro['tipo']) . '</td>';
            $tableRows .= '<td>' . htmlspecialchars($registro['nombre_producto']) . ' - '. $registro['id_producto'] .'</td>';
            $tableRows .= '<td>' . htmlspecialchars($registro['cantidad']) . '</td>';
            $tableRows .= '<td>' . date('d-m-Y', strtotime($registro['fecha'])) . '</td>';
            $tableRows .= '</tr>';
        }

        $html = "
            <h2>Reporte de Movimientos - SnowBox</h2>
            <p><strong>Producto:</strong> $producto</p>
            <p><strong>Rango de Fecha:</strong> $dateRange</p>
            <table border='1' width='100%' style='border-collapse: collapse;'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    $tableRows
                </tbody>
            </table>
            ";


        // Inicializar y generar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Descargar PDF
        $dompdf->stream("Reporte_SnowBox.pdf", array("Attachment" => true));
    }
}