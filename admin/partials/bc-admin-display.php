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
$sql    = "SELECT id,nombre FROM " . BC_TABLE;
$result = $this->db->get_results( $sql );
?>
<div class="had-container">

	<div class="row">
		<div class="col s12">
			<h5><?php echo esc_html( get_admin_page_title() ) ?></h5>
		</div>
	</div>

	<div class="row">
		<!-- <div class="col s4 "> -->
			<button class="btn-floating pulse boton-modal" style="margin-bottom: 7px; ">
				<i class="material-icons">add</i>
			</button>
			<span style="font-size: 1.5rem;">Crear nueva tabla de datos</span>
		<!-- </div> -->
	</div>

	<!-- INICIO TABLA -->
	<div class="row ">
		<div class="col s7">
			<table class="striped table-responsive bordered">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Shortcode</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach($result as $k => $v)
						{ 
							$id     = $v->id;
							$nombre = $v->nombre;
						?>
						<tr bc-table-id="<?php echo $id ?>">
							<td><?php echo $nombre ?></td>
							<td>[bcdatos id=<?php echo $id ?>]</td>
							<td>
								<button data-bc-edit-id="<?php echo $id ?>" class="btn-floating waves-ligh btn">
									<i class="material-icons">edit</i>
								</button>
								<button data-bc-remove-id="<?php echo $id ?>" class="btn-floating waves-ligh btn red">
									<i class="material-icons">delete</i>
								</button>
							</td>
						</tr>	

					<?php } ?>
					
				</tbody>
			</table>
		</div>
	</div>

	<!-- FIN TABLA -->
	
	<!-- INICIO MODAL -->
	<div class="row">
		  <!-- Modal Structure -->
		  <div id="add_bc_table" class="modal">
		    <div class="modal-content">
		        <div class="bc_preloader">
		        	<div  class="preloader-wrapper small active">
		        	    <div class="spinner-layer spinner-green-only">
		        	      <div class="circle-clipper left">
		        	        <div class="circle"></div>
		        	      </div><div class="gap-patch">
		        	        <div class="circle"></div>
		        	      </div><div class="circle-clipper right">
		        	        <div class="circle"></div>
		        	      </div>
		        	    </div>
		        	</div>
		        </div>
		    	<form method="POST">
		    		
		    		<div class="row">
    				
		    			<div class="input-field  col s7">
		    				<input id="nombre-tabla" type="text" class="validate" name="nombre-tabla">
		    				<span id="requerido" class="red-text darken hide">Debes escribir el nombre de la tabla</span>
		    				<label for="nombre">Nombre de la tabla</label>
		    			</div>
		    		</div>

		    	</form>

		    </div>
		    <div class="modal-footer">
		      <button id="crear-tabla" class="waves-effect waves-light btn" ">
				<i class="material-icons left">add</i>
		      	Crear Tabla
		  	  </button>
		    </div>
		  </div>
	</div>
</div>