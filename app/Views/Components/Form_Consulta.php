<!-- ============================
    SECCIÓN: FORMULARIO DE CONSULTA (USUARIO LOGUEADO)
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

            <form action="<?= base_url('Contact/sendConsulta') ?>" method="post">
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto:</label>
                    <input type="text" class="form-control" id="asunto" name="asunto"
                        value="<?= old('asunto') ?>" required minlength="3" placeholder="Ej: Cuando llega mi Pedido">
                </div>

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje:</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5"
                        required minlength="10" placeholder="Describa aquí su consulta..."><?= old('mensaje') ?></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-dark btn-lg">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
