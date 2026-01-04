<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Estudiantes</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        input, button {
            padding: 8px;
            margin: 6px 0;
            width: 300px;
        }

        button {
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 70%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Registrar / Editar Estudiante</h2>

<form id="formEstudiante">
    <!-- ID OCULTO PARA EDITAR -->
    <input type="hidden" id="estudiante_id">

    <input type="text" id="nombre" placeholder="Nombre" required><br>
    <input type="email" id="email" placeholder="Email" required><br>

    <button type="submit">Guardar</button>
</form>

<h2>Lista de Estudiantes</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="tablaEstudiantes"></tbody>
</table>

<script>
const API_URL = "http://127.0.0.1:8000/api/estudiantes";

/* =========================
   GET - CARGAR ESTUDIANTES
   ========================= */
function cargarEstudiantes() {
    fetch(API_URL)
        .then(res => res.json())
        .then(data => {
            const tabla = document.getElementById('tablaEstudiantes');
            tabla.innerHTML = '';

            data.forEach(est => {
                tabla.innerHTML += `
                <tr>
                    <td>${est.id}</td>
                    <td>${est.nombre}</td>
                    <td>${est.email}</td>
                    <td>
                        <button onclick="editarEstudiante(${est.id}, '${est.nombre}', '${est.email}')"> Editar</button>
                        <button onclick="eliminarEstudiante(${est.id})"> Eliminar</button>
                    </td>
                </tr>
                `;
            });
        })
        .catch(err => console.error("Error GET:", err));
}

/* =========================
   POST / PUT - GUARDAR / EDITAR
   ========================= */
document.getElementById('formEstudiante').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('estudiante_id').value;

    const estudiante = {
        nombre: document.getElementById('nombre').value,
        email: document.getElementById('email').value
    };

    let url = API_URL;
    let method = 'POST';

    if (id) {
        url = `${API_URL}/${id}`;
        method = 'PUT';
    }

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(estudiante)
    })
    .then(res => res.json())
    .then(() => {
        alert(id ? "✏️ Estudiante actualizado" : " Estudiante guardado");
        document.getElementById('formEstudiante').reset();
        document.getElementById('estudiante_id').value = '';
        cargarEstudiantes();
    })
    .catch(err => console.error("Error POST/PUT:", err));
});

/* =========================
   EDITAR
   ========================= */
function editarEstudiante(id, nombre, email) {
    document.getElementById('estudiante_id').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('email').value = email;
}

/* =========================
   DELETE - ELIMINAR
   ========================= */
function eliminarEstudiante(id) {
    if (!confirm("¿Seguro que deseas eliminar este estudiante?")) return;

    fetch(`${API_URL}/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(() => {
        alert("Estudiante eliminado");
        cargarEstudiantes();
    })
    .catch(err => console.error("Error DELETE:", err));
}

/* =========================
   CARGA INICIAL
   ========================= */
cargarEstudiantes();
</script>

</body>
</html>
