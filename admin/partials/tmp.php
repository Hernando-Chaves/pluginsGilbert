<?php

/**
  * Proporcionar una vista de área de administración para el plugin
  *
  * Este archivo se utiliza para marcar los aspectos de administración del plugin.
  *
  * @link http://misitioweb.com
  * @since desde 1.0.0
  *
  * @package Beziercode_blank
  * @subpackage Beziercode_blank/admin/parcials
  */

/* Este archivo debe consistir principalmente en HTML con un poco de PHP. */

?>

<div class="had-container">

	<div class="row">
		<div class="col s12">
			<h5><?php echo esc_html(get_admin_page_title()) ?></h5>
		</div>
	</div><!-- Fin Titulo -->

	<div class="row">
		<button class="add_bc_table btn btn-floating pulse green accent-3" style="margin-bottom: 10px;margin-right: 10px;">
			<i class="material-icons right">add</i>
		</button>
		<span style="font-size: 25px;margin-top: 50px;">Crear Nueva tabla</span>
	</div><!-- Fin Boton -->

	<!-- Tabla de datos -->
	<div class="row">
		<div class="col s6">
			<table class="striped responsive-table">
			       <thead>
			         <tr>
			             <th>Nombre</th>
			             <th>Shortcode</th>
			             <th></th>
			             <th></th>
			         </tr>
			       </thead>
			
			       <tbody>
			         <tr>
			           <td>Prueba 1</td>
			           <td>[shortcode id=5]</td>
			           <td>
			           		<span class="btn btn-floating waves-effect waves-light light-blue">
			           			<i class="tiny material-icons">mode_edit</i>
			           		</span>
			           </td>
			           <td>
			           	<span class="btn btn-floating waves-effect waves-light red darken">
			           		<i class="tiny material-icons">close</i>
			           	</span>
			           </td>
			         </tr>
			         
			       </tbody>
			</table>
		</div>
	</div>


	<!-- Modal Structure -->
	<div class="row">
		<div id="add_bc_table" class="modal">
		  <div class="modal-content">
		  	<!-- Preload -->
		  		<div class="precargador">
		  			<div class="progress">
		  				<div class="indeterminate"></div>
		  			</div>
		  		</div>
		  	<!--Fin Preload -->
		    <form method="POST">
		    	<div class="row">
		    		<div class="input-field col s7">
		    			<input id="nombre_tabla" type="text" class="validate">
		    			<span id="requerido" class="red-text darken hide">Debes escribir el nombre de la tabla</span>
		    			<label for="nombre">Nombre de la tabla</label>
		    		</div>
		    	</div>
		    </form>
		  </div>
		  <div class="modal-footer">
		    <button id="crear_tabla" class="btn waves-effect waves-light green accent-3">
		    	<i class="material-icons left">add</i>
		    	Crear</button>
		  </div>
		</div>
	</div><!-- fin Modal -->
</div>

