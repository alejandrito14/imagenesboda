<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boda - Sube tus fotos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style2.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa; /* Fondo general para consistencia */
        }

        .hero-section {
            position: relative;
            background-image: url('imagenes/boda2.jpg');
            background-size: cover;
            background-position: center;
            height:70vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            text-align: right;
            padding: 2rem;
            flex-direction: column;
            color: white; /* Para que el texto sea visible */
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1); /* Sombra sutil para mejorar la legibilidad */
        }
        
        /* Estilos de la barra de navegación */
        .navbar-nav .nav-link {
            font-size: 1rem;
            color: #333 !important;
            padding-bottom: 0.25rem;
            position: relative;
        }
        .navbar-nav .nav-link:hover { opacity: 0.7; }
        .navbar-nav .nav-link.active { font-weight: bold; }
        .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: black;
        }

        /* Estilos del botón de RSVP */
        .cta-container {
            position: absolute;
            bottom: 2rem;
            right: 2rem;
        }
        .cta-container .btn {
            background-color: transparent;
            border: 1px solid white;
            color: white;
            padding: 0.5rem 1.5rem;
            font-weight: bold;
        }

        /* Estilos para la sección de subida de fotos */
        .upload-section {
            padding: 4rem 1rem;
        }
        
        .left-panel {
            background-color: #18a0dbff; /* Color de fondo del panel izquierdo */
            color: white;
            padding: 2rem;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }
        .right-panel {
            background-color: white;
            padding: 2rem;
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        @media (max-width: 767.98px) {
            .left-panel, .right-panel {
                border-radius: 0.5rem !important; /* Bordes redondeados en móviles */
            }
            .left-panel {
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }
            .right-panel {
                border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
            }
        }
        
        .file-drop-area {
            border: 2px dashed #ccc;
            cursor: pointer;
            transition: border-color .3s ease;
        }
        .file-drop-area:hover {
            border-color: #007bff;
        }
        
        /* Estilos del modal para ver fotos */
        #modalImage {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }
        .navbar-nav,.btn,.labeltext{

  font-family: 'Playfair Display', serif;

        }
        .historia-section,.galeria-section,.asistencia-section{

        
            height: 70vh;
         
            
        }
    </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item me-md-4">
                        <a class="nav-link active" data-target="home" aria-current="page" href="#">HOME</a>
                    </li>
                    <li class="nav-item me-md-4">
                        <a class="nav-link" data-target="historia" href="#">NUESTRA HISTORIA</a>
                    </li>
                  <!--  <li class="nav-item me-md-4">
                        <a class="nav-link" data-target="galeria" href="#">GALERÍA</a>
                    </li>-->
                    <li class="nav-item me-md-4">
                        <a class="nav-link" data-target="asistencia" href="#">ASISTENCIA</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div id="home" class="content-section">
            <div class="hero-section">
                <div class="cta-container">
                    <button class="btn" id="rsvpBtn" data-target-section="asistencia">CONFIRMAR ASISTENCIA</button>
                </div>
            </div>
        </div>

       <div id="historia" class="historia-section content-section" style="display:none;">
    <div class="book-container">
        <div class="page page-left">
            <h2 class="book-title">Nuestra Historia</h2>
            <p>
                [Texto de la historia, primera parte...]
            </p>
            <p>
                [Continuación del texto...]
            </p>
        </div>
        <div class="page page-right">
            <img src="ruta/a/tu/imagen.jpg" alt="Descripción de la imagen" class="book-image">
            <p class="image-caption">
                [Aquí puedes agregar un texto que describa la imagen o una cita.]
            </p>
        </div>
    </div>
</div>

        <div id="galeria" class="galeria-section content-section" style="display:none;">
            <h2>Galería</h2>
            <p>El contenido de tu galería, que se oculta al inicio.</p>
        </div>
<div id="asistencia" class="content-section" style="display:none;">
    <div class="asistencia-container container my-5">
        <div class="row align-items-center">
            
            <div class="col-md-6 p-4">
                <h2 class="mb-4 labeltext">Confirma tu Asistencia</h2>
                <p class="text-muted labeltext">Ingresa tu código  y apellidos tal como aparecen en tu invitación.</p>
                
                <form>
                    <div class="mb-3">
                        <label for="reserva" class="form-label labeltext">Código</label>
                        <input type="text" class="form-control" id="reserva" name="reserva">
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label labeltext">Apellidos (como aparecen en tu confirmación)</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mt-4">Confirmar asistencia</button>
                </form>
            </div>
            
            <div class="col-md-6 p-0 image-column position-relative">
                <img src="imagenes/boda4.jpg" alt="Imagen de la boda" class="img-fluid h-100 w-100 object-fit-cover">
                
                <div class="detalles-overlay p-4">
                    <h3 class="mb-3 labeltext">Aquí puedes:</h3>
                    <ul class="list-unstyled labeltext">
                        <li><i class="bi bi-circle-fill me-2"></i>Ver los detalles del evento</li>
                        <li><i class="bi bi-circle-fill me-2"></i>Consultar tu pase</li>
                        <li><i class="bi bi-circle-fill me-2"></i>Ver la descripción del lugar</li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
    </main>

    <div class="container upload-section">
        <div class="card p-0 shadow-lg rounded-3">
            <div class="row g-0">
                <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center left-panel">
                    <img src="imagenes/boda3.jpg" alt="Anillos de Boda" class="img-fluid mb-4 rounded-3" style="width:80%">
                    <h1 class="text-white fw-bold labeltext">BODA</h1>
                    <p class="text-white labeltext">Diviértete conmigo compartiendo los momentos más icónicos en nuestra boda.</p>
                </div>
                <div class="col-md-6 p-4 right-panel">
                    <h4 class="text-center mb-4 labeltext">Sube tus fotos</h4>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="uploaderName" class="form-label labeltext">Tomadas por</label>
                            <input type="text" class="form-control" id="uploaderName" name="uploaderName" required>
                        </div>
                        <div class="mb-3">
                            <label for="fileInput" class="form-label labeltext">Arrastrar o subir archivos (máx. 10)</label>
                            <div class="border p-5 text-center file-drop-area position-relative">
                                <p class="mb-0 labeltext">Arrastra y suelta aquí o haz clic para seleccionar</p>
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
        <h2 class="text-center mb-4 labeltext">Últimas fotos agregadas</h2>
        <div id="photoSlider" class="row justify-content-center g-4">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <img src="https://images.unsplash.com/photo-1549440621-3e0e7a2569e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400" class="img-fluid rounded-3 shadow-sm" alt="Foto de Boda" data-bs-toggle="modal" data-bs-target="#photoModal">
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <img src="https://images.unsplash.com/photo-1522045437815-5e609341492b?w=400&auto=format&fit=crop" class="img-fluid rounded-3 shadow-sm" alt="Foto de Boda" data-bs-toggle="modal" data-bs-target="#photoModal">
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <img src="https://images.unsplash.com/photo-1638666579290-7d721111663b?w=400&auto=format&fit=crop" class="img-fluid rounded-3 shadow-sm" alt="Foto de Boda" data-bs-toggle="modal" data-bs-target="#photoModal">
            </div>
        </div>

        <div class="text-center mt-4">
            <button id="showAllPhotosBtn" class="btn btn-primary" style="background-color: transparent;
    border: 1px solid black;
    color: black;
    padding: 0.5rem 1.5rem;
    font-weight: bold;">Ver Todas las Fotos</button>
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
                        <div class="col-md-8 d-flex align-items-center justify-content-center  p-3">
                            <img id="modalImage" src="" alt="Imagen ampliada">
                        </div>
                        
                        <div class="col-md-4 p-4">
                            <h5 class="modal-title" id="photoModalLabel">Foto de <span id="photoUploader"></span></h5>
                            <hr>
                            <div id="commentsSection" class="mt-3 overflow-auto" style="max-height: 300px;">
                                <p>No hay comentarios.</p>
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
    <script>    
        // Código JavaScript para la funcionalidad de los botones
        $(document).ready(function(){
            // Interacción con jQuery para el botón de subir fotos
            $("#uploadBtn").click(function(){
                alert("¡El botón de subir fotos funciona!");
            });
            // Interacción con jQuery para el botón RSVP
            $("#rsvpBtn").click(function(){
                alert("¡El botón RSVP funciona!");
            });
            // Interacción con el botón "Ver Todos"
            $("#showAllPhotosBtn").click(function(){
            });
        });
    </script>
        <script src="script.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const contentSections = document.querySelectorAll('.content-section');
    const rsvpBtn = document.getElementById('rsvpBtn');

    function showSection(id) {
        contentSections.forEach(section => {
            section.style.display = 'none';
        });
        document.getElementById(id).style.display = 'block';
    }

    // Maneja los clics en los enlaces de la navegación
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
            
            const targetId = this.getAttribute('data-target');
            showSection(targetId);
        });
    });

    // Maneja el clic en el botón de "CONFIRMAR ASISTENCIA"
    if (rsvpBtn) {
        rsvpBtn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target-section');
            showSection(targetId);
            
            // Opcional: Actualiza la clase 'active' en el nav-item
            navLinks.forEach(item => item.classList.remove('active'));
            document.querySelector(`[data-target="${targetId}"]`).classList.add('active');
        });
    }

    // Muestra la sección 'home' por defecto al cargar la página
    showSection('home');
});
        </script>

</body>
</html>