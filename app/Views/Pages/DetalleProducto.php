<link rel="stylesheet" href="<?= base_url('assets/css/StyleDetalleProducto.css') ?>">

<div class="container my-3">
    <div class="row producto-container">
        <!-- Imagen del producto -->
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="<?= base_url('assets/img/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-fluid producto-imagen w-100 shadow-sm">
        </div>

        <!-- Detalle del producto -->
        <div class="col-md-6">
            <h5 class="text-muted mb-2">Nuevo | <span id="stockDisponibleTexto"><?= $producto['cantidad']; ?> disponibles</span></h5>
            <h2 class="mb-3"><?= esc($producto['nombre']) ?> <?= esc($producto['mililitros']) ?> mL</h2>
            <h4 class="text-success mb-4">$<?= number_format($producto['precio'], 0, ',', '.') ?></h4>

            <p class="mt-3"><?= esc($producto['descripcion']) ?></p>

            <ul class="list-group mb-4 mt-4">
                <li class="list-group-item"><strong>Marca:</strong> <?= esc($producto['marca']) ?></li>
                <li class="list-group-item"><strong>Categoría:</strong> <?= esc($producto['categoria']) ?></li>
                <li class="list-group-item"><strong>Volumen:</strong> <?= esc($producto['mililitros']) ?> mL</li>
                <li class="list-group-item"><strong>Stock disponible:</strong> <span id="stockDisponibleLista"><?= esc($producto['cantidad']) ?></span></li>
            </ul>

            <!-- Mensaje de estado -->
            <div id="mensajeCarrito"></div>

            <!-- Formulario para agregar al carrito -->
            <form id="formAgregarCarrito" class="d-grid gap-3">
                <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad:</label>
                    <select name="cantidad" id="cantidad" class="form-select w-50">
                        <?php
                        $max = min(12, $producto['cantidad']);
                        for ($i = 1; $i <= $max; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark btn-lg w-100">Agregar al carrito</button>
            </form>
        </div>
    </div>
</div>

<!-- Script AJAX -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formAgregarCarrito");
    const mensajeDiv = document.getElementById("mensajeCarrito");
    const stockTexto = document.getElementById("stockDisponibleTexto");
    const stockLista = document.getElementById("stockDisponibleLista");
    const selectCantidad = document.getElementById("cantidad");
    const botonSubmit = form.querySelector("button[type='submit']");

    // Validar stock al cargar la página
    const stockInicial = parseInt(stockLista.textContent);
    if (stockInicial <= 0) {
        selectCantidad.disabled = true;
        botonSubmit.disabled = true;
        mensajeDiv.innerHTML = `<div class="alert alert-warning">No hay stock disponible.</div>`;
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const idProducto = form.querySelector('input[name="id_producto"]').value;
        const cantidadSeleccionada = selectCantidad.value;

        fetch(`<?= base_url('/Carrito/agregar/') ?>${idProducto}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                cantidad: cantidadSeleccionada
            })
        })
        .then(response => {
            if (response.status === 401) {
                return response.json().then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                });
            } else if (response.status === 400 || response.status === 404) {
                return response.text().then(msg => {
                    mensajeDiv.innerHTML = `<div class="alert alert-danger">${msg}</div>`;
                });
            } else {
                return response.json().then(data => {
                    mensajeDiv.innerHTML = `<div class="alert alert-success">${data.mensaje}</div>`;

                    // Actualizar el stock visible
                    stockTexto.textContent = `${data.stock_disponible} disponibles`;
                    stockLista.textContent = data.stock_disponible;

                    // Guardar la cantidad anterior seleccionada
                    const cantidadAnterior = parseInt(cantidadSeleccionada);

                    // Limpiar opciones anteriores
                    selectCantidad.innerHTML = "";

                    // Agregar nuevas opciones
                    const nuevoMax = Math.min(12, data.stock_disponible);
                    for (let i = 1; i <= nuevoMax; i++) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        if (i === cantidadAnterior) {
                            option.selected = true;
                        }
                        selectCantidad.appendChild(option);
                    }

                    // Si no hay stock disponible
                    if (data.stock_disponible <= 0) {
                        selectCantidad.disabled = true;
                        botonSubmit.disabled = true;
                        mensajeDiv.innerHTML += `<div class="alert alert-warning mt-3">No hay stock disponible.</div>`;
                    } else {
                        // Si hay stock, habilitar controles
                        selectCantidad.disabled = false;
                        botonSubmit.disabled = false;
                    }
                });
            }
        })
        .catch(error => {
            console.error("Error al agregar al carrito:", error);
            mensajeDiv.innerHTML = `<div class="alert alert-danger">Ocurrió un error al agregar el producto.</div>`;
        });
    });
});
</script>
