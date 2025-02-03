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
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}
    .card {
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
  
  /* Centrando el card */
  margin: 0 auto;  /* Centrado horizontal */
  max-width: 600px; /* Puedes ajustar el ancho máximo según lo necesites */
  width: 100%; /* Hace que el card ocupe el 100% del ancho disponible */
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
    /* Estilo para el input de archivo */
    .file-input-wrapper {
      display: inline-block;
      position: relative;
      overflow: hidden;
    }

    .form-control-file {
      opacity: 0; /* Ocultar el input original */
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }

    .file-input-button {
      -webkit-text-size-adjust: 100%;
      -webkit-font-smoothing: antialiased;
      direction: ltr;
      text-align: center;
      margin: 0;
      font: inherit;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 80px;
      min-width: 330px;
      box-sizing: border-box;
      padding: 24px 48px;
      font-weight: 500;
      font-size: 24px;
      background: #e5322d;
      line-height: 28px;
      vertical-align: middle;
      color: #fff!important;
      text-decoration: none;
      margin-bottom: 12px;
      transition: background-color .1s linear;
      border: 0;
      border-radius: 12px;
      box-shadow: 0 3px 6px 0 rgba(0,0,0,.14);
      order: 1;
      max-width: 60vw;
      position: relative;
      z-index: 1;
    }

    .file-input-button:hover {
      background-color: #d33a24;
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

        <!-- Campo para subir el archivo -->
        <div class="mb-3 file-input-wrapper">
          <input type="file" name="pdf_file" id="pdf_file" class="form-control-file" required>
          <label for="pdf_file" class="file-input-button" id="file-label">SUBIR ARCHIVO</label>
        </div>

        <div class="mb-3">
          <label for="output_format" class="form-label">Selecciona el formato de salida</label>
          <select name="output_format" id="output_format" class="form-select" required>
            <option value="" disabled selected>Seleccione un formato</option>
            <!-- Opciones de formatos -->
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

      <!-- Spinner de carga -->
      <div class="spinner-container" id="spinner">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p>Generando archivo...</p>
      </div>
    </div>

    <div id="alertContainer" class="mt-3"></div>
  </div>

  <!-- Bootstrap JS -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

  <!-- Script AJAX con Fetch API -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    // Actualizar el texto del label con el nombre del archivo cuando se selecciona
    $('#pdf_file').on('change', function() {
      var fileName = $(this).val().split('\\').pop();  // Obtener el nombre del archivo
      $('#file-label').text(fileName);  // Actualizar el texto del label
    });

    $(document).ready(function () {
      $("#pdfForm").on("submit", function (e) {
        e.preventDefault(); // Evita la recarga de la página
        let formData = new FormData(this);

        // Mostrar un spinner mientras se procesa
        $(".spinner-container").show();

        $.ajax({
          url: "{{ route('pdf.convert') }}",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Enviar el token CSRF
          },
          success: function (response) {
            $(".spinner-container").hide();

            if (response.success) {
              window.location.href = response.download_url; // Redirige a la descarga
            } else {
              alert("Error: " + response.message);
            }
          },
          error: function (xhr) {
            $(".spinner-container").hide();
            alert("Ha ocurrido un error: " + xhr.responseText);
          }
        });
      });
    });
  </script>

</body>

</html>
