<?php

foreach ($servicios as $servicio) {
    ?>
    <tr id="tr_<?php echo $servicio->NRO_SERVICIO; ?>" class="gradeX">
        <td>
            <?php echo $servicio->EST_DESCR; ?>
        </td>
        <td>
            <?php echo $servicio->FECHA_SERVICIO; ?>
        </td>
        <td>
            <span data-toggle="tooltip" title="<?php echo $servicio->OBSERVACIONES; ?>"><?php echo $servicio->SERV_DESCR; ?></span>
        </td>
        <td class="center">
            <?php echo '$'.$servicio->VALOR; ?>
        </td>
        <td class="center">
            <?php echo $servicio->FECHA_SOLICITA; ?>   
        </td>
        <td>
            <?php echo $servicio->NRO_FACTURA; ?>
        </td>
        <td>
            <?php echo $servicio->FECHA_RADICADO; ?>
        </td>
    </tr>

<?php } ?>

