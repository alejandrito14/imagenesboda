<?php
require_once __DIR__ . '/includes/invitation.php';

$invitation = invitation_load();
$requestedCode = mb_strtoupper(trim((string) ($_GET['code'] ?? '')));
if ($requestedCode === '' && preg_match('~/i/([^/?#]+)~', (string) ($_SERVER['REQUEST_URI'] ?? ''), $routeMatch)) {
    $requestedCode = mb_strtoupper(rawurldecode($routeMatch[1]));
}
$personalGuest = $requestedCode !== '' ? invitation_guest_by_code($requestedCode) : null;
$assetBaseUrl = invitation_request_base_url();
if ($requestedCode !== '' && !$personalGuest) http_response_code(404);
$storyItems = invitation_story_load();
$giftItems = invitation_gifts_load();
$galleryPhotos = invitation_gallery_load();
$dateParts = invitation_date_parts($invitation['event_date']);
$eventIso = $invitation['event_date'] . 'T' . $invitation['ceremony_time'];
$timeLabels = match ($invitation['event_type'] ?? 'wedding') {
    'quince' => ['Ceremonia', 'Recepción'],
    'birthday' => ['Inicio', 'Hora de cierre'],
    default => ['Ceremonia', 'Recepción'],
};

if (count($galleryPhotos) < 4) {
    $fallbackGallery = [
        ['src' => 'imagenes/boda1.jpg', 'nombre_subida' => $invitation['story_label']],
        ['src' => 'imagenes/boda3.jpg', 'nombre_subida' => 'Los detalles'],
        ['src' => 'imagenes/boda4.jpg', 'nombre_subida' => 'Nuestro día'],
        ['src' => 'imagenes/boda2.jpg', 'nombre_subida' => 'Juntos'],
    ];
    foreach ($fallbackGallery as $fallback) {
        if (!in_array($fallback['src'], array_column($galleryPhotos, 'src'), true)) {
            $galleryPhotos[] = $fallback;
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#252525">
    <meta name="description" content="Invitación de boda de <?= invitation_escape($invitation['couple_name']) ?>">
    <base href="<?= invitation_escape($assetBaseUrl) ?>/">
    <title><?= invitation_escape($invitation['couple_name']) ?> · <?= invitation_escape($invitation['event_label']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
    <a class="skip-link" href="#historia">Saltar al contenido</a>
    <header class="site-header" id="siteHeader">
        <a class="header-monogram" href="#inicio" aria-label="Ir al inicio"><?= invitation_escape(mb_substr($invitation['groom_name'], 0, 1) . ' · ' . mb_substr($invitation['bride_name'], 0, 1)) ?></a>
        <nav class="desktop-nav" aria-label="Navegación principal">
            <a href="#inicio">Inicio</a><a href="#historia"><?= invitation_escape($invitation['story_label']) ?></a><a href="#detalles">Detalles</a><a href="#asistencia">Asistencia</a>
        </nav>
    </header>

    <main>
        <section id="inicio" class="hero" style="--hero-image: url('<?= invitation_escape($invitation['hero_image']) ?>')">
            <div class="hero-shade"></div>
            <div class="hero-content reveal is-visible">
                <p class="eyebrow hero-eyebrow"><?= invitation_escape($invitation['event_label']) ?></p>
                <h1><?= invitation_escape($invitation['couple_name']) ?></h1>
                <p class="hero-date"><?= $dateParts['day'] ?> · <?= $dateParts['month'] ?> · <?= $dateParts['year'] ?></p>
                <p class="hero-phrase"><?= invitation_escape($invitation['romantic_phrase']) ?></p>
            </div>
            <a class="hero-discover" href="#historia"><span>Descubre nuestra historia</span><span class="hero-line" aria-hidden="true"></span></a>
        </section>

        <section id="historia" class="section story-section">
            <div class="section-heading reveal">
                <p class="eyebrow"><?= invitation_escape($invitation['story_label']) ?></p><h2><?= invitation_escape($invitation['story_title']) ?></h2><p><?= invitation_escape($invitation['story_intro']) ?></p>
            </div>
            <div class="story-timeline">
                <?php foreach ($storyItems as $index => $item): ?>
                    <article class="story-item reveal <?= $index % 2 ? 'story-item-reverse' : '' ?>">
                        <div class="story-image-wrap"><img src="<?= invitation_escape($item['image']) ?>" alt="<?= invitation_escape($item['title']) ?>" loading="lazy" decoding="async"></div>
                        <div class="story-copy"><span class="story-year"><?= invitation_escape($item['year']) ?></span><h3><?= invitation_escape($item['title']) ?></h3><p><?= invitation_escape($item['description']) ?></p></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="countdown-section" aria-labelledby="countdownTitle">
            <div class="countdown-inner reveal">
                <p class="eyebrow" id="countdownTitle">Faltan</p>
                <div class="countdown" data-event-date="<?= invitation_escape($eventIso) ?>">
                    <div><strong data-count="days">00</strong><span>Días</span></div><div><strong data-count="hours">00</strong><span>Horas</span></div><div><strong data-count="minutes">00</strong><span>Minutos</span></div><div><strong data-count="seconds">00</strong><span>Segundos</span></div>
                </div>
            </div>
        </section>

        <section id="detalles" class="section event-section">
            <div class="event-date reveal"><span><?= $dateParts['month'] ?></span><strong><?= $dateParts['day'] ?></strong><span><?= $dateParts['year'] ?></span></div>
            <div class="event-copy reveal">
                <p class="eyebrow">Celebra con nosotros</p><h2>Los detalles de nuestro día</h2>
                <div class="event-facts">
                    <div><span><?= invitation_escape($timeLabels[0]) ?></span><strong><?= invitation_escape(invitation_time_label($invitation['ceremony_time'])) ?></strong></div>
                    <div><span><?= invitation_escape($timeLabels[1]) ?></span><strong><?= invitation_escape(invitation_time_label($invitation['reception_time'])) ?></strong></div>
                    <div><span>Código de vestimenta</span><strong><?= invitation_escape($invitation['dress_code']) ?></strong></div>
                </div>
            </div>
        </section>

        <section class="location-section">
            <div class="location-image reveal"><img src="<?= invitation_escape($invitation['venue_image']) ?>" alt="<?= invitation_escape($invitation['venue']) ?>" loading="lazy" decoding="async"></div>
            <div class="location-copy reveal"><p class="eyebrow">El lugar</p><h2><?= invitation_escape($invitation['venue']) ?></h2><p><?= invitation_escape($invitation['address']) ?></p><a class="button button-dark" href="<?= invitation_escape($invitation['maps_url']) ?>" target="_blank" rel="noopener noreferrer">Cómo llegar</a></div>
        </section>

        <?php if ((int) $invitation['gallery_enabled'] === 1): ?>
            <section id="galeria" class="section gallery-section">
                <div class="section-heading reveal"><p class="eyebrow">Nuestros momentos</p><h2>Galería</h2></div>
                <div class="editorial-gallery">
                    <?php foreach ($galleryPhotos as $index => $photo): ?>
                        <button class="gallery-item reveal" type="button" data-lightbox="<?= invitation_escape($photo['src']) ?>" aria-label="Ampliar fotografía <?= $index + 1 ?>"><img src="<?= invitation_escape($photo['src']) ?>" alt="Fotografía de <?= invitation_escape($photo['nombre_subida'] ?? 'la boda') ?>" loading="lazy" decoding="async"></button>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section id="asistencia" class="attendance-section">
            <div class="attendance-intro reveal"><p class="eyebrow">Confirma tu asistencia</p><h2><?= $personalGuest ? '¡Hola, ' . invitation_escape($personalGuest['guest_name']) . '!' : '¿Nos acompañas?' ?></h2><p><?= $personalGuest ? 'Esta invitación está preparada especialmente para ti.' : 'Nos haría muy felices celebrar este día contigo.' ?></p></div>
            <div class="attendance-panel reveal">
                <?php if ($requestedCode !== '' && !$personalGuest): ?>
                    <div class="form-status error">Este código de invitación no existe o ya no está disponible.</div>
                <?php endif; ?>
                <?php if ($requestedCode === ''): ?>
                    <form id="rsvpLookupForm" class="rsvp-form">
                        <div class="field"><label for="invitationCode">Código de invitación</label><input id="invitationCode" name="invitation_code" type="text" autocomplete="off" required></div>
                        <div class="field"><label for="guestLastName">Apellidos</label><input id="guestLastName" name="last_name" type="text" autocomplete="family-name" required></div>
                        <button class="button button-gold" type="submit">Confirmar asistencia</button>
                    </form>
                <?php endif; ?>
                <div id="rsvpStatus" class="form-status" role="status" aria-live="polite"></div>
                <div id="guestPass" class="guest-pass" <?= $personalGuest ? '' : 'hidden' ?>>
                    <p class="guest-pass-label">Invitación para</p><h3 id="guestName"><?= $personalGuest ? invitation_escape($personalGuest['guest_name']) : '' ?></h3><p><strong id="guestCount"><?= $personalGuest ? (int) $personalGuest['guest_count'] . ((int) $personalGuest['guest_count'] === 1 ? ' persona' : ' personas') : '' ?></strong></p><p id="passInformation"><?= $personalGuest ? invitation_escape($personalGuest['pass_information']) : '' ?></p>
                    <div class="attendance-actions"><button class="button button-gold" type="button" data-attendance="yes">Sí, asistiré</button><button class="button button-outline" type="button" data-attendance="no">No podré asistir</button></div>
                </div>
            </div>
        </section>

        <?php if ((int) $invitation['gift_enabled'] === 1 && $giftItems): ?>
            <section class="section gift-section"><div class="gift-inner reveal"><p class="eyebrow">Mesa de regalos</p><h2>Tu presencia es nuestro mejor regalo</h2><p><?= invitation_escape($invitation['gift_intro']) ?></p><div class="gift-links">
                <?php foreach ($giftItems as $gift): ?><a class="button button-outline" href="<?= invitation_escape($gift['url']) ?>" <?= $gift['url'] !== '#' ? 'target="_blank" rel="noopener noreferrer"' : '' ?>><?= invitation_escape($gift['label']) ?></a><?php if (!empty($gift['details'])): ?><small><?= invitation_escape($gift['details']) ?></small><?php endif; ?><?php endforeach; ?>
            </div></div></section>
        <?php endif; ?>

        <?php if ((int) $invitation['upload_enabled'] === 1): ?>
            <section class="memory-section">
                <div class="memory-copy reveal"><p class="eyebrow">Comparte tus recuerdos</p><h2>Ayúdanos a guardar cada instante</h2><p>Sube las fotografías que tomes durante nuestra celebración.</p></div>
                <form id="uploadForm" class="upload-form" enctype="multipart/form-data">
                    <div class="field"><label for="uploaderName">Tu nombre</label><input id="uploaderName" name="uploaderName" type="text" required></div>
                    <label class="file-drop-area" for="fileInput"><span>Selecciona o arrastra tus fotografías</span><small>Máximo 10 imágenes</small><input id="fileInput" name="photos[]" type="file" accept="image/*" multiple required></label>
                    <div id="fileList" class="file-preview"></div><button id="submitBtn" class="button button-dark" type="submit">Compartir fotografías</button><div id="uploadStatus" class="form-status" role="status" aria-live="polite"></div>
                </form>
            </section>
        <?php endif; ?>
    </main>

    <footer class="site-footer"><p class="footer-names"><?= invitation_escape($invitation['couple_name']) ?></p><p>Gracias por formar parte de nuestra historia.</p><span><?= $dateParts['day'] ?> · <?= $dateParts['month'] ?> · <?= $dateParts['year'] ?></span></footer>
    <nav class="mobile-nav" aria-label="Navegación móvil"><a href="#inicio"><span aria-hidden="true">⌂</span>Inicio</a><a href="#historia"><span aria-hidden="true">♡</span><?= invitation_escape($invitation['story_label']) ?></a><a href="#detalles"><span aria-hidden="true">◇</span>Detalles</a><a href="#asistencia"><span aria-hidden="true">✓</span>Asistencia</a></nav>
    <dialog id="lightbox" class="lightbox"><button type="button" class="lightbox-close" aria-label="Cerrar fotografía">×</button><img src="" alt="Fotografía ampliada"></dialog>
    <?php if ($personalGuest): ?><script id="personalGuestData" type="application/json"><?= json_encode(['invitation_code' => $personalGuest['invitation_code'], 'last_name' => $personalGuest['last_name'], 'guest_name' => $personalGuest['guest_name'], 'guest_count' => (int) $personalGuest['guest_count'], 'pass_information' => $personalGuest['pass_information'], 'attendance' => $personalGuest['attendance']], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script><?php endif; ?>
    <script src="script.js?v=3" defer></script>
</body>
</html>
