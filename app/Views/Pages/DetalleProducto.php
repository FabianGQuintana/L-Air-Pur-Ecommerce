<?= $this->extend('Templates/main_layout') ?>
<?= $this->section('content') ?>

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

<?= $this->section('popup') ?>
<?php if (!empty($mostrar_popup)): ?>
    <style>
        #popupCarrito {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 320px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0;
            transform: translateY(100%);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        #popupCarrito.mostrar {
            opacity: 1;
            transform: translateY(0);
        }

        .popup-contenido {
            text-align: center;
        }

        .popup-imagen {
            position: relative;
        }

        .popup-imagen img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .popup-check {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            padding: 4px 7px;
            font-size: 14px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        .popup-texto strong {
            font-size: 16px;
            display: block;
            margin-top: 8px;
        }

        .popup-texto p {
            margin: 4px 0 0 0;
            font-size: 14px;
            color: #555;
        }

        .popup-botones {
            margin-top: 12px;
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .popup-botones .btn {
            font-size: 12px;
            padding: 4px 10px;
        }

        @media (max-width: 576px) {
            #popupCarrito {
                width: 90%;
                right: 5%;
                bottom: 10px;
            }
        }
    </style>

    <div id="popupCarrito" class="popup-carrito shadow rounded">
        <div class="popup-contenido">
            <div class="popup-imagen">
                <img id="popupImagenProducto" src="" alt="Producto">
                <div class="popup-check">&#10004;</div>
            </div>
            <div class="popup-texto mt-2">
                <strong>Agregaste a tu carrito</strong>
                <p id="popupDescripcionProducto" class="mb-1"></p>
            </div>
            <div class="popup-botones">
                <a href="<?= base_url('/Productos') ?>" class="btn btn-dark btn-sm">Ver más productos del Catalogo</a>
                <a href="<?= base_url('/Carrito') ?>" class="btn btn-outline-secondary btn-sm">Ir al carrito</a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<!-- Script AJAX -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formAgregarCarrito");
    const mensajeDiv = document.getElementById("mensajeCarrito");
    const stockTexto = document.getElementById("stockDisponibleTexto");
    const stockLista = document.getElementById("stockDisponibleLista");
    const selectCantidad = document.getElementById("cantidad");
    const botonSubmit = form.querySelector("button[type='submit']");

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
                    // No mostrar mensaje de éxito aquí

                    // Actualizar stock
                    stockTexto.textContent = `${data.stock_disponible} disponibles`;
                    stockLista.textContent = data.stock_disponible;

                    const cantidadAnterior = parseInt(cantidadSeleccionada);
                    selectCantidad.innerHTML = "";
                    const nuevoMax = Math.min(12, data.stock_disponible);
                    for (let i = 1; i <= nuevoMax; i++) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        if (i === cantidadAnterior) option.selected = true;
                        selectCantidad.appendChild(option);
                    }

                    if (data.stock_disponible <= 0) {
                        selectCantidad.disabled = true;
                        botonSubmit.disabled = true;
                        mensajeDiv.innerHTML = `<div class="alert alert-warning mt-3">No hay stock disponible.</div>`;
                    } else {
                        selectCantidad.disabled = false;
                        botonSubmit.disabled = false;
                    }

                    // Mostrar popup animado
                    mostrarPopup(
                        "<?= base_url('assets/img/' . $producto['imagen']) ?>",
                        "<?= esc($producto['nombre']) ?> <?= esc($producto['mililitros']) ?> mL",
                        cantidadSeleccionada
                    );
                });
            }
        })
        .catch(error => {
            console.error("Error al agregar al carrito:", error);
            mensajeDiv.innerHTML = `<div class="alert alert-danger">Ocurrió un error al agregar el producto.</div>`;
        });
    });

    function mostrarPopup(imagenURL, descripcion, cantidad) {
        const popup = document.getElementById("popupCarrito");
        const img = document.getElementById("popupImagenProducto");
        const desc = document.getElementById("popupDescripcionProducto");

        img.src = imagenURL;
        desc.textContent = `${descripcion} - ${cantidad} unidad${cantidad > 1 ? 'es' : ''}`;

        popup.classList.add("mostrar");

        setTimeout(() => {
            popup.classList.remove("mostrar");
        }, 4000);
    }
});
</script>

<?= $this->endSection() ?>
