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

    mensajeDiv.innerHTML = ""; // Limpiar mensajes previos

    const idProducto = form.querySelector('input[name="id_producto"]').value;
    const cantidadSeleccionada = selectCantidad.value;

    fetch(`${configDetalleProducto.urlAgregarCarrito}${idProducto}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: new URLSearchParams({
        cantidad: cantidadSeleccionada,
      }),
    })
      .then(async (response) => {
        if (response.status === 401) {
          const data = await response.json();
          if (data.redirect) {
            window.location.href = data.redirect;
          } else {
            mensajeDiv.innerHTML = `<div class="alert alert-danger">No autorizado. Por favor inicie sesión.</div>`;
          }
          return;
        }

        if (response.status === 400 || response.status === 404) {
          const msg = await response.text();
          mensajeDiv.innerHTML = `<div class="alert alert-danger">${msg}</div>`;
          return;
        }

        if (!response.ok) {
          mensajeDiv.innerHTML = `<div class="alert alert-danger">Error inesperado al agregar el producto. Intente nuevamente.</div>`;
          return;
        }

        const data = await response.json();

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

        mostrarPopup(
          configDetalleProducto.imagenProducto,
          configDetalleProducto.descripcionProducto,
          cantidadSeleccionada
        );
      })
      .catch((error) => {
        console.error("Error al agregar al carrito:", error);
        mensajeDiv.innerHTML = `<div class="alert alert-danger">Ocurrió un error inesperado al agregar el producto.</div>`;
      });
  });

  function mostrarPopup(imagenURL, descripcion, cantidad) {
    const popup = document.getElementById("popupCarrito");
    const img = document.getElementById("popupImagenProducto");
    const desc = document.getElementById("popupDescripcionProducto");

    img.src = imagenURL;
    desc.textContent = `${descripcion} - ${cantidad} unidad${
      cantidad > 1 ? "es" : ""
    }`;

    popup.classList.add("mostrar");

    setTimeout(() => {
      popup.classList.remove("mostrar");
    }, 5000);
  }
});
