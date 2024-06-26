<?php
include_once 'config.php';

// Consultar todos los productos
$sql = "SELECT * FROM Productos";
$stmt = $conn->query($sql);
if ($stmt === false) {
    die(print_r($conn->errorInfo(), true));
}

// Consultar datos para los desplegables
$catalogosSql = "SELECT DISTINCT nombre FROM Productos";
$catalogosStmt = $conn->query($catalogosSql);
if ($catalogosStmt === false) {
    die(print_r($conn->errorInfo(), true));
}

$marcasSql = "SELECT DISTINCT nombrePadre FROM Productos";
$marcasStmt = $conn->query($marcasSql);
if ($marcasStmt === false) {
    die(print_r($conn->errorInfo(), true));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD PHP y SQL Server</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Productos</h2>
            <div class="form-inline">
                <div class="form-group mr-2">
                    <label for="catalogoSelect" class="mr-2">Catálogos:</label>
                    <select id="catalogoSelect" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label for="marcasSelect" class="mr-2">Marcas:</label>
                    <select id="marcasSelect" class="form-control"></select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#agregarModal">Agregar nuevo</button>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Nombre Padre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="productosTableBody">
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr id="producto-<?php echo $row['id']; ?>">
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['nombrePadre']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editarModal<?php echo $row['id']; ?>">Editar</button>
                            <button class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(<?php echo $row['id']; ?>)">Eliminar</button>
                        </td>
                    </tr>

                    <!-- Modal de Edición -->
                    <div class="modal fade" id="editarModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel<?php echo $row['id']; ?>">Editar Producto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="update.php">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group">
                                            <label for="nombre">Nombre:</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombrePadre">Nombre Padre:</label>
                                            <input type="text" class="form-control" id="nombrePadre" name="nombrePadre" value="<?php echo $row['nombrePadre']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción:</label>
                                            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $row['descripcion']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar nuevo producto -->
    <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarModalLabel">Agregar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addProductForm" method="POST" action="create.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="nombrePadre">Nombre Padre:</label>
                            <input type="text" class="form-control" id="nombrePadre" name="nombrePadre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const catalogos = <?php echo json_encode($catalogosStmt->fetchAll(PDO::FETCH_COLUMN)); ?>;
        const marcas = <?php echo json_encode($marcasStmt->fetchAll(PDO::FETCH_COLUMN)); ?>;

        window.onload = function() {
            const catalogoSelect = document.getElementById('catalogoSelect');
            const marcasSelect = document.getElementById('marcasSelect');

            catalogos.forEach(function(catalogo) {
                const option = document.createElement('option');
                option.value = catalogo;
                option.text = catalogo;
                catalogoSelect.appendChild(option);
            });

            marcas.forEach(function(marca) {
                const option = document.createElement('option');
                option.value = marca;
                option.text = marca;
                marcasSelect.appendChild(option);
            });
        }

        let deleteUrl = '';

        function confirmDelete(id) {
            deleteUrl = 'eliminar.php?id=' + id;
            $('#confirmDeleteModal').modal('show');
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            window.location.href = deleteUrl;
        });

        document.getElementById('addProductForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('create.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#agregarModal').modal('hide');
                    const newRow = document.createElement('tr');
                    newRow.id = 'producto-' + data.id;
                    newRow.innerHTML = `
                        <td>${data.nombre}</td>
                        <td>${data.nombrePadre}</td>
                        <td>${data.descripcion}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editarModal${data.id}">Editar</button>
                            <button class="btn btn-sm btn-danger ml-1" onclick="confirmDelete(${data.id})">Eliminar</button>
                        </td>
                    `;
                    document.getElementById('productosTableBody').appendChild(newRow);
                    updateSelects();
                } else {
                    alert('Error al agregar producto');
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function updateSelects() {
            fetch('getSelectData.php')
                .then(response => response.json())
                .then(data => {
                    const catalogoSelect = document.getElementById('catalogoSelect');
                    const marcasSelect = document.getElementById('marcasSelect');

                    catalogoSelect.innerHTML = '';
                    marcasSelect.innerHTML = '';

                    data.catalogos.forEach(function(catalogo) {
                        const option = document.createElement('option');
                        option.value = catalogo;
                        option.text = catalogo;
                        catalogoSelect.appendChild(option);
                    });

                    data.marcas.forEach(function(marca) {
                        const option = document.createElement('option');
                        option.value = marca;
                        option.text = marca;
                        marcasSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
