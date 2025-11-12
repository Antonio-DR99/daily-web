<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos Eladio</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="icon" href="icons/ico.png" type="image/x-icon">
</head>
<body>
    <!--Modal / Lightbox: muestra la imagen ampliada y permite navegar entre ellas -->
    <div id="miModal" class="modal">
        <div class="modal-contenido">
            <div class="modal-header">
                <span>Galeria Eladio</span>
                <span class="cerrar" onclick="cerrarModal()">&times;</span>
            </div>
            <img id="imagenModal" src="" alt="Imagen ampliada">
            <button id="btnAnterior" class="btn-navegar">&#10094;</button>
            <button id="btnSiguiente" class="btn-navegar">&#10095;</button>
        </div>
    </div>
        
    <!-- Bloque PHP principal: noticias, canciones, galería y reproductor -->
    <?php
        $diasValidos = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];


        if (isset($_GET["diaSemana"]) && $_GET["diaSemana"] !== ""){
            $diaSemana = $_GET['diaSemana'];

            //normalizamos 
            $diaSemana=ucfirst(strtolower($diaSemana));

            // Validar que sea un día permitido
            if (!in_array($diaSemana, $diasValidos)) {
                echo '
                    <div class="ventana-error-win95">
                        <div class="barra-titulo-error">
                            <span class="titulo-error">Error</span>
                            <button class="btn-cerrar-error">×</button>
                        </div>
                        <div class="contenido-error">
                            <img src="icons/error.png" alt="Error" class="icono-error">
                            <span>Día inválido seleccionado.</span>
                        </div>
                        <div class="botones-error">
                            <button class="btn-error">Aceptar</button>
                        </div>
                    </div>';
                    $diaSemana = date("l"); // Revertimos al día actual
            }
        }else{
            $diaSemana = date("l");
        }

        if ($diaSemana==="Saturday" || $diaSemana==="Sunday" || $diaSemana==="Friday") {
            $rutaHeaderFinde="includes/";
            include($rutaHeaderFinde."headerFindes.php");
        }else{
            $rutaheader="includes/"; 
            include($rutaheader."header.php");
        }
    ?>

    <div class="ventana-win95">
    <div class="barra-titulo-win95">
        <span class="titulo-win95">Selecciona el día</span>
        <div class="botones-win95">
        <button class="btn-win95 btn-min">_</button>
        <button class="btn-win95 btn-max">□</button>
        <button class="btn-win95 btn-close">×</button>
        </div>
    </div>

    <div class="contenido-win95">
        <form method="get" action="index.php" class="form-win95">
        <select name="diaSemana" id="diaSemana">
            <option value="">Día actual</option>
            <option value="Monday">Lunes</option>
            <option value="Tuesday">Martes</option>
            <option value="Wednesday">Miércoles</option>
            <option value="Thursday">Jueves</option>
            <option value="Friday">Viernes</option>
            <option value="Saturday">Sábado</option>
            <option value="Sunday">Domingo</option>
        </select>
        <button type="submit" class="boton-win95">Aceptar</button>
        </form>
    </div>
    </div>

    <?php    
        $noticias="noticias/"; //?ruta para noticas
        $includes="includes/"; //?ruta para canciones
        $canciones="musica/"; //?ruta para canciones

        //$diaSemana="Monday";
        echo '<div class="noticia">';
            switch ($diaSemana) {
                case 'Monday':
                    include($noticias."lunes.php");
                    break;
                case 'Tuesday':
                    include($noticias."martes.php");
                    break;
                case 'Wednesday':
                    include($noticias."miercoles.php");
                    break;
                case 'Thursday':
                    include($noticias."jueves.php");
                    break;
                case 'Friday':
                    include($noticias."viernes.php");
                    break;
                case 'Saturday':
                    include($noticias."sabado.php");
                    break;
                case 'Sunday':
                    include($noticias."domingo.php");
                    break;
                default:
                    # code...
                    break;
            }
        echo '</div>';

        //!seleccionar el archivo con las canciones
        if ($diaSemana == 'Monday' || $diaSemana == 'Tuesday' || $diaSemana == 'Wednesday') {
            include($includes."primero.php"); 
        } else {
            include($includes."segundo.php"); 
        }


        //!Usamos el día como semilla para que las canciones aleatorias sean iguales todo el día
        //mt_srand(crc32($dia)); // crc32 transforma el string en número
        //shuffle($canciones);    

        //!mostrar 5 canciones aleatorias
        $cancionesRandom=array_rand($canciones,5);
        
        echo '<table id="tablaCanciones" border="1" cellspacing="0" cellpadding="5">';
        echo '<thead><tr><th>Canciones del día <span id="toggleCanciones" style="cursor:pointer;">Desplegar</span></th></tr></thead>';
        echo '<tbody id="cuerpoCanciones" style="display:none;">';

        foreach($cancionesRandom as $key){
            echo '<tr><td>' . $canciones[$key] . '</td></tr>';
        }

        echo '</tbody></table>';

        //!Obtener todos los archivos de la carpeta imagenes/
        $imagenes = glob("image/*.{jpg,jpeg,png,gif}", GLOB_BRACE);

       //!Seleccionar 3 imágenes aleatorias (o menos si hay menos de 3)
        $imagenesRandom = array_rand($imagenes, min(4, count($imagenes)));

            echo "
                <div class='ventana-retro-gallery'>
                    <div class='barra-titulo'>
                        <span class='titulo'>Galería de imágenes</span>
                        <div class='botones'>
                        <button class='btn-min'></button>
                        <button class='btn-max'></button>
                        <button class='btn-close'></button>
                        </div>
                    </div>
                <div class='contenido-retro'>
                    <div class='gallery'>
                ";

                foreach ((array)$imagenesRandom as $key) {
                    echo "<img src='" . $imagenes[$key] . "' alt='Imagen del artista' class='imagen' onclick='abrirModal(this.src)'>";
                }
            echo "
                </div>
                </div>
                </div>
            ";

        //!Obtener todos los archivos de la carpteta musica
        //?Obtener todos los mp3
        $canciones = glob("musica/*.mp3");

        //?Usar fecha como semilla
        $fecha = date("Y-m-d"); // Cada día distinta

        //?Mezclar canciones
        shuffle($canciones);

        // Seleccionar 2 canciones del día
        $cancionesDelDia = array_slice($canciones, 0, 2);

        //!Mostrar en reproductor
        echo '<div class="reproductor-musica">';
        foreach($cancionesDelDia as $cancion){
            echo '<div class="reproductor-retro">';
            echo '<div class="titulo-cancion">' . basename($cancion) . '</div>';
            echo '<div class="controles-cancion">';
            echo '<audio controls class="audio-cancion">';
            echo '<source src="'.$cancion.'" type="audio/mpeg">';
            echo 'Tu navegador no soporta la reproducción de audio.';
            echo '</audio></div></div>';
        }
        echo '</div>';

        if ($diaSemana==="Saturday" || $diaSemana==="Sunday" || $diaSemana==="Friday") {
            $rutaFooterFinde="includes/"; 
            include($rutaFooterFinde."footerFindes.php"); 
        }else{
            $rutafooter="includes/"; 
            include($rutafooter."footer.php");

        }
    ?>

    <script src="funcion.js"></script>
</body>
</html>