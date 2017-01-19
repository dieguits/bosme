<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Reporte de Terminaci&oacute;n</title>
        <?php date_default_timezone_set("America/Bogota"); ?>
        <style type="text/css">
            body {
                //font-family: courier new, "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                font-family: sans-serif, Helvetica, sans-serif;
            }

            label {
                font-family: sans-serif, Helvetica, sans-serif;
                font-weight: bold;
            }
            table {     
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
                font-size: 10px;  
                width: 450px;
                margin: 5px;
                text-align: left;    
                border-collapse: collapse; 
            }

            th {     
                font-size: 10px;     
                font-weight: normal;     
                padding: 4px;     
                background: #254BC2;
                //border-top: 4px solid #aabcfe;    
                border-bottom: 1px solid #fff; 
                color: #FFFFFF; 
                text-align: center;
            }
            td {    
                padding: 4px;     
                background: #F5F5F5;     
                border-bottom: 1px solid #fff;
                color: #669;    
                border-top: 1px solid transparent; 
            }

            tr:hover td { 
                background: #d0dafd; 
                color: #339; 
            }

            p {
                font-size: 12px;
                text-justify: inter-word;
            }

            .derecha {
                text-align: right;
            }

            .izquierda {
                text-align: left;
            }

            .centrado {
                text-align: center;
            }
            
            .firma {
                padding-left: 5px; 
                font-size: 12px; 
                font-weight: normal !important;
            }
        </style>
    </head>
    <body>
        <?php
        $total = 0;
        $total_sin_iva = 0;
        $total_iva = 0;
        $total_uni = 0;
        $total_canti = 0;
        ?>
        <div id="header" style="font-size: 12px; margin: 5px; text-align: center;">
            <label>ACTA DE LIQUIDACI&Oacute;N - BOSME</label>
        </div>
        <div style="font-size: 10px; text-align: center; font-weight: normal !important;">
            <label>Desde <?php echo $fechaini; ?> Hasta <?php echo $fechafin; ?></label>
            <br>
            <label><?php echo $proveedor; ?></label>
        </div>
        <br>
        <table style="width: 98%;" class="centrado" >
            <thead>
                <tr>
                    <th>FACTURA</th>
                    <th>FECHA FACTURA</th>
                    <th>VALOR UNI</th>
                    <th>CANTIDAD</th>
                    <th>VALOR SIN IVA</th>
                    <th>IVA</th>
                    <th>TOTAL</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($datos as $dato) {
                    $total += $dato->VALOR_IVA;
                    $total_sin_iva += $dato->VALOR_SIN_IVA;
                    $total_iva += $dato->IVA;
                    $total_uni += $dato->VALOR_UNITARIO;
                    $total_canti += $dato->CANTIDAD;
                    ?>
                    <tr>
                        <td class="centrado"><?php echo $dato->FACTURA; ?></td>
                        <td class="centrado"><?php echo $dato->FECHA_RADICADO; ?></td>
                        <td class="derecha">$<?php echo number_format($dato->VALOR_UNITARIO, 2, ',', '.'); ?></td>
                        <td class="derecha"><?php echo $dato->CANTIDAD; ?></td>
                        <td class="derecha">$<?php echo number_format($dato->VALOR_SIN_IVA, 2, ',', '.'); ?></td>
                        <td class="derecha">$<?php echo number_format($dato->IVA, 2, ',', '.'); ?></td>
                        <td class="derecha">$<?php echo number_format($dato->VALOR_IVA, 2, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2" class="izquierda" style="font-weight: bold; background: #EDEDED !important;">
                        Totales
                    </td>
                    <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                        <?php echo '$' . number_format($total_uni, 2, ',', '.'); ?>
                    </td>
                    <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                        <?php echo $total_canti; ?>
                    </td>
                    <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                        <?php echo '$' . number_format($total_sin_iva, 2, ',', '.'); ?>
                    </td>
                    <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                        <?php echo '$' . number_format($total_iva, 2, ',', '.'); ?>
                    </td>
                    <td class="derecha" style="background: #EDEDED !important;">
                        <?php echo '$' . number_format($total, 2, ',', '.'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br><br><br><br><br><br>
        <div>_________________________<br>
            <label class="firma"><?php echo $admin; ?></label><br>
            <label class="firma">Administrador</label><br>
            <label class="firma">Telebucaramanga</label><br>
        </div>
    </body>
</html>