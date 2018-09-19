<?php 
/**
 * PAR AGREGAR  ITEM DE MENU AL ESCRITORIO		
 */
1 - Llamamos el archivo includes/class-bc-build-menupage.php en la funcion cargar_dependencias
    del archivo class-bc-master, y lo incluimos antes del admin.
2 - Registramos la propiedad en el archivo class-bc-admin.php
3 - Creamos una instancia de la clase BC_Build_Menupage en el archivo class-bc-admin.php en el constructor
4 - Creamos el item de menu a traves de la instancia que acabamos de crear
5 - En esa msma funcion llamamos la funcion run() a traves de la instancia creada
6 - Ceamos la funcion callbac del add_menu_page y  requerimos el archivo admin/partials/bc-admin-display.php
7 - Agregamos al add_action('admin_menu','funcion creada ') en el archvo bc-master donde se cqargan los hooks.