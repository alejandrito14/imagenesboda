<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boda - Sube tus fotos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center background-image">
        <div class="card p-4 shadow-lg rounded-3">
            <div class="row">
                <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5 left-panel">
                    <img src="imagenes/boda1.jpg" alt="Anillos de Boda" class="img-fluid mb-4" style="width:100%">
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


    <div class="container mt-5">
    <h2 class="text-center mb-4">Ultimas fotos agregadas</h2>
    <div id="photoSlider" class="row justify-content-center">
    </div>

         <div class="text-center mt-3">
        <button id="showAllPhotosBtn" class="btn btn-primary">Ver Todos</button>
    </div>
</div>
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-8 d-flex align-items-center justify-content-center bg-dark">
                        <img id="modalImage" src="" class="img-fluid" style="width: 600px; height: 600px; object-fit: contain;" alt="Imagen ampliada">
                    </div>
                    
                    <div class="col-md-4 p-4">
                        <h5 class="modal-title" id="photoModalLabel">Foto de <span id="photoUploader"></span></h5>
                        <hr>
                        <div id="commentsSection" class="mt-3 overflow-auto" style="max-height: 300px;">
                            </div>
                        <hr>
                        <form id="commentForm" class="mt-3">
                            <input type="hidden" id="photoIdInput" name="photoId">
                            <div class="mb-3">
                                <input type="text" id="commenterName" class="form-control" placeholder="Tu nombre" required>
                            </div>
                            <div class="mb-3">
                                <textarea id="commentText" class="form-control" rows="2" placeholder="Escribe un comentario..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary w-100">Comentar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>