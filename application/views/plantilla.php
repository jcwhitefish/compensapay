<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Compensapay</title>
    <!-- importamos materialize usando base_url() -->
    <link rel="stylesheet" href="<?php echo base_url('css/materialize.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <!-- importamos iconos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/vuex@4.0.0/dist/vuex.global.js"></script>


        <?php
        if (isset($main)) {
            echo $main;
        }
        ?>
    <script>
        if (typeof app !== 'undefined' && typeof store !== 'undefined') {
            app.use(store);
            app.mount('#app');
        }
        else if(typeof app !== 'undefined') {
            app.mount('#app');
        }
    </script>

    <!-- Ejecutor de scripts de materialize -->
    <script src="<?php echo base_url(); ?>js/materialize.min.js"></script>
    <script>
        M.AutoInit();
    </script>

</body>

</html>