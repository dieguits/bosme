<?php
foreach ($servicios as $servicio) {
    ?>

    <tr id="tr<?php echo $servicio->NRO_SERVICIO; ?>" click="obtenerValores()">

        <td>
            <input id="NRO_SERVICIO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->NRO_SERVICIO; ?>" />
            <input id="NRO_SOLICITUD<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->NRO_SOLICITUD; ?>" />
            <input id="TIPO_SERVICIO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->TIPO_SERVICIO; ?>" />
            <input id="SERV_DESCR<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->SERV_DESCR; ?>" />
            <input id="COD_ESTADO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->COD_ESTADO; ?>" />
            <input id="EST_DESCR<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->EST_DESCR; ?>" />
            <input id="FECHA_SOLICITA<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo date_format(new DateTime($servicio->FECHA_SOLICITA), 'd/m/y'); ?>" />
            <input id="VALOR<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->VALOR; ?>" />
            <input id="CANTIDAD<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->CANTIDAD; ?>" />
            <input id="FECHA_SERVICIO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo date_format(new DateTime($servicio->FECHA_SERVICIO), 'd/m/y'); ?>" />
            <input id="OBSERVACIONES<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->OBSERVACIONES; ?>" />
            <input id="USR_SOLICITA<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->USR_SOLICITA; ?>" />
            <input id="NOM_COMPLE<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->NOM_COMPLE; ?>" />
            <input id="NRO_FACTURA<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->NRO_FACTURA; ?>" />
            <input id="EST_DESCR<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->EST_DESCR; ?>" />
            <input id="COMISION<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->COMISION; ?>" />
            <?php
                if($servicio->FECHA_RADICADO == '') {
            ?>
            <input id="FECHA_RADICADO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->FECHA_RADICADO; ?>" />
            <?php 
                }else { 
            ?>
            <input id="FECHA_RADICADO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo date_format(new DateTime($servicio->FECHA_RADICADO), 'd/m/y'); ?>" />
            <?php } ?>
            <input id="ARCHIVO<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->ARCHIVO; ?>" />
            <input id="OBS_TRAMITE<?php echo $servicio->NRO_SERVICIO; ?>" type="hidden" value="<?php echo $servicio->OBS_TRAMITE; ?>" />
                <?php echo $servicio->EST_DESCR; ?>
        </td>
        <td>
            <?php echo $servicio->SERV_DESCR; ?>
        </td>
        <td>
            <?php echo $servicio->NOM_COMPLE; ?>
        </td>
        <td>
            <?php echo $servicio->FECHA_SERVICIO; ?>
        </td>
        <!--td class="center">
            < ?php echo $servicio->OBSERVACIONES; ?>
        </td-->
        <td class="center">
            <?php echo $servicio->NRO_FACTURA; ?>
        </td>
        <td>
            <input id="editar_<?php echo $servicio->NRO_SERVICIO; ?>" type="button" 
                   onclick="obtenerValores(this)" value="editar"
                   class="btn btn-sm btn-default">
        </td>

    </tr>

    <?php
}
?>
