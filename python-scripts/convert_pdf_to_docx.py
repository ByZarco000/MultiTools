import sys
import aspose.words as aw

def convert_pdf(pdf_path, output_path, output_format):
    # Cargar el documento PDF
    doc = aw.Document(pdf_path)

    # Determinar el formato de salida según el valor recibido (en minúsculas)
    fmt = output_format.lower()

    if fmt == "docx":
        save_format = aw.SaveFormat.DOCX
    elif fmt == "doc":
        save_format = aw.SaveFormat.DOC
    elif fmt == "dotx":
        save_format = aw.SaveFormat.DOTX
    elif fmt == "dot":
        save_format = aw.SaveFormat.DOT
    elif fmt == "odt":
        save_format = aw.SaveFormat.ODT
    elif fmt == "ott":
        save_format = aw.SaveFormat.OTT
    elif fmt == "rtf":
        save_format = aw.SaveFormat.RTF
    elif fmt == "txt":
        save_format = aw.SaveFormat.TEXT
    elif fmt == "html":
        save_format = aw.SaveFormat.HTML
    elif fmt == "mhtml":
        save_format = aw.SaveFormat.MHTML
    elif fmt == "xml":
        # Aspose.Words utiliza el formato WORDML para XML
        save_format = aw.SaveFormat.WORDML
    elif fmt == "epub":
        save_format = aw.SaveFormat.EPUB
    elif fmt == "xps":
        save_format = aw.SaveFormat.XPS
    elif fmt == "svg":
        save_format = aw.SaveFormat.SVG
    elif fmt == "jpeg":
        save_format = aw.SaveFormat.JPEG
    elif fmt == "png":
        save_format = aw.SaveFormat.PNG
    elif fmt == "bmp":
        save_format = aw.SaveFormat.BMP
    elif fmt == "tiff":
        save_format = aw.SaveFormat.TIFF
    elif fmt == "gif":
        save_format = aw.SaveFormat.GIF
    elif fmt == "pdf":
        save_format = aw.SaveFormat.PDF
    else:
        print("Formato no soportado: {}".format(output_format))
        sys.exit(1)

    # Guardar el documento en el formato deseado
    doc.save(output_path, save_format)

if __name__ == "__main__":
    if len(sys.argv) < 4:
        print("Uso: python convert_pdf_to_docx.py <ruta_pdf> <ruta_salida> <formato>")
        sys.exit(1)

    pdf_file = sys.argv[1]
    output_file = sys.argv[2]
    output_format = sys.argv[3]

    convert_pdf(pdf_file, output_file, output_format)
