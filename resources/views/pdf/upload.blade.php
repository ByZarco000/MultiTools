<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y Convertir PDF</title>

    <!-- Aquí usas tu archivo local de Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

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

        .file-input {
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ced4da;
        }

        .file-input:focus {
            border-color: #80bdff;
            outline: none;
        }

        .form-control-file {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .form-control-file:focus {
            border-color: #007bff;
        }

        .upload-icon {
            font-size: 20px;
            margin-right: 10px;
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

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="upload-icon bi bi-file-earmark-pdf"></i> Convertir a Word
                    </button>
                </div>
            </form>

            <!-- Spinner de carga -->
            <div class="spinner-container" id="spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Generando archivo...</p>
            </div>
        </div>

        <!-- Mensaje de éxito o error después de la conversión -->
        @if(session('status'))
            <div class="alert alert-{{ session('status')['type'] }} mt-3" role="alert">
                {{ session('status')['message'] }}
            </div>
        @endif
    </div>

    <!-- Bootstrap JS (Opcional, si necesitas funcionalidades como modals, tooltips, etc.) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Script para mostrar el spinner al hacer submit -->
    <script>
        document.getElementById("pdfForm").addEventListener("submit", function () {
            // Mostrar spinner
            document.getElementById("spinner").style.display = "block";

            // Deshabilitar el botón para evitar múltiples envíos
            document.querySelector("button[type='submit']").disabled = true;
        });
    </script>

</body>

</html>
