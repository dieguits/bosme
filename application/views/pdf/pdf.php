<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Reporte de Conciliacion</title>
        <?php date_default_timezone_set("America/Bogota"); ?>
        <!--style type="text/css">
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
        </style-->
    </head>
    <body>
        <!--?php
        $total = 0;
        $total_sin_iva = 0;
        $total_iva = 0;
        $total_uni = 0;
        $total_canti = 0;&Oacute;
        ?-->
        <div id="header" style="font-size: 12px; margin: 5px; text-align: center;">
            <label>REPORTE DE CONCILIACION - BOSME<!--?php var_dump($datos); ?--></label>
            
            <!--label>< ?= $dir; ?></label>
            <label>< ?= $ciudad; ?></label>
            <label style="font-weight: bold;">< ?= $telefono; ?></label -->
        </div>
        <!--div style="font-size: 10px; text-align: center; font-weight: normal;">
            <label>Desde <? php echo $fechaini; ?> Hasta <? php echo $fechafin; ?></label >
        </div-->
        <!--footer para cada pagina-->
        <!--div id="footer">
            <aqui se muestra el numero de la pagina en numeros romanos>
            <p class="page">
        <!--?= $variable; ?-->
    

    <br>
    <!--table style="width: 98%;" class="centrado" >
        <thead>
            <tr>
                <th>FACTURA</th>
                <th>VALOR UNI</th>
                <th>CANTIDAD</th>
                <th>VALOR SIN IVA</th>
                <th>IVA</th>
                <th>TOTAL</th> 
            </tr>
        </thead>
        <tbody>
            < ?php
            foreach ($datos as $dato) {
                $total += $dato->VALOR_IVA;
                $total_sin_iva += $dato->VALOR_SIN_IVA;
                $total_iva += $dato->IVA;
                $total_uni += $dato->VALOR_UNITARIO;
                $total_canti += $dato->CANTIDAD;
                ?>
                <tr>
                    <td class="centrado">< ?php echo $dato->FACTURA; ?></td>
                    <td class="derecha">$< ?php echo $dato->VALOR_UNITARIO; ?></td>
                    <td class="derecha"><? php echo $dato->CANTIDAD; ?></td>
                    <td class="derecha">$< ?php echo $dato->VALOR_SIN_IVA; ?></td>
                    <td class="derecha">$< ?php echo $dato->IVA; ?></td>
                    <td class="derecha">$< ?php echo $dato->VALOR_IVA; ?></td>
                </tr>
            < ?php } ?>
            <tr>
                <td colspan="2" class="izquierda" style="font-weight: bold; background: #EDEDED !important;">
                    Totales
                </td>
                <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                    < ?php echo '$' . $total_uni; ?>
                </td>
                <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                    < ?php echo $total_canti; ?>
                </td>
                <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                    < ?php echo '$' . $total_sin_iva; ?>
                </td>
                <td class="derecha" style="font-weight: bold; background: #EDEDED !important;">
                    < ?php echo '$' . $total_iva; ?>
                </td>
                <td class="derecha" style="background: #EDEDED !important;">
                    < ?php echo '$' . $total; ?>
                </td>
            </tr>
        </tbody>
    </table-->
    <!--br>
    <p>
        Las partes se declaran mutuamente a paz y salvo por las obligaciones contraídas en 
        virtud del Contrato y/o convenio, objeto de la presente liquidación.
    </p>
    <p>
        No obstante lo anterior, el contratista se obliga a responder en caso de cualquier 
        reclamación presentada por terceros a Telebucaramanga, por actividades ejecutadas en 
        desarrollo del Contrato y/o convenio, objeto de la presente liquidación.
    </p>
    <p>
        Para constancia de lo anterior se firma la presente acta por los que en ella intervinieron,
    </p-->
</body>
</html>