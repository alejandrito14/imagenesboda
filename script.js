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
    document.querySelectorAll('[data-lightbox]').forEach((button) => button.addEventListener('click', () => {
        lightbox.querySelector('img').src = button.dataset.lightbox;
        lightbox.showModal();
        document.body.classList.add('dialog-open');
    }));
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
    fileInput?.addEventListener('change', () => {
        fileList.innerHTML = '';
        [...fileInput.files].slice(0, 10).forEach((file) => {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = '';
            image.onload = () => URL.revokeObjectURL(image.src);
            fileList.appendChild(image);
        });
    });
    uploadForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (fileInput.files.length > 10) {
            uploadStatus.className = 'form-status error';
            uploadStatus.textContent = 'Selecciona un máximo de 10 imágenes.';
            return;
        }
        submitButton.disabled = true;
        submitButton.textContent = 'Compartiendo…';
        try {
            const response = await fetch('upload.php', { method: 'POST', body: new FormData(uploadForm) });
            const message = await response.text();
            if (!response.ok) throw new Error(message || 'No se pudieron subir las imágenes.');
            uploadStatus.className = 'form-status success';
            uploadStatus.textContent = message;
            uploadForm.reset();
            fileList.innerHTML = '';
        } catch (error) {
            uploadStatus.className = 'form-status error';
            uploadStatus.textContent = error.message;
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Compartir fotografías';
        }
    });
});
