$(document).ready(function() {
    const fileDropArea = $('.file-drop-area');
    const fileInput = $('#fileInput');
    const fileList = $('#fileList');
    const uploadForm = $('#uploadForm');
    const submitBtn = $('#submitBtn');
    const statusMessage = $('#statusMessage');
    let filesToUpload = [];
const showAllPhotosBtn = $('#showAllPhotosBtn');

    showAllPhotosBtn.on('click', function() {
    loadPhotos(0); // Llama a la función para cargar todas las fotos
    $(this).hide(); // Oculta el botón
});

    // Prevenir el comportamiento por defecto de arrastrar y soltar
    $(document).on('dragenter dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $(document).on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Cambiar estilos al arrastrar archivos sobre el área
    fileDropArea.on('dragenter', function(e) {
        $(this).addClass('bg-light');
    });

    fileDropArea.on('dragleave', function(e) {
        $(this).removeClass('bg-light');
    });

    // Manejar archivos soltados
    fileDropArea.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('bg-light');
        const files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
    });

    // Manejar clic en el área para abrir el explorador de archivos
fileDropArea.on('click', function(e) {
    // Impedir que el evento de clic del "drop area" se propague a otros elementos
    e.stopPropagation(); 
    // Simular el clic en el input de tipo 'file'
    fileInput.trigger('click');
});

    // Manejar archivos seleccionados con el input
    fileInput.on('change', function() {
        handleFiles(this.files);
    });

   function handleFiles(files) {
    // Limitar a 10 imágenes
    if (filesToUpload.length + files.length > 10) {
        statusMessage.html('<div class="alert alert-danger">Solo se permiten 10 imágenes como máximo.</div>');
        return;
    }

    for (const file of files) {
        filesToUpload.push(file);
        const reader = new FileReader();
        reader.onload = function(e) {
            // Crea un contenedor para la imagen y el botón
            const thumbnailContainer = $('<div>').addClass('preview-thumbnail-container');
            
            // Crea la miniatura de la imagen
            const img = $('<img>').attr('src', e.target.result).addClass('preview-thumbnail');
            
            // Crea el botón de borrado
            const deleteButton = $('<span>').addClass('delete-button').html('&times;');
            
            // Asigna el evento de clic al botón de borrado
            deleteButton.on('click', function() {
                // Encuentra el índice del archivo en el array
                const index = filesToUpload.indexOf(file);
                if (index > -1) {
                    filesToUpload.splice(index, 1); // Elimina el archivo del array
                }
                $(this).parent().remove(); // Elimina el contenedor de la miniatura
            });

            // Agrega la imagen y el botón al contenedor
            thumbnailContainer.append(img);
            thumbnailContainer.append(deleteButton);
            
            // Agrega el contenedor completo a la lista de archivos
            fileList.append(thumbnailContainer);
        };
        reader.readAsDataURL(file);
    }
}


     function loadPhotos(limit) {
        $.ajax({
        url: 'get_photos.php?limit=' + limit, // Usar el parámetro
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const slider = $('#photoSlider');
                slider.empty(); // Limpiar slider antes de agregar nuevas fotos
                if (response.photos && response.photos.length > 0) {
                    response.photos.forEach(photo => {
                        const photoUrl = 'uploads/' + photo.nombre_archivo;
                       const photoCard = `
    <div class="col-6 col-md-3 mb-4 d-flex justify-content-center">
        <img src="${photoUrl}" class="img-thumbnail rounded shadow-sm" alt="Foto subida" data-uploader="${photo.nombre_subida}" data-id="${photo.id}" style="cursor:pointer; width: 100%; height: auto; aspect-ratio: 1 / 1; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#photoModal">
    </div>
`;
                        slider.append(photoCard);
                    });
                }
            }
        });
    }

    // Llama a la función al cargar la página
loadPhotos(4);

    // Manejar el envío del formulario con AJAX
    uploadForm.on('submit', function(e) {
        e.preventDefault();

        const uploaderName = $('#uploaderName').val();

        if (uploaderName.trim() === '') {
            statusMessage.html('<div class="alert alert-warning">Por favor, escribe tu nombre.</div>');
            return;
        }

        if (filesToUpload.length === 0) {
            statusMessage.html('<div class="alert alert-warning">Por favor, selecciona al menos una imagen.</div>');
            return;
        }

        const formData = new FormData();
        formData.append('uploaderName', uploaderName);

        filesToUpload.forEach((file, index) => {
            formData.append('photos[]', file);
        });

        // Mostrar animación de carga
        submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');
        submitBtn.prop('disabled', true);

        // Envío AJAX
        $.ajax({
            url: 'upload.php', // El script de PHP que procesará la subida
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                statusMessage.html('<div class="alert alert-success">' + response + '</div>');
                // Limpiar formulario y miniaturas
                uploadForm[0].reset();
                fileList.empty();
                filesToUpload = [];
            },
            error: function(jqXHR, textStatus, errorThrown) {
                statusMessage.html('<div class="alert alert-danger">Ocurrió un error al guardar.</div>');
            },
            complete: function() {
                submitBtn.html('Guardar');
                submitBtn.prop('disabled', false);
            }
        });
    });




});


// ... (Tu código actual, incluyendo loadPhotos) ...

// Manejar el evento de apertura del modal
$('#photoModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const imageUrl = button.attr('src');
    const uploaderName = button.data('uploader');
    const photoId = button.data('id'); // Obtener el ID de la foto

    // Poner la información de la foto
    $('#modalImage').attr('src', imageUrl);
    $('#photoUploader').text(uploaderName);
    $('#photoIdInput').val(photoId);

    // Cargar los comentarios para esta foto
    loadComments(photoId);
});

// Función para cargar los comentarios de una foto específica
function loadComments(photoId) {
    $.ajax({
        url: 'get_comments.php?id_foto=' + photoId,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const commentsSection = $('#commentsSection');
            commentsSection.empty();
            if (response.comments && response.comments.length > 0) {
                response.comments.forEach(comment => {
                    const commentHtml = `
                        <div>
                            <strong>${comment.nombre_comentador}</strong> (${comment.fecha_comentario})
                            <p>${comment.comentario}</p>
                        </div>
                        <hr>
                    `;
                    commentsSection.append(commentHtml);
                });
            } else {
                commentsSection.html('<p>Aún no hay comentarios. ¡Sé el primero!</p>');
            }
        }
    });
}

// Manejar el envío del formulario de comentarios
$('#commentForm').on('submit', function(e) {
    e.preventDefault();

    const photoId = $('#photoIdInput').val();
    const commenterName = $('#commenterName').val();
    const commentText = $('#commentText').val();

    $.ajax({
        url: 'save_comment.php',
        type: 'POST',
        data: {
            photoId: photoId,
            commenterName: commenterName,
            commentText: commentText
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Limpiar el formulario y recargar los comentarios
                $('#commenterName').val('');
                $('#commentText').val('');
                loadComments(photoId);
            } else {
                alert('Error: ' + response.message);
            }
        }
    });
});