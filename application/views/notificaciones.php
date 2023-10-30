<div class="p-5" id="app">
    <!-- TODO: Tenemos que poner todo este molde en div.row y en div.col  tmabien se tiene que usar flex para separar la fecha del texto de la notificacion-->
    <h5><i class="material-icons iconoSetting" style="color: #8127ff">filter_drama</i> Notificaciones y eventos</h5>
    <ul class="collapsible">
        <li>
            <div class="collapsible-header"><i class="material-icons">email</i>Tu factura del mes de septiembre ha sido procesada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">drafts</i>Tu factura del mes de Mayo ha sido procesada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">email</i>Tu factura del mes de Abril ha sido procesada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">drafts</i>Tu factura a Usuario ha sido procesada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">email</i>Tu factura ha sido eliminada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">email</i>Tu factura del mes de Marzo ha sido procesada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">settings</i>Se cambio el metodo de pago <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
    </ul>
    <h5><i class="material-icons iconoSetting" style="color: #8127ff">import_contacts</i> Bitacora de Usuario</h5>
    <ul class="collapsible">
        <li>
            <div class="collapsible-header"><i class="material-icons">manage_accounts</i>Actualización de estado: Jose a cambiado su estado.<span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">manage_accounts</i>Actualización de estado: Angel a cambiado su estado. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">settings</i>Tu factura del mes de Abril ha sido procesada con éxito. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">manage_accounts</i>Nueva conexión: AlfaroAlba ha aceptado ser tu provedor. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">manage_accounts</i>Nueva conexión: Cerocatorce ha aceptado ser tu cliente.<span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">manage_accounts</i>Nueva conexión: Jose ha aceptado ser tu cliente. <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">settings</i>¡Bienvenido a nuestra comunidad! Tu solicitud de membresía ha sido aceptada. Conéctate y comparte tus experiencias <span style="position:absolute;right:30px;">23 / 09 / 2023</span></div>
            <!-- <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div> -->
        </li>
    </ul>
</div>

<script>
    const {

        createApp,
        ref,
        onMounted,
        nextTick
    } = Vue;

    const app = createApp({});
</script>


<style>
    .iconoSetting {
        position: relative;
        top: 3px;
    }
</style>