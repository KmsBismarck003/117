<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario - Exploración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulario Oftalmológico: Segmento Anterior</h4>
        </div>
        <div class="card-body">
            <form action="guardar_segmento.php" method="POST">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Estructura</th>
                                <th>Ojo Derecho</th>
                                <th>Ojo Izquierdo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><label class="form-label">Párpados</label></td>
                                <td><input type="text" name="parpados_od" class="form-control" placeholder="Ej: SIN ALTERACIONES" required></td>
                                <td><input type="text" name="parpados_oi" class="form-control" placeholder="Ej: SIN ALTERACIONES" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Conjuntiva Tarsal</label></td>
                                <td><input type="text" name="conjuntiva_tarsal_od" class="form-control" placeholder="Ej: SIN ALTERACIONES" required></td>
                                <td><input type="text" name="conjuntiva_tarsal_oi" class="form-control" placeholder="Ej: SIN ALTERACIONES" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Conjuntiva Bulbar</label></td>
                                <td><input type="text" name="conjuntiva_bulbar_od" class="form-control" placeholder="Ej: NORMOCROMICA" required></td>
                                <td><input type="text" name="conjuntiva_bulbar_oi" class="form-control" placeholder="Ej: NORMOCROMICA" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Córnea</label></td>
                                <td><input type="text" name="cornea_od" class="form-control" placeholder="Ej: TRANSPARENTE" required></td>
                                <td><input type="text" name="cornea_oi" class="form-control" placeholder="Ej: TRANSPARENTE" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Cámara Anterior</label></td>
                                <td><input type="text" name="camara_anterior_od" class="form-control" placeholder="Ej: FORMADA SIN CELULARIDAD O FLARE" required></td>
                                <td><input type="text" name="camara_anterior_oi" class="form-control" placeholder="Ej: FORMADA SIN CELULARIDAD O FLARE" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Iris</label></td>
                                <td><input type="text" name="iris_od" class="form-control" placeholder="Ej: SIN ALTERACIONES" required></td>
                                <td><input type="text" name="iris_oi" class="form-control" placeholder="Ej: SIN ALTERACIONES" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Pupila</label></td>
                                <td><input type="text" name="pupila_od" class="form-control" placeholder="Ej: ISOCÓRICA, NORMOREFLÉTICA" required></td>
                                <td><input type="text" name="pupila_oi" class="form-control" placeholder="Ej: ISOCÓRICA, NORMOREFLÉTICA" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Cristalino</label></td>
                                <td><input type="text" name="cristalino_od" class="form-control" placeholder="Ej: SIN OPACIDADES" required></td>
                                <td><input type="text" name="cristalino_oi" class="form-control" placeholder="Ej: SIN OPACIDADES" required></td>
                            </tr>
                            <tr>
                                <td><label class="form-label">LOCS III</label></td>
                                <td>
                                    <select name="locs_od" class="form-select">
                                        <option value="No seleccionado">No seleccionado</option>
                                        <option value="NC">NC</option>
                                        <option value="C">C</option>
                                        <option value="P">P</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="locs_oi" class="form-select">
                                        <option value="No seleccionado">No seleccionado</option>
                                        <option value="NC">NC</option>
                                        <option value="C">C</option>
                                        <option value="P">P</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label class="form-label">Gonioscopía</label></td>
                                <td><input type="text" name="gonioscopia_od" class="form-control" placeholder="Ej: ANGULO ABIERTO" required></td>
                                <td><input type="text" name="gonioscopia_oi" class="form-control" placeholder="Ej: ANGULO ABIERTO" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" rows="4" class="form-control" placeholder="Escriba las observaciones aquí..."></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Guardar</button>
                    <a href="listar_segmento.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
