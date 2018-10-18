<?php 
	$id        = $_GET['id'];
	$sql       = $this->db->prepare("SELECT data FROM " . BC_TABLE . " WHERE id =  %d ", $id );
	$resultado = $this->db->get_var( $sql );

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
			<button id="btnAgregarUser" class="btn-floating pulse add-item waves-effect waves-light" style="margin-bottom: 7px; ">
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
						<th></th>
						<th>Nombre</th>
						<th>Apelidos</th>
						<th>Correo</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php echo $this->crud_json->readItems($resultado); ?>
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
		    	<form id="formData" method="POST">
		    		<input id="idTabla" type="hidden" value="<?php echo $id ?>">
		    		<h5></h5>
		    		<div class="row">
    				
		    			<div class="input-field  col s7">
		    				<i class="material-icons prefix">account_circle</i>
		    				<input id="nombres" type="text" class="validate" >
		    				<span id="requerido" class="red-text darken hide">Debes ingresar tu nombre</span>
		    				<label for="nombres">Nombre</label>
		    			</div>

		    			<div class="input-field  col s7">
		    				<i class="material-icons prefix">account_circle</i>
		    				<input id="apellidos" type="text" class="validate" >
		    				<span id="requerido" class="red-text darken hide">Debes ingresar tu apellido</span>
		    				<label for="apellidos">Apellidos</label>
		    			</div>

		    			<div class="input-field  col s7">
		    				<i class="material-icons prefix">email</i>
		    				<input id="correo" type="email" class="validate" >
		    				<span id="requerido" class="red-text darken hide">Debes ingresar tu correo</span>
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

		  	  <button data-id="" id="actualizar" class="waves-effect waves-light btn" ">
				<i class="material-icons left">cached</i>
		      	Actualizar
		  	  </button>
		    </div>
		  </div>
	</div>
</div>