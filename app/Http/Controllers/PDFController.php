<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function index()
    {
        // Muestra la vista para subir el archivo PDF
        return view('pdf.upload');
    }

    public function convert(Request $request)
    {
        // Validar que el archivo se haya subido correctamente
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240', // máximo 10MB
        ]);

        // Obtener el archivo subido
        $pdfFile = $request->file('pdf_file');
        $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();

        // Guardar el archivo PDF en el almacenamiento
        $pdfPath = $pdfFile->storeAs('pdfs', $pdfFileName, 'public');

        // Ruta completa del archivo PDF
        $pdfFilePath = storage_path('app/public/' . $pdfPath);

        // Ruta donde se guardará el archivo Word convertido
        $outputFileName = pathinfo($pdfFileName, PATHINFO_FILENAME) . '.docx';
        $outputFilePath = storage_path('app/public/converted/' . $outputFileName);

        // Ruta al script Python
        $scriptPath = base_path('python-scripts/convert_pdf_to_docx.py');

        // Ejecutar el script Python para convertir el PDF a Word
        $process = new Process([
            'C:\\xampp\\htdocs\\MultiTools\\venv\\Scripts\\python.EXE',
            $scriptPath,
            $pdfFilePath,
            $outputFilePath,
        ]);

        try {
            $process->mustRun(); // Ejecutar el proceso y esperar que termine

            // Verificar si el archivo de salida existe
            if (file_exists($outputFilePath)) {
                // Eliminar el archivo PDF original después de la conversión
                unlink($pdfFilePath);

                // Devolver el archivo convertido como descarga automática
                return response()->download($outputFilePath)->deleteFileAfterSend(true);
            } else {
                // En caso de error, eliminar el archivo PDF si no fue convertido
                unlink($pdfFilePath);
                return response()->json(['error' => 'No se pudo convertir el archivo PDF.'], 500);
            }
        } catch (ProcessFailedException $exception) {
            // Si ocurre un error durante la ejecución del proceso
            unlink($pdfFilePath);  // Eliminar el archivo PDF en caso de error
            return response()->json(['error' => 'Error al ejecutar el proceso de conversión.'], 500);
        }
    }
}