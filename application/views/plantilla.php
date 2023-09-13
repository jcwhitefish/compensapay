<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Compensapay</title>
    <!-- importamos materialize usando base_url() -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/materialize.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- importamos iconos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>


    <?php
    if (false) {
    ?>
        <nav>
            <div class="nav-wrapper nav">
                <a href="#" class="bold">@Your Company</a>
                <div class="right hide-on-med-and-down px-3">
                    <button class="button-gray">Sign Up</button>
                    <button class="button-white">Login In</button>
                </div>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Pages</a></li>
                </ul>

            </div>
        </nav>
    <?php
    } else {
    ?>
        <nav>
            <div class="nav-wrapper nav-gray">
                <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="custom-image">
            </div>
        </nav>
    <?php
    }
    ?>
    <?php
    if (isset($main)) {
        echo $main;
    }
    ?>
    <script>
        if (typeof app !== 'undefined') {
            app.mount('#app');
        }
    </script>

    <!-- Ejecutor de scripts de materialize -->
    <script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
    <script>
        M.AutoInit();
    </script>

</body>

</html>