import sys
import aspose.words as aw

def convert_pdf_to_docx(pdf_path, docx_path):
    doc = aw.Document(pdf_path)
    doc.save(docx_path)

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Uso: python script.py <ruta_pdf> <ruta_docx>")
        sys.exit(1)

    pdf_file = sys.argv[1]
    docx_file = sys.argv[2]

    convert_pdf_to_docx(pdf_file, docx_file)