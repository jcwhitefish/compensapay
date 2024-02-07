<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="p-5" id="app">
    <!-- TODO: Tenemos que poner todo este molde en div.row y en div.col  tmabien se tiene que usar flex para separar la fecha del texto de la notificacion-->
    <h5>Notificaciones</h5>
    <div class="row">
        <div class="col s12 esquinasRedondas card" style="padding:20px">
            <ul class="collapsible">
                <?php
                if(is_array($noti))
                {
                    foreach ($noti as $value)
                    {
                        if($value["readed"]==0){
                            $strong='<strong>';
                            $strong1='</strong>';
                            $icono='email';
                            $onclick='onclick="update_noti(\''.$value["id"].'\')"';
                        }
                        elseif($value["readed"]==1)
                        {
                            $strong='';
                            $strong1='';
                            $icono='drafts';
                            $onclick='';
                        }
                        echo '<li>
                                <div class="collapsible-header" id="n_'.$value["id"].'" '.$onclick.'>'.$strong.'<i class="material-icons" style="color:#9118bd">'.$icono.'</i><td>'.$value["title"].'<span style="position:absolute;right:30px;">'.date("d / m / Y", $value["create_at"]).'</span>'.$strong1.'</div>
                                <div class="collapsible-body">'.$value["body"].'</div>
                            </li>';
                    }
                }

                ?>
            </ul>
        </div>
    </div>
</div>

<script>
    const {

        createApp,
        ref,
        onMounted,
        nextTick
    } = Vue;

    const app = createApp({});

    function update_noti(idnoti){
    $.ajax({
				type: 'POST',
				url : '<?php echo base_url('notificaciones/updatenot/');?>' + idnoti
	}).done (function ( info ){
		$('#n_' + idnoti).html(info);
	});
}
</script>


<style>
    .iconoSetting {
        position: relative;
        top: 3px;
    }
</style>