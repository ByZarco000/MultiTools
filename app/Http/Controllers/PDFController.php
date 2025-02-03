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
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240',
            'output_format' => 'required|string|in:docx,doc,dotx,dot,odt,ott,rtf,txt,html,mhtml,xml,epub,xps,svg,jpeg,png,bmp,tiff,gif',
        ]);
    
        $pdfFile = $request->file('pdf_file');
        $outputFormat = $request->input('output_format');
    
        $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
        $pdfPath = $pdfFile->storeAs('pdfs', $pdfFileName, 'public');
        $pdfFilePath = storage_path('app/public/' . $pdfPath);
        $outputFileName = pathinfo($pdfFileName, PATHINFO_FILENAME) . '.' . $outputFormat;
        $outputDir = storage_path('app/public/converted/');
    
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }
    
        $outputFilePath = $outputDir . $outputFileName;
        $scriptPath = base_path('python-scripts/convert_pdf_to_docx.py');
    
        $process = new Process([
            'C:\\xampp\\htdocs\\MultiTools\\venv\\Scripts\\python.EXE',
            $scriptPath,
            $pdfFilePath,
            $outputFilePath,
            $outputFormat
        ]);
    
        try {
            $process->mustRun();
    
            if (file_exists($outputFilePath)) {
                unlink($pdfFilePath);
    
                return response()->json([
                    'success' => true,
                    'download_url' => asset('storage/converted/' . $outputFileName)
                ]);
            } else {
                unlink($pdfFilePath);
                return response()->json(['success' => false, 'message' => 'No se pudo convertir el archivo PDF.'], 500);
            }
        } catch (ProcessFailedException $exception) {
            unlink($pdfFilePath);
            return response()->json(['success' => false, 'message' => 'Error en la conversión: ' . $exception->getMessage()], 500);
        }
    }
    
    
}