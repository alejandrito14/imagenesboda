document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('siteHeader');
    const onScroll = () => header?.classList.toggle('scrolled', window.scrollY > 40);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal:not(.is-visible)').forEach((element) => revealObserver.observe(element));

    const countdown = document.querySelector('[data-event-date]');
    if (countdown) {
        const target = new Date(countdown.dataset.eventDate).getTime();
        const updateCountdown = () => {
            const distance = Math.max(0, target - Date.now());
            const values = { days: Math.floor(distance / 86400000), hours: Math.floor((distance / 3600000) % 24), minutes: Math.floor((distance / 60000) % 60), seconds: Math.floor((distance / 1000) % 60) };
            Object.entries(values).forEach(([key, value]) => {
                const output = countdown.querySelector(`[data-count="${key}"]`);
                if (output) output.textContent = String(value).padStart(2, '0');
            });
        };
        updateCountdown();
        window.setInterval(updateCountdown, 1000);
    }

    const lightbox = document.getElementById('lightbox');
    const bindLightbox = (button) => button.addEventListener('click', () => {
        if (!lightbox) return;
        lightbox.querySelector('img').src = button.dataset.lightbox;
        lightbox.showModal();
        document.body.classList.add('dialog-open');
    });
    document.querySelectorAll('[data-lightbox]').forEach(bindLightbox);
    const createGalleryItem = (photo, index) => {
        const galleryButton = document.createElement('button');
        galleryButton.className = 'gallery-item reveal is-visible';
        galleryButton.type = 'button';
        galleryButton.dataset.lightbox = photo.src;
        galleryButton.setAttribute('aria-label', `Ampliar fotografía ${index + 1}`);
        const image = document.createElement('img');
        image.src = photo.src;
        image.alt = `Fotografía de ${photo.nombre_subida || photo.uploader || 'la celebración'}`;
        image.loading = 'lazy';
        galleryButton.appendChild(image);
        bindLightbox(galleryButton);
        return galleryButton;
    };
    const refreshGallery = async () => {
        const currentGallery = document.querySelector('.editorial-gallery');
        if (!currentGallery) return;
        const response = await fetch(`gallery.php?updated=${Date.now()}`, { cache: 'no-store' });
        if (!response.ok) throw new Error('No pudimos actualizar la galería.');
        const data = await response.json();
        if (!data.success || !Array.isArray(data.photos)) throw new Error('No pudimos actualizar la galería.');
        currentGallery.replaceChildren(...data.photos.map(createGalleryItem));
    };
    lightbox?.querySelector('.lightbox-close')?.addEventListener('click', () => lightbox.close());
    lightbox?.addEventListener('click', (event) => { if (event.target === lightbox) lightbox.close(); });
    lightbox?.addEventListener('close', () => document.body.classList.remove('dialog-open'));

    const rsvpForm = document.getElementById('rsvpLookupForm');
    const rsvpStatus = document.getElementById('rsvpStatus');
    const guestPass = document.getElementById('guestPass');
    const personalGuestElement = document.getElementById('personalGuestData');
    let personalGuest = null;
    try { personalGuest = personalGuestElement ? JSON.parse(personalGuestElement.textContent) : null; } catch (error) { personalGuest = null; }
    let currentGuest = personalGuest ? { invitation_code: personalGuest.invitation_code, last_name: personalGuest.last_name } : null;
    const postRsvp = async (payload) => {
        const response = await fetch('rsvp.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        const data = await response.json();
        if (!response.ok || !data.success) throw new Error(data.message || 'No pudimos procesar tu solicitud.');
        return data;
    };

    rsvpForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        rsvpStatus.className = 'form-status';
        rsvpStatus.textContent = 'Buscando tu invitación…';
        guestPass.hidden = true;
        const values = new FormData(rsvpForm);
        try {
            const data = await postRsvp({ action: 'lookup', invitation_code: values.get('invitation_code'), last_name: values.get('last_name') });
            currentGuest = { invitation_code: values.get('invitation_code'), last_name: values.get('last_name') };
            document.getElementById('guestName').textContent = data.guest.guest_name;
            document.getElementById('guestCount').textContent = `${data.guest.guest_count} ${Number(data.guest.guest_count) === 1 ? 'persona' : 'personas'}`;
            document.getElementById('passInformation').textContent = data.guest.pass_information;
            guestPass.hidden = false;
            rsvpStatus.textContent = '';
        } catch (error) {
            currentGuest = null;
            rsvpStatus.className = 'form-status error';
            rsvpStatus.textContent = error.message;
        }
    });

    document.querySelectorAll('[data-attendance]').forEach((button) => button.addEventListener('click', async () => {
        if (!currentGuest) return;
        button.disabled = true;
        try {
            const data = await postRsvp({ action: 'respond', attendance: button.dataset.attendance, ...currentGuest });
            guestPass.hidden = true;
            rsvpStatus.className = 'form-status success';
            rsvpStatus.textContent = data.message;
        } catch (error) {
            rsvpStatus.className = 'form-status error';
            rsvpStatus.textContent = error.message;
        } finally { button.disabled = false; }
    }));

    const uploadForm = document.getElementById('uploadForm');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    const uploadStatus = document.getElementById('uploadStatus');
    const submitButton = document.getElementById('submitBtn');
    let selectedFiles = [];
    const renderSelectedFiles = () => {
        fileList.replaceChildren();
        selectedFiles.forEach((item, index) => {
            const preview = document.createElement('div');
            preview.className = 'file-preview-item';
            const image = document.createElement('img');
            image.src = item.url;
            image.alt = `Vista previa de ${item.file.name}`;
            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'file-preview-remove';
            remove.setAttribute('aria-label', `Quitar ${item.file.name}`);
            remove.textContent = '×';
            remove.addEventListener('click', () => {
                URL.revokeObjectURL(item.url);
                selectedFiles.splice(index, 1);
                renderSelectedFiles();
            });
            preview.append(image, remove);
            fileList.appendChild(preview);
        });
    };
    fileInput?.addEventListener('change', () => {
        selectedFiles.forEach((item) => URL.revokeObjectURL(item.url));
        selectedFiles = [...fileInput.files].map((file) => ({ file, url: URL.createObjectURL(file) }));
        renderSelectedFiles();
    });
    uploadForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!selectedFiles.length) {
            uploadStatus.className = 'form-status error';
            uploadStatus.textContent = 'Selecciona al menos una imagen.';
            return;
        }
        if (selectedFiles.length > 10) {
            uploadStatus.className = 'form-status error';
            uploadStatus.textContent = 'Selecciona un máximo de 10 imágenes.';
            return;
        }
        submitButton.disabled = true;
        submitButton.textContent = 'Compartiendo…';
        try {
            const uploadData = new FormData(uploadForm);
            uploadData.delete('photos[]');
            selectedFiles.forEach((item) => uploadData.append('photos[]', item.file, item.file.name));
            const response = await fetch('upload.php', { method: 'POST', body: uploadData });
            const rawResponse = await response.text();
            let data;
            try {
                data = JSON.parse(rawResponse);
            } catch (parseError) {
                const message = rawResponse.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                // Compatibilidad con el upload.php anterior, que responde texto plano al guardar.
                if (response.ok && /^Se han subido\s+\d+\s+imágenes exitosamente\.$/i.test(message)) {
                    data = { success: true, message };
                } else {
                    throw new Error(message || 'El servidor devolvió una respuesta no válida.');
                }
            }
            if (!response.ok || !data.success) throw new Error(data.message || 'No se pudieron subir las imágenes.');

            uploadStatus.className = 'form-status success';
            uploadStatus.textContent = data.message;
            uploadForm.reset();
            fileInput.value = '';
            selectedFiles.forEach((item) => URL.revokeObjectURL(item.url));
            selectedFiles = [];
            fileList.replaceChildren();
            try { await refreshGallery(); } catch (refreshError) { console.warn(refreshError); }
        } catch (error) {
            uploadStatus.className = 'form-status error';
            uploadStatus.textContent = error.message;
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Compartir fotografías';
        }
    });
});
