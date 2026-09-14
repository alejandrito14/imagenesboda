<?php
require_once '../../clases/class.Sesion.php';
$session = new Sesion();
if (!isset($_SESSION['se_SAS'])) { echo 'login'; exit; }

require_once dirname(__DIR__, 3) . '/includes/invitation.php';
$settings = invitation_load();
$stories = invitation_story_load();
$gifts = invitation_gifts_load();
$guests = [];
try {
    $result = boda_db()->query('SELECT * FROM invitation_guests ORDER BY guest_name');
    $guests = $result->fetch_all(MYSQLI_ASSOC);
} catch (Throwable $exception) {}
$e = 'invitation_escape';
$attendanceLabels = ['pending' => 'Pendiente', 'yes' => 'Confirmado', 'no' => 'No asistirá'];
$publicBaseUrl = invitation_public_base_url($settings);
$previewBaseUrl = invitation_preview_base_url($settings);
$guestTotals = ['all' => 0, 'yes' => 0, 'pending' => 0, 'no' => 0];
foreach ($guests as $guestItem) {
    $people = max(1, (int) $guestItem['guest_count']);
    $guestTotals['all'] += $people;
    $status = $guestItem['attendance'] ?? 'pending';
    if (isset($guestTotals[$status])) $guestTotals[$status] += $people;
}
?>
<style>
.inv-admin{--gold:#b79b62;--cream:#f8f5f0}.inv-admin .card-header{display:flex;align-items:center;justify-content:space-between;gap:1rem}.inv-admin .nav-tabs{margin-bottom:1.5rem}.inv-admin .section-note{color:#6c757d;font-size:.82rem}.inv-admin .repeat-row{position:relative;margin-bottom:1rem;padding:1rem;border:1px solid #e5e5e5;background:#fff}.inv-admin .remove-row{position:absolute;right:.6rem;top:.6rem;z-index:4;pointer-events:auto}.inv-admin .image-preview{width:150px;height:95px;object-fit:cover;border:1px solid #ddd}.inv-admin .status-pill{display:inline-block;padding:.2rem .5rem;border-radius:1rem;background:#eee;font-size:.72rem}.inv-admin .status-yes{background:#dff2df;color:#276427}.inv-admin .status-no{background:#f8dddd;color:#842929}.inv-admin .save-bar{position:sticky;bottom:0;z-index:5;display:flex;align-items:center;justify-content:space-between;margin:1.5rem -20px -20px;padding:1rem 20px;border-top:1px solid #ddd;background:rgba(255,255,255,.96)}
.inv-admin .status-pending{background:#f4efe4;color:#725f37}.guest-toolbar{display:flex;flex-wrap:wrap;gap:.75rem;align-items:center;margin-bottom:1rem}.guest-toolbar .guest-search{min-width:240px;flex:1}.guest-filters{display:flex;flex-wrap:wrap;gap:.35rem}.guest-filter.active{background:#555;color:#fff}.guest-actions{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}.guest-row.is-filtered{display:none}.btn-whatsapp{background:#25d366;border-color:#25d366;color:#fff}.btn-whatsapp:hover{background:#1ebc59;border-color:#1ebc59;color:#fff}
.guest-import-panel{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:16px;padding:14px 16px;border:1px dashed #b8c4b9;border-radius:9px;background:#f5f8f3}.guest-import-copy{min-width:220px;flex:1}.guest-import-copy strong{display:block;color:#304c38;font-family:'Cormorant Garamond',serif;font-size:20px}.guest-import-copy small{color:#6b736d}.guest-import-controls{display:flex;align-items:center;gap:8px;flex-wrap:wrap}.guest-import-controls input{max-width:245px;font-size:11px}.guest-import-result{width:100%;margin:0;font-size:11px}.guest-import-result.error{color:#a43f37}.guest-import-result.success{color:#376245}
.inv-page-heading{margin-bottom:16px}.inv-page-heading h2{font-size:34px;margin:0;line-height:1}.inv-page-heading p{margin:4px 0 0;color:#68716b}.inv-overview-hero{display:grid;grid-template-columns:minmax(240px,38%) 1fr;min-height:210px;margin-bottom:18px;overflow:hidden;border:1px solid #dfddd5;border-radius:11px;background:#fffefa;box-shadow:0 8px 30px rgba(39,50,43,.045)}.inv-overview-image{min-height:210px}.inv-overview-image img{width:100%;height:100%;object-fit:cover}.inv-overview-copy{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:30px;text-align:center;background:linear-gradient(105deg,#fffefa,#f4f0e7)}.inv-overview-copy:after{content:'❧';position:absolute;right:25px;top:18px;color:#b8aa8e;font-size:34px;opacity:.65}.inv-overview-copy .eyebrow{margin:0 0 5px;color:#6c685f;font-size:10px;letter-spacing:.3em;text-transform:uppercase}.inv-overview-copy h2{margin:0;font-size:42px}.inv-overview-copy .date{margin:4px 0 18px;color:#665e52;font-family:'Cormorant Garamond',serif;font-size:17px;letter-spacing:.12em}.inv-stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}.inv-stat{display:flex;align-items:center;gap:13px;padding:17px;border:1px solid #e3e0d8;border-radius:10px;background:#fffefa}.inv-stat-icon{display:grid;width:39px;height:39px;flex:0 0 39px;place-items:center;border-radius:50%;background:#e8ede5;color:#4d7455;font-size:21px}.inv-stat strong{display:block;color:#17231d;font-family:'Cormorant Garamond',serif;font-size:29px;line-height:1}.inv-stat span{display:block;margin-bottom:3px;color:#667069;font-size:10px}.inv-stat.pending .inv-stat-icon{background:#fff0cf;color:#c8860a}.inv-stat.no .inv-stat-icon{background:#fee1dd;color:#d65449}.inv-admin.card{background:transparent;border:0;box-shadow:none}.inv-admin>.card-header{padding:18px 20px;border:1px solid #e3e0d8;border-bottom:0;border-radius:11px 11px 0 0;background:#fffefa}.inv-admin>.card-body{border:1px solid #e3e0d8;border-radius:0 0 11px 11px;background:#fffefa}.inv-admin .nav-tabs{gap:5px;border-bottom:1px solid #e3e0d8}.inv-admin .nav-tabs .nav-link{border:0;border-bottom:2px solid transparent;color:#68716b;font-weight:500}.inv-admin .nav-tabs .nav-link.active{border-bottom-color:#55765c;background:transparent;color:#35533d}.inv-admin .repeat-row{border-radius:9px;border-color:#e3e0d8;box-shadow:0 3px 14px rgba(39,50,43,.03)}
@media(max-width:900px){.inv-stat-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:650px){.inv-overview-hero{grid-template-columns:1fr}.inv-overview-image{min-height:180px}.inv-stat-grid{grid-template-columns:1fr 1fr}.inv-overview-copy h2{font-size:34px}}@media(max-width:420px){.inv-stat-grid{grid-template-columns:1fr}}
</style>
<div class="inv-page-heading"><h2>¡Hola, <?= $e($_SESSION['se_Empleado'] ?? 'bienvenido') ?>!</h2><p>Aquí tienes un resumen de tu invitación y la asistencia de tus invitados.</p></div>
<section class="inv-overview-hero">
    <div class="inv-overview-image"><img id="invOverviewImage" src="../<?= $e($settings['hero_image']) ?>" alt="Fotografía de <?= $e($settings['couple_name']) ?>"></div>
    <div class="inv-overview-copy"><p id="invOverviewEventLabel" class="eyebrow"><?= $e($settings['event_label']) ?></p><h2 id="invOverviewName"><?= $e($settings['couple_name']) ?></h2><p id="invOverviewDate" class="date"><?= $e(invitation_date_label($settings['event_date'])) ?></p><a class="btn btn-primary px-4" href="<?= $e($previewBaseUrl) ?>/" target="_blank" rel="noopener">Ver invitación <i class="mdi mdi-open-in-new ml-1"></i></a></div>
</section>
<div class="inv-stat-grid">
    <div class="inv-stat"><span class="inv-stat-icon"><i class="mdi mdi-account-multiple-outline"></i></span><div><span>Total invitados</span><strong><?= $guestTotals['all'] ?></strong></div></div>
    <div class="inv-stat"><span class="inv-stat-icon"><i class="mdi mdi-check-circle-outline"></i></span><div><span>Confirmados</span><strong><?= $guestTotals['yes'] ?></strong></div></div>
    <div class="inv-stat pending"><span class="inv-stat-icon"><i class="mdi mdi-clock-outline"></i></span><div><span>Pendientes</span><strong><?= $guestTotals['pending'] ?></strong></div></div>
    <div class="inv-stat no"><span class="inv-stat-icon"><i class="mdi mdi-close-circle-outline"></i></span><div><span>No asistirán</span><strong><?= $guestTotals['no'] ?></strong></div></div>
</div>
<div class="card inv-admin">
    <div class="card-header">
        <div><h5 class="card-title mb-1">INVITACIÓN DIGITAL</h5><p class="section-note mb-0">Todos los cambios se reflejan en la invitación pública.</p></div>
        <a class="btn btn-outline-dark" href="<?= $e($previewBaseUrl) ?>/" target="_blank" rel="noopener">Vista previa</a>
    </div>
    <div class="card-body">
        <form id="invitationAdminForm" enctype="multipart/form-data">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#inv-general">Datos generales</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inv-story"><?= $e($settings['story_label']) ?></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inv-gifts">Regalos</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inv-guests">Invitados y RSVP</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="inv-general">
                    <div class="row">
                        <div class="col-md-4 form-group"><label>Tipo de evento</label><select id="invitationEventType" class="form-control" name="event_type"><option value="wedding" <?= ($settings['event_type'] ?? 'wedding') === 'wedding' ? 'selected' : '' ?>>Boda</option><option value="quince" <?= ($settings['event_type'] ?? '') === 'quince' ? 'selected' : '' ?>>XV años</option><option value="birthday" <?= ($settings['event_type'] ?? '') === 'birthday' ? 'selected' : '' ?>>Cumpleaños</option></select></div>
                        <div class="col-md-4 form-group"><label>Texto de portada</label><input id="invitationEventLabel" class="form-control" name="event_label" required value="<?= $e($settings['event_label']) ?>" placeholder="Nuestra boda"></div>
                        <div class="col-md-4 form-group"><label>Nombre de la sección</label><input id="invitationStoryLabel" class="form-control" name="story_label" required value="<?= $e($settings['story_label']) ?>" placeholder="Nuestra historia"></div>
                        <div class="col-md-12 form-group"><label>Título de la sección</label><input id="invitationStoryTitle" class="form-control" name="story_section_title" required value="<?= $e($settings['story_title']) ?>" placeholder="Todo comenzó con un encuentro"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group"><label>Nombre 1</label><input class="form-control" name="bride_name" required value="<?= $e($settings['bride_name']) ?>"><small class="form-text text-muted">En XV años o cumpleaños puedes repetir el nombre principal.</small></div>
                        <div class="col-md-4 form-group"><label>Nombre 2</label><input class="form-control" name="groom_name" required value="<?= $e($settings['groom_name']) ?>"><small class="form-text text-muted">En eventos individuales también puede ser el mismo nombre.</small></div>
                        <div class="col-md-4 form-group"><label>Nombre mostrado</label><input class="form-control" name="couple_name" required value="<?= $e($settings['couple_name']) ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group"><label>Fecha del evento</label><input class="form-control" type="date" name="event_date" required value="<?= $e($settings['event_date']) ?>"></div>
                        <div class="col-md-4 form-group"><label>Hora principal</label><input class="form-control" type="time" name="ceremony_time" required value="<?= $e(substr($settings['ceremony_time'], 0, 5)) ?>"></div>
                        <div class="col-md-4 form-group"><label>Hora secundaria</label><input class="form-control" type="time" name="reception_time" required value="<?= $e(substr($settings['reception_time'], 0, 5)) ?>"></div>
                    </div>
                    <div class="form-group"><label>Frase principal de portada</label><textarea class="form-control" name="romantic_phrase" rows="2"><?= $e($settings['romantic_phrase']) ?></textarea></div>
                    <div class="form-group"><label>Introducción de la historia</label><textarea class="form-control" name="story_intro" rows="2"><?= $e($settings['story_intro']) ?></textarea></div>
                    <hr><div class="row">
                        <div class="col-md-6 form-group"><label>Lugar</label><input class="form-control" name="venue" required value="<?= $e($settings['venue']) ?>"></div>
                        <div class="col-md-6 form-group"><label>Código de vestimenta</label><input class="form-control" name="dress_code" value="<?= $e($settings['dress_code']) ?>"></div>
                        <div class="col-md-6 form-group"><label>Dirección</label><input class="form-control" name="address" value="<?= $e($settings['address']) ?>"></div>
                        <div class="col-md-6 form-group"><label>URL de Google Maps</label><input class="form-control" type="url" name="maps_url" value="<?= $e($settings['maps_url']) ?>"></div>
                        <div class="col-md-12 form-group"><label>Dominio público de la invitación</label><input class="form-control" type="url" name="public_url" placeholder="<?= $e($publicBaseUrl) ?>" value="<?= $e($settings['public_url'] ?? '') ?>"><small class="form-text text-muted">Ejemplo: https://tudominio.com/boda. Si lo dejas vacío se usará el dominio actual.</small></div>
                        <div class="col-md-12 form-group"><label>URL local para Vista previa y Ver pase</label><input class="form-control" type="url" name="preview_url" placeholder="http://localhost:8080" value="<?= $e($settings['preview_url'] ?? '') ?>"><small class="form-text text-muted">Puede usar otro puerto distinto al dashboard. En tu equipo corresponde a http://localhost:8080.</small></div>
                    </div>
                    <hr><div class="row">
                        <div class="col-md-6 form-group"><label>Fotografía de portada</label><div class="d-flex align-items-center mb-2"><img class="image-preview mr-3" src="../<?= $e($settings['hero_image']) ?>" alt=""><small><?= $e($settings['hero_image']) ?></small></div><input type="hidden" name="current_hero_image" value="<?= $e($settings['hero_image']) ?>"><input class="form-control-file" type="file" name="hero_image_file" accept="image/jpeg,image/png,image/webp"></div>
                        <div class="col-md-6 form-group"><label>Fotografía del lugar</label><div class="d-flex align-items-center mb-2"><img class="image-preview mr-3" src="../<?= $e($settings['venue_image']) ?>" alt=""><small><?= $e($settings['venue_image']) ?></small></div><input type="hidden" name="current_venue_image" value="<?= $e($settings['venue_image']) ?>"><input class="form-control-file" type="file" name="venue_image_file" accept="image/jpeg,image/png,image/webp"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 custom-control custom-switch ml-3"><input class="custom-control-input" id="giftEnabled" type="checkbox" name="gift_enabled" value="1" <?= $settings['gift_enabled'] ? 'checked' : '' ?>><label class="custom-control-label" for="giftEnabled">Mostrar mesa de regalos</label></div>
                        <div class="col-md-4 custom-control custom-switch"><input class="custom-control-input" id="galleryEnabled" type="checkbox" name="gallery_enabled" value="1" <?= $settings['gallery_enabled'] ? 'checked' : '' ?>><label class="custom-control-label" for="galleryEnabled">Mostrar galería</label></div>
                        <div class="col-md-4 custom-control custom-switch"><input class="custom-control-input" id="uploadEnabled" type="checkbox" name="upload_enabled" value="1" <?= $settings['upload_enabled'] ? 'checked' : '' ?>><label class="custom-control-label" for="uploadEnabled">Permitir subir fotos</label></div>
                    </div>
                </div>

                <div class="tab-pane" id="inv-story">
                    <p class="section-note">Agrega momentos, ordénalos arrastrando las filas o mediante el orden. Puedes usar una ruta existente o subir una imagen nueva.</p>
                    <div id="storyRows">
                        <?php foreach ($stories as $index => $story): ?>
                            <div class="repeat-row story-row"><button class="btn btn-sm btn-outline-danger remove-row" type="button" aria-label="Eliminar momento">Eliminar</button><div class="row">
                                <div class="col-md-2 form-group"><label>Año</label><input class="form-control" name="story_year[]" value="<?= $e($story['year']) ?>"></div>
                                <div class="col-md-4 form-group"><label>Título</label><input class="form-control" name="story_title[]" value="<?= $e($story['title']) ?>"></div>
                                <div class="col-md-6 form-group"><label>Texto</label><textarea class="form-control" name="story_description[]" rows="2"><?= $e($story['description']) ?></textarea></div>
                                <div class="col-md-6 form-group"><label>Ruta actual</label><input class="form-control" name="story_image[]" value="<?= $e($story['image']) ?>"></div>
                                <div class="col-md-6 form-group"><label>Reemplazar imagen</label><input class="form-control-file" type="file" name="story_file[]" accept="image/jpeg,image/png,image/webp"></div>
                            </div></div>
                        <?php endforeach; ?>
                    </div>
                    <button class="btn btn-outline-primary" type="button" onclick="invitationAddStory()">+ Agregar momento</button>
                </div>

                <div class="tab-pane" id="inv-gifts">
                    <div class="form-group"><label>Texto introductorio</label><textarea class="form-control" name="gift_intro" rows="2"><?= $e($settings['gift_intro']) ?></textarea></div>
                    <div id="giftRows">
                        <?php foreach ($gifts as $gift): ?><div class="repeat-row"><button class="btn btn-sm btn-outline-danger remove-row" type="button" aria-label="Eliminar regalo">Eliminar</button><div class="row">
                            <div class="col-md-4 form-group"><label>Nombre / botón</label><input class="form-control" name="gift_label[]" value="<?= $e($gift['label']) ?>"></div><div class="col-md-4 form-group"><label>Enlace</label><input class="form-control" name="gift_url[]" value="<?= $e($gift['url']) ?>"></div><div class="col-md-4 form-group"><label>Información adicional</label><input class="form-control" name="gift_details[]" value="<?= $e($gift['details']) ?>"></div>
                        </div></div><?php endforeach; ?>
                    </div><button class="btn btn-outline-primary" type="button" onclick="invitationAddGift()">+ Agregar opción</button>
                </div>

                <div class="tab-pane" id="inv-guests">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3"><div><h4 class="mb-1">Invitados</h4><p class="section-note mb-0">Comparte un enlace personal y consulta las confirmaciones.</p></div><button class="btn btn-primary" type="button" onclick="invitationAddGuest()">+ Agregar invitado</button></div>
                    <div class="guest-import-panel">
                        <div class="guest-import-copy"><strong>Importación masiva</strong><small>Sube un archivo .xlsx o .csv de hasta 5 MB. Se importa inmediatamente.</small></div>
                        <div class="guest-import-controls"><input id="guestImportFile" type="file" accept=".xlsx,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv"><button id="guestImportButton" class="btn btn-outline-primary" type="button"><i class="mdi mdi-file-excel"></i> Importar Excel</button><a class="btn btn-link" href="catalogos/invitaciones/plantilla_invitados.php" target="_blank"><i class="mdi mdi-download"></i> Descargar plantilla</a></div>
                        <p id="guestImportResult" class="guest-import-result" role="status" aria-live="polite"></p>
                    </div>
                    <div class="guest-toolbar">
                        <input id="guestSearch" class="form-control guest-search" type="search" placeholder="Buscar por nombre, apellidos o código" aria-label="Buscar invitados">
                        <div class="guest-filters" aria-label="Filtrar invitados">
                            <button class="btn btn-sm btn-outline-secondary guest-filter active" type="button" data-guest-filter="all">Todos</button>
                            <button class="btn btn-sm btn-outline-secondary guest-filter" type="button" data-guest-filter="pending">Pendientes</button>
                            <button class="btn btn-sm btn-outline-secondary guest-filter" type="button" data-guest-filter="yes">Confirmados</button>
                            <button class="btn btn-sm btn-outline-secondary guest-filter" type="button" data-guest-filter="no">No asistirán</button>
                        </div>
                    </div>
                    <div id="guestRows">
                        <?php foreach ($guests as $guest): ?>
                            <?php $guestSearch = mb_strtolower($guest['guest_name'] . ' ' . $guest['last_name'] . ' ' . $guest['invitation_code']); ?>
                            <div class="repeat-row guest-row" data-guest-status="<?= $e($guest['attendance']) ?>" data-guest-search="<?= $e($guestSearch) ?>">
                                <button class="btn btn-sm btn-outline-danger remove-row" type="button" aria-label="Eliminar invitado">Eliminar</button>
                                <input type="hidden" name="guest_id[]" value="<?= (int)$guest['id'] ?>">
                                <div class="row">
                                    <div class="col-md-2 form-group"><label>Código</label><input class="form-control" name="guest_code[]" required value="<?= $e($guest['invitation_code']) ?>"></div>
                                    <div class="col-md-2 form-group"><label>Apellidos</label><input class="form-control" name="guest_last_name[]" required value="<?= $e($guest['last_name']) ?>"></div>
                                    <div class="col-md-3 form-group"><label>Nombre</label><input class="form-control" name="guest_name[]" required value="<?= $e($guest['guest_name']) ?>"></div>
                                    <div class="col-md-2 form-group"><label>WhatsApp (opcional)</label><input class="form-control" type="tel" name="guest_phone[]" placeholder="5210000000000" value="<?= $e($guest['phone'] ?? '') ?>"></div>
                                    <div class="col-md-1 form-group"><label>Personas</label><input class="form-control" type="number" min="1" name="guest_count[]" value="<?= (int)$guest['guest_count'] ?>"></div>
                                    <div class="col-md-2 form-group"><label>Estado</label><div><span class="status-pill status-<?= $e($guest['attendance']) ?>"><?= $e($attendanceLabels[$guest['attendance']] ?? 'Pendiente') ?></span></div></div>
                                    <div class="col-md-7 form-group"><label>Información del pase</label><input class="form-control" name="guest_pass[]" value="<?= $e($guest['pass_information']) ?>"></div>
                                    <div class="col-md-5 form-group"><label>Acciones</label><div class="guest-actions"><a class="btn btn-sm btn-whatsapp whatsapp-guest" href="<?= $e(generateWhatsAppUrl($settings, $guest)) ?>" target="_blank" rel="noopener">WhatsApp</a><button class="btn btn-sm btn-outline-secondary edit-guest" type="button">Editar</button><a class="btn btn-sm btn-outline-dark guest-preview" href="<?= $e($previewBaseUrl . '/i/' . rawurlencode($guest['invitation_code'])) ?>" target="_blank" rel="noopener">Ver pase</a></div></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <p id="guestEmpty" class="text-muted text-center py-4" hidden>No hay invitados que coincidan con la búsqueda.</p>
                </div>
            </div>
            <div class="save-bar"><span id="invitationSaveStatus" role="status"></span><button id="invitationSaveButton" class="btn btn-primary" type="submit"><i class="mdi mdi-content-save"></i> Guardar y publicar</button></div>
        </form>
    </div>
</div>
<script>
window.invitationAddStory=function(){document.getElementById('storyRows').insertAdjacentHTML('beforeend',`<div class="repeat-row"><button class="btn btn-sm btn-outline-danger remove-row" type="button" onclick="this.closest('.repeat-row').remove()">×</button><div class="row"><div class="col-md-2 form-group"><label>Año</label><input class="form-control" name="story_year[]"></div><div class="col-md-4 form-group"><label>Título</label><input class="form-control" name="story_title[]"></div><div class="col-md-6 form-group"><label>Texto</label><textarea class="form-control" name="story_description[]" rows="2"></textarea></div><div class="col-md-6 form-group"><label>Ruta actual</label><input class="form-control" name="story_image[]"></div><div class="col-md-6 form-group"><label>Subir imagen</label><input class="form-control-file" type="file" name="story_file[]" accept="image/jpeg,image/png,image/webp"></div></div></div>`)};
window.invitationAddGift=function(){document.getElementById('giftRows').insertAdjacentHTML('beforeend',`<div class="repeat-row"><button class="btn btn-sm btn-outline-danger remove-row" type="button" onclick="this.closest('.repeat-row').remove()">×</button><div class="row"><div class="col-md-4 form-group"><label>Nombre / botón</label><input class="form-control" name="gift_label[]"></div><div class="col-md-4 form-group"><label>Enlace</label><input class="form-control" name="gift_url[]"></div><div class="col-md-4 form-group"><label>Información adicional</label><input class="form-control" name="gift_details[]"></div></div></div>`)};
window.invitationAddGuest=function(){document.getElementById('guestRows').insertAdjacentHTML('beforeend',`<div class="repeat-row"><button class="btn btn-sm btn-outline-danger remove-row" type="button" onclick="this.closest('.repeat-row').remove()">×</button><input type="hidden" name="guest_id[]" value="0"><div class="row"><div class="col-md-2 form-group"><label>Código</label><input class="form-control" name="guest_code[]" required></div><div class="col-md-2 form-group"><label>Apellidos</label><input class="form-control" name="guest_last_name[]" required></div><div class="col-md-3 form-group"><label>Nombre del pase</label><input class="form-control" name="guest_name[]" required></div><div class="col-md-1 form-group"><label>Personas</label><input class="form-control" type="number" min="1" name="guest_count[]" value="1"></div><div class="col-md-4 form-group"><label>Información del pase</label><input class="form-control" name="guest_pass[]"></div></div></div>`)};
document.getElementById('invitationAdminForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    const button = document.getElementById('invitationSaveButton');
    const status = document.getElementById('invitationSaveStatus');
    button.disabled = true;
    status.textContent = 'Guardando…';
    try {
        const response = await fetch('catalogos/invitaciones/ga_invitaciones.php', { method: 'POST', body: new FormData(this) });
        const rawResponse = await response.text();
        let data;
        try {
            data = JSON.parse(rawResponse);
        } catch (parseError) {
            const readableMessage = rawResponse.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
            throw new Error(readableMessage || 'El servidor devolvió una respuesta no válida.');
        }
        if (!response.ok || !data.success) throw new Error(data.message || 'No se pudo guardar');
        status.className = 'text-success';
        status.textContent = data.message;
        if (data.invitation) {
            const overviewName = document.getElementById('invOverviewName');
            const overviewEventLabel = document.getElementById('invOverviewEventLabel');
            const overviewDate = document.getElementById('invOverviewDate');
            const overviewImage = document.getElementById('invOverviewImage');
            if (overviewName) overviewName.textContent = data.invitation.couple_name;
            if (overviewEventLabel) overviewEventLabel.textContent = data.invitation.event_label;
            if (overviewDate) overviewDate.textContent = data.invitation.event_date_label;
            if (overviewImage) {
                overviewImage.src = '../' + String(data.invitation.hero_image).replace(/^\.\.\//, '');
                overviewImage.alt = 'Fotografía de ' + data.invitation.couple_name;
            }
        }
    } catch (error) {
        status.className = 'text-danger';
        status.textContent = error.message;
    } finally {
        button.disabled = false;
    }
});
</script>
<script>
window.invitationWhatsAppData = <?= json_encode([
    'coupleName' => $settings['couple_name'],
    'eventDate' => invitation_date_label($settings['event_date']),
    'eventTime' => invitation_time_label($settings['ceremony_time']),
    'venue' => $settings['venue'],
    'baseUrl' => $publicBaseUrl,
    'celebrationMessage' => invitation_celebration_message($settings),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>;

window.generateWhatsAppUrl = function(invitation, guest) {
    var phone = String(guest.phone || '').replace(/\D/g, '');
    var code = String(guest.code || '').trim().toUpperCase();
    var guestUrl = invitation.baseUrl.replace(/\/$/, '') + '/i/' + encodeURIComponent(code);
    var message = [
        'Hola ' + (guest.name || 'invitado') + ' 👋',
        '',
        'Tenemos una invitación muy especial para ti. 💍',
        '',
        invitation.celebrationMessage,
        '',
        '📅 ' + invitation.eventDate,
        '🕒 ' + invitation.eventTime,
        '📍 ' + invitation.venue,
        '',
        '🎟️ Tu invitación personal:',
        guestUrl,
        '',
        'Por favor confirma tu asistencia desde el enlace.',
        '',
        '¡Esperamos verte! ❤️'
    ].join('\n');
    return 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);
};

window.invitationAddGuest = function() {
    var eventType = document.getElementById('invitationEventType')?.value || 'wedding';
    var prefixes = { wedding: 'BODA', quince: 'XV', birthday: 'CUMPLE' };
    var code = (prefixes[eventType] || 'PASE') + Math.random().toString(36).slice(2, 7).toUpperCase();
    var html = `<div class="repeat-row guest-row" data-guest-status="pending">
        <button class="btn btn-sm btn-outline-danger remove-row" type="button">Eliminar</button>
        <input type="hidden" name="guest_id[]" value="0">
        <div class="row">
            <div class="col-md-2 form-group"><label>Código</label><input class="form-control" name="guest_code[]" required value="${code}"></div>
            <div class="col-md-2 form-group"><label>Apellidos</label><input class="form-control" name="guest_last_name[]" required></div>
            <div class="col-md-3 form-group"><label>Nombre</label><input class="form-control" name="guest_name[]" required></div>
            <div class="col-md-2 form-group"><label>WhatsApp (opcional)</label><input class="form-control" type="tel" name="guest_phone[]" placeholder="5210000000000"></div>
            <div class="col-md-1 form-group"><label>Personas</label><input class="form-control" type="number" min="1" name="guest_count[]" value="1"></div>
            <div class="col-md-2 form-group"><label>Estado</label><div><span class="status-pill status-pending">Pendiente</span></div></div>
            <div class="col-md-7 form-group"><label>Información del pase</label><input class="form-control" name="guest_pass[]"></div>
            <div class="col-md-5 form-group"><label>Acciones</label><div class="guest-actions"><a class="btn btn-sm btn-whatsapp whatsapp-guest" href="#" target="_blank" rel="noopener">WhatsApp</a><button class="btn btn-sm btn-outline-secondary edit-guest" type="button">Editar</button></div></div>
        </div>
    </div>`;
    document.getElementById('guestRows').insertAdjacentHTML('beforeend', html);
    var rows = document.querySelectorAll('#guestRows .guest-row');
    rows[rows.length - 1].querySelector('[name="guest_name[]"]').focus();
};

(function initializeGuestPanel() {
    var form = document.getElementById('invitationAdminForm');
    var search = document.getElementById('guestSearch');
    var activeFilter = 'all';
    if (!form || !search) return;

    function filterGuests() {
        var term = search.value.trim().toLocaleLowerCase('es');
        var visible = 0;
        document.querySelectorAll('#guestRows .guest-row').forEach(function(row) {
            var values = [row.querySelector('[name="guest_name[]"]')?.value, row.querySelector('[name="guest_last_name[]"]')?.value, row.querySelector('[name="guest_code[]"]')?.value].join(' ').toLocaleLowerCase('es');
            var matches = (!term || values.includes(term)) && (activeFilter === 'all' || row.dataset.guestStatus === activeFilter);
            row.classList.toggle('is-filtered', !matches);
            if (matches) visible++;
        });
        document.getElementById('guestEmpty').hidden = visible !== 0;
    }

    search.addEventListener('input', filterGuests);
    document.querySelectorAll('.guest-filter').forEach(function(button) {
        button.addEventListener('click', function() {
            activeFilter = button.dataset.guestFilter;
            document.querySelectorAll('.guest-filter').forEach(function(item) { item.classList.toggle('active', item === button); });
            filterGuests();
        });
    });

    form.addEventListener('click', function(event) {
        var whatsapp = event.target.closest('.whatsapp-guest');
        if (whatsapp) {
            event.preventDefault();
            var row = whatsapp.closest('.guest-row');
            var guest = {
                name: row.querySelector('[name="guest_name[]"]').value.trim(),
                phone: row.querySelector('[name="guest_phone[]"]').value.trim(),
                code: row.querySelector('[name="guest_code[]"]').value.trim()
            };
            if (!guest.name || !guest.code) {
                alert('Agrega el nombre y código del invitado antes de compartir.');
                return;
            }
            window.open(generateWhatsAppUrl(window.invitationWhatsAppData, guest), '_blank', 'noopener');
            return;
        }

        var edit = event.target.closest('.edit-guest');
        if (edit) edit.closest('.guest-row').querySelector('[name="guest_name[]"]').focus();
    });
})();

(function initializeEventTypePresets() {
    var eventType = document.getElementById('invitationEventType');
    if (!eventType) return;
    var presets = {
        wedding: { event: 'Nuestra boda', story: 'Nuestra historia', title: 'Todo comenzó con un encuentro' },
        quince: { event: 'Mis XV años', story: 'Mi historia', title: 'El comienzo de una etapa inolvidable' },
        birthday: { event: 'Mi cumpleaños', story: 'Mi historia', title: 'Momentos que han marcado mi vida' }
    };
    eventType.addEventListener('change', function() {
        var preset = presets[eventType.value];
        if (!preset) return;
        document.getElementById('invitationEventLabel').value = preset.event;
        document.getElementById('invitationStoryLabel').value = preset.story;
        document.getElementById('invitationStoryTitle').value = preset.title;
    });
})();

(function initializeGuestImport() {
    var fileInput = document.getElementById('guestImportFile');
    var button = document.getElementById('guestImportButton');
    var result = document.getElementById('guestImportResult');
    if (!fileInput || !button || !result) return;

    button.addEventListener('click', async function() {
        if (!fileInput.files.length) {
            result.className = 'guest-import-result error';
            result.textContent = 'Selecciona primero un archivo .xlsx o .csv.';
            return;
        }
        var formData = new FormData();
        formData.append('guest_file', fileInput.files[0]);
        button.disabled = true;
        result.className = 'guest-import-result';
        result.textContent = 'Importando invitados…';
        try {
            var response = await fetch('catalogos/invitaciones/importar_invitados.php', { method: 'POST', body: formData });
            var rawResponse = await response.text();
            var data;
            try { data = JSON.parse(rawResponse); } catch (error) { throw new Error(rawResponse.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim() || 'Respuesta no válida del servidor.'); }
            if (!response.ok || !data.success) throw new Error(data.message || 'No se pudo importar el archivo.');
            result.className = 'guest-import-result success';
            result.textContent = data.message + (data.errors?.length ? ' ' + data.errors.join(' ') : '');
            fileInput.value = '';
            window.setTimeout(function() {
                aparecermodulos2('catalogos/invitaciones/vi_invitaciones.php?idmenumodulo=153', 'main', '/ INVITACIONES / INVITACIÓN DIGITAL /');
                window.setTimeout(function() { $('a[href="#inv-guests"]').tab('show'); }, 650);
            }, 1100);
        } catch (error) {
            result.className = 'guest-import-result error';
            result.textContent = error.message;
        } finally {
            button.disabled = false;
        }
    });
})();
</script>
