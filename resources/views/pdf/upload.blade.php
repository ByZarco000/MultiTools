<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y Convertir PDF</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            max-width: 600px;
        }

        .card {
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h2 {
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-control-file {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .form-control-file:focus {
            border-color: #007bff;
        }

        .alert {
            margin-top: 20px;
        }

        /* Estilo para el spinner */
        .spinner-container {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <h2 class="text-center mb-4">Subir y Convertir PDF</h2>
            <form id="pdfForm" action="{{ route('pdf.convert') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="pdf_file" class="form-label">Selecciona el archivo PDF</label>
                    <input type="file" name="pdf_file" id="pdf_file" class="form-control-file" required>
                </div>

                <div class="mb-3">
                    <label for="output_format" class="form-label">Selecciona el formato de salida</label>
                    <select name="output_format" id="output_format" class="form-select" required>
                        <option value="" disabled selected>Seleccione un formato</option>
                        <option value="docx">Word (DOCX)</option>
                        <option value="doc">Word 97-2003 (DOC)</option>
                        <option value="dotx">Plantilla de Word (DOTX)</option>
                        <option value="dot">Plantilla de Word 97-2003 (DOT)</option>
                        <option value="odt">OpenDocument Text (ODT)</option>
                        <option value="ott">Plantilla OpenDocument (OTT)</option>
                        <option value="rtf">Rich Text Format (RTF)</option>
                        <option value="txt">Texto plano (TXT)</option>
                        <option value="html">Página web (HTML)</option>
                        <option value="mhtml">Archivo web (MHTML)</option>
                        <option value="xml">Documento XML</option>
                        <option value="epub">Libro electrónico (EPUB)</option>
                        <option value="xps">Especificación de papel XML (XPS)</option>
                        <option value="svg">Gráficos vectoriales escalables (SVG)</option>
                        <option value="jpeg">Imagen JPEG</option>
                        <option value="png">Imagen PNG</option>
                        <option value="bmp">Imagen BMP</option>
                        <option value="tiff">Imagen TIFF</option>
                        <option value="gif">Imagen GIF</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-file-earmark-arrow-up"></i> Convertir PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>



</body>

</html>
