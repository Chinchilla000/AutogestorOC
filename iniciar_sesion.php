

<?php include("templates/header.php"); ?>

<style>
    .custom-btn {
        width: 100%; /* Ancho completo para los botones */
    }

    /* Estilo personalizado para centrar el contenido */
    .custom-modal-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 70vh; /* Ajusta la altura si es necesario */
    }

    /* Estilo para centrar horizontalmente el contenido dentro de la modal */
    .modal-content-center {
        text-align: center;
    }
    @media (max-width: 768px) {
        .modal-content {
            width: 90%; /* Aumenta el ancho en pantallas pequeñas */
        }
    }
</style>

<div class="container-md custom-modal-container">
    <div class="modal-content rounded-4 shadow p-4 modal-content-center col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="modal-header border-bottom-0 justify-content-center">
            <h1 class="modal-title fs-5">Iniciar Sesión Como:</h1>
        </div>
        <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
            <button type="button" class="btn btn-lg btn-primary  custom-btn" onclick="window.location.href='./secciones/empresas/index_empresa.php'">Cuenta Empresa</button>
            <br>
            <button type="button" class="btn btn-lg btn-outline-primary btn-light custom-btn" data-bs-dismiss="modal" onclick="window.location.href='./secciones/empresas/gerente_general/iniciar_sesion_gerente.php'">Gerente General</button>
            <button type="button" class="btn btn-lg btn-outline-primary btn-light custom-btn" data-bs-dismiss="modal" onclick="window.location.href='./secciones/empresas/visitador_obra/iniciar_sesion_visitador_obra.php'">Visitador de Obra</button>
            <button type="button" class="btn btn-lg btn-outline-primary btn-light custom-btn" data-bs-dismiss="modal" onclick="window.location.href='./secciones/empresas/residente/iniciar_sesion_residente_obra.php'">Residente de Obra</button>

        </div>
        <div class="modal-body py-0">
            <p>Si aún no has registrado tu empresa, puedes hacerlo haciendo clic <a href="<?php echo $url_base;?>secciones/empresas/crear_cuenta_empresa.php" class="text-primary">aquí</a>.</p>
        </div>
    </div>
</div>

<?php include("templates/footer.php"); ?>
