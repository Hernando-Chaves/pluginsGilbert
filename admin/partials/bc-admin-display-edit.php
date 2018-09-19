<?php 
	$id     = $_GET['id'];
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
			<a href="?page=bc_data" class="btn-floating blue waves-effect waves-light " style="margin-bottom: 7px; ">
				<i class="material-icons">arrow_back</i>
			</a><br>
			<button class="btn-floating pulse add-item waves-effect waves-light" style="margin-bottom: 7px; ">
				<i class="material-icons">add</i>
			</button>
			<span style="font-size: 1.5rem;">Agregar Usuario</span>
		
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
							<td>[Shortcode id=<?php echo $id ?>]</td>
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
		  <div id="addUpdate" class="modal">
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
		    		<input id="idItem" type="hidden" value="<?php echo $id ?>">
		    		<div class="row">
    				
		    			<div class="input-field  col s7">
		    				<i class="material-icons prefix">account_circle</i>
		    				<input id="nombres" type="text" class="validate" name="nombres">
		    				<span id="requerido" class="red-text darken hide">Ingresa aquí tu nombre</span>
		    				<label for="nombres">Nombre</label>
		    			</div>

		    			<div class="input-field  col s7">
		    				<i class="material-icons prefix">account_circle</i>
		    				<input id="apellidos" type="text" class="validate" name="apellidos">
		    				<span id="requerido" class="red-text darken hide">Ingresa aquí tu apellido</span>
		    				<label for="apellidos">Apellidos</label>
		    			</div>

		    			<div class="input-field  col s7">
		    				<i class="material-icons prefix">email</i>
		    				<input id="correo" type="email" class="validate" name="correo">
		    				<span id="requerido" class="red-text darken hide">Ingresa aquí tu correo</span>
		    				<label for="correo">Correo</label>
		    			</div>
		    		</div>
		    		<div class="row">
		    			<div class="file-field input-field col s10">
	    			      <div id="selectImg" class="btn">
	    			        <span>
	    			        	Subir foto
	    			        	<i class="material-icons right">file_upload</i>
	    			        </span>
	    			        <input type="file">
	    			      </div>
	    			      <div class="file-path-wrapper">
	    			        <input id="selectImgVal" class="file-path validate" type="text">
	    			      </div>
	    			    </div>
	    			    <div class="col s2">
	    			    	<div class="marcoImg">
	    			    		<img src="" alt="">
	    			    	</div>
	    			    </div>
		    		</div>

		    	</form>

		    </div>
		    <div class="modal-footer">
		      <button id="agregar" class="waves-effect waves-light btn" ">
				<i class="material-icons left">add</i>
		      	Crear Usuario
		  	  </button>
		    </div>
		  </div>
	</div>
</div>