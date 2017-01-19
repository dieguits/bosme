<?php
$htm = '';
$deplega1 = '<ul role="menu" class="dropdown-menu">';
$desplega2 = '</ul>';
foreach ($menuspadres->result() as $menupadre) {
    ?>
    <li class="dropdown">
        <?php
        if ($menupadre->SUBNIVEL == '-1') {
            if ($menupadre->RUTA == '#') {
                ?>
                <a aria-expanded="false" role="button" href="<?php echo $menupadre->RUTA; ?>" 
                   class="dropdown-toggle" data-toggle="dropdown">
<?php 
            }else { ?>
                <a aria-expanded="false" role="button" href="<?php echo $menupadre->RUTA; ?>" >
<?php
            }
            
            echo $menupadre->DESCR;
            if ($menupadre->RUTA == '#') { ?>
                <span class="caret"></span>
<?php
            } ?>
                </a>
<?php       foreach ($menushijos->result() as $menuhijo) {
                    if (intval($menupadre->SEQ_MENU) == intval($menuhijo->SUBNIVEL)) {

                        $htm .= '<li><a href="' . $menuhijo->RUTA . '">' . $menuhijo->DESCR . '</a></li> ';
                    }
                    
                }
                echo $deplega1 . $htm . $desplega2;
                $htm = '';
            }
            ?>
    </li>
    <?php
}
?>
