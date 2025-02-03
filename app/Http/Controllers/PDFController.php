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
        // Validar la entrada del formulario
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240', // máximo 10MB
            'output_format' => 'required|string|in:docx,doc,dotx,dot,odt,ott,rtf,txt,html,mhtml,xml,epub,xps,svg,jpeg,png,bmp,tiff,gif',
        ]);
    
        // Obtener el archivo y formato de salida
        $pdfFile = $request->file('pdf_file');
        $outputFormat = $request->input('output_format');
    
        // Generar nombres de archivos
        $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
        $pdfPath = $pdfFile->storeAs('pdfs', $pdfFileName, 'public');
    
        $pdfFilePath = storage_path('app/public/' . $pdfPath);
        $outputFileName = pathinfo($pdfFileName, PATHINFO_FILENAME) . '.' . $outputFormat;
        $outputDir = storage_path('app/public/converted/');
    
        // Asegurar que la carpeta "converted" exista
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
    
        $outputFilePath = $outputDir . $outputFileName;
    
        // Ruta al script Python
        $scriptPath = base_path('python-scripts/convert_pdf_to_docx.py');
    
        // Ejecutar el script Python con el formato de salida
        $process = new Process([
            'C:\\xampp\\htdocs\\MultiTools\\venv\\Scripts\\python.EXE',
            $scriptPath,
            $pdfFilePath,
            $outputFilePath,
            $outputFormat // Se envía el formato al script de Python
        ]);
    
        try {
            $process->mustRun();
    
            // Verificar si el archivo convertido existe
            if (file_exists($outputFilePath)) {
                unlink($pdfFilePath); // Eliminar el PDF original
    
                // Descargar el archivo convertido y eliminarlo después del envío
                return response()->download($outputFilePath)->deleteFileAfterSend(true);
            } else {
                unlink($pdfFilePath);
                return redirect()->back()->with('status', ['type' => 'danger', 'message' => 'No se pudo convertir el archivo PDF.']);
            }
        } catch (ProcessFailedException $exception) {
            unlink($pdfFilePath);
            return redirect()->back()->with('status', ['type' => 'danger', 'message' => 'Error en la conversión: ' . $exception->getMessage()]);
        }
    }
    
}