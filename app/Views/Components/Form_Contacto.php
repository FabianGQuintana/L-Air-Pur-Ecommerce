
<!-- ============================
    SECCIÓN: FORMULARIO DE CONTACTO
=============================== -->
<div class="container my-5">
    <div class="card shadow">
        <div class="card-body">
             <h2 class="card-title mb-4 text-center fw-light display-6">Envianos tu consulta</h2>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('validation')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('validation')->listErrors() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('Contact/send') ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" 
                    value="<?= old('name') ?>" required placeholder="Ej: Juan Pérez">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" 
                    value="<?= old('email') ?>" required placeholder="Ej: juanperez@email.com">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono:</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                    value="<?= old('phone') ?>" required placeholder="Ej: (3774)-504134">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Mensaje:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Escribe tu consulta aquí..."><?= old('message') ?></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-lg">Enviar</button>
            </div>
        </form>
        </div>
    </div>
</div>


