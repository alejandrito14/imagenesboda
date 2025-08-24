<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boda - Sube tus fotos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos CSS personalizados (los he movido aquí para que no necesites un archivo style.css) */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .container-fluid {
            background-color: #f8f9fa;
        }
        .left-panel {
            background-color: #5d9cec; /* Un color más vibrante, puedes ajustarlo */
            color: white;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
            padding: 2rem;
        }
        .right-panel {
            background-color: white;
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            padding: 2rem;
        }
        .card {
            max-width: 900px;
        }
        .file-drop-area {
            border: 2px dashed #ccc;
            transition: border-color 0.3s ease;
        }
        .file-drop-area:hover, .file-drop-area.drag-over {
            border-color: #007bff;
        }
        .file-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid #eee;
        }
        .file-list-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-0 shadow-lg rounded-3">
            <div class="row g-0">
                <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5 left-panel">
                    <img src="https://via.placeholder.com/400x400.png?text=Anillos+de+Boda" alt="Anillos de Boda" class="img-fluid mb-4" style="width:100%">
                    <h1 class="text-white fw-bold">BODA</h1>
                    <p class="text-white">Diviértete conmigo compartiendo los momentos más icónicos en nuestra boda.</p>
                </div>
                <div class="col-md-6 p-4 right-panel">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="uploaderName" class="form-label">Tomadas por</label>
                            <input type="text" class="form-control" id="uploaderName" name="uploaderName" required>
                        </div>
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Arrastrar o subir archivos (máx. 10)</label>
                            <div class="border p-5 text-center file-drop-area position-relative">
                                <p class="mb-0">Arrastra y suelta aquí o haz clic para seleccionar</p>
                                <input type="file" id="fileInput" name="photos[]" multiple accept="image/*" class="w-100 h-100 opacity-0 position-absolute top-0 start-0 cursor-pointer">
                            </div>
                        </div>
                        <div id="fileList" class="mb-3"></div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success" id="submitBtn">Guardar</button>
                        </div>
                    </form>
                    <div id="statusMessage" class="mt-3 text-center"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
    <script>
        $(document).ready(function() {
            const dropArea = $('.file-drop-area');
            const fileInput = $('#fileInput');
            const fileList = $('#fileList');
            const maxFiles = 10;
            let filesToUpload = new DataTransfer();

            // Función para mostrar los archivos seleccionados
            function updateFileList() {
                fileList.empty();
                for (const file of filesToUpload.files) {
                    fileList.append(
                        `<div class="file-list-item">
                            <span>${file.name}</span>
                            <button type="button" class="btn-close" aria-label="Eliminar" data-file-name="${file.name}"></button>
                        </div>`
                    );
                }
            }

            // Manejar el evento de clic en el input (funcionalidad normal)
            fileInput.on('change', function() {
                const newFiles = this.files;
                if ((filesToUpload.files.length + newFiles.length) > maxFiles) {
                    alert(`Solo puedes subir un máximo de ${maxFiles} archivos.`);
                    return;
                }
                for (const file of newFiles) {
                    filesToUpload.items.add(file);
                }
                updateFileList();
                this.files = filesToUpload.files; // Asignar la lista combinada al input
            });

            // Eliminar archivo de la lista
            fileList.on('click', '.btn-close', function() {
                const fileNameToRemove = $(this).data('file-name');
                const newFilesDataTransfer = new DataTransfer();
                for (let i = 0; i < filesToUpload.files.length; i++) {
                    if (filesToUpload.files[i].name !== fileNameToRemove) {
                        newFilesDataTransfer.items.add(filesToUpload.files[i]);
                    }
                }
                filesToUpload = newFilesDataTransfer;
                updateFileList();
                fileInput[0].files = filesToUpload.files; // Actualizar el input
            });

            // Eventos para el "arrastrar y soltar"
            dropArea.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('drag-over');
            });

            dropArea.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('drag-over');
            });

            dropArea.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('drag-over');
                const droppedFiles = e.originalEvent.dataTransfer.files;

                if ((filesToUpload.files.length + droppedFiles.length) > maxFiles) {
                    alert(`Solo puedes subir un máximo de ${maxFiles} archivos.`);
                    return;
                }
                for (const file of droppedFiles) {
                    filesToUpload.items.add(file);
                }
                updateFileList();
                fileInput[0].files = filesToUpload.files; // Asignar la lista combinada al input
            });

            // Opcional: Manejar el envío del formulario (aquí podrías usar AJAX)
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                // Aquí iría el código para enviar los archivos y el nombre del usuario al servidor
                alert('Formulario enviado. Se subieron ' + filesToUpload.files.length + ' archivos.');
                // Ejemplo de cómo obtener los datos:
                const formData = new FormData(this);
                console.log(formData.get('uploaderName'));
                console.log(formData.getAll('photos[]'));
                // Para vaciar la lista después de subir:
                filesToUpload = new DataTransfer();
                updateFileList();
                fileInput[0].files = filesToUpload.files;
            });
        });
    </script>
</body>
</html>