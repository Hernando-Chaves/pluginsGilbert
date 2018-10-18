<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       http://misitioweb.com
 * @since      1.0.0
 *
 * @package    Beziercode_blank
 * @subpackage Beziercode_blank/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 * 
 * @since      1.0.0
 * @package    Beziercode-Blank
 * @subpackage Beziercode-Blank/admin
 * @author     Gilbert Rodríguez <email@example.com>
 * 
 * @property string $plugin_name
 * @property string $version
 */
class BC_Admin 
{
    
    /**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name  El nombre o identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;

    /**
     * Versión actual del plugin
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $build_menupage  instancia de BC_Build_Menupage
     */
    private $build_menupage;

     /**
     * Objeto wpdb
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $db global $wpdb
     */
    private $db;

     /**
     * Objeto BC_CRUD_JSON
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $crud_json  instancia de BC_CRUD_JSON
     */
    private $crud_json;
    
    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) 
    {

        $this->version        = $version; 
        $this->plugin_name    = $plugin_name;
        $this->build_menupage = new BC_Build_Menupage();
        global $wpdb;
        $this->db             = $wpdb;
        $this->crud_json      = new BC_CRUD_JSON();
        
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles($hook) 
    {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
         */
                /**
         * Verifica que se carguern solamente en lpágina del plugin 
         */          
        if($hook != "toplevel_page_bc_data")
        {
            return;
        }

        /**
         * Archivo del gestor wp media 
         */
        wp_enqueue_media();
          

        /**
         *Wordpress css 
         */
        wp_enqueue_style( "bc-wordpress-css", BC_PLUGIN_DIR_URL . 'admin/css/bc-wordpress.css', [], $this->version, 'all' );
        
        /**
         * Materialize 
         */
        wp_enqueue_style( 'materialize_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', [], $this->version, 'all' );
        wp_enqueue_style( 'materialize_admin', BC_PLUGIN_DIR_URL . 'helpers/materialize/css/materialize.min.css', [], '0.100.1', 'all' );
        /**
         * Sweet Alert 
         */
        wp_enqueue_style( 'sweet_alert_admin_css', BC_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.css', [], $this->version, 'all' );
        /**
         *Admin css 
         */
        wp_enqueue_style( $this->plugin_name, BC_PLUGIN_DIR_URL . 'admin/css/bc-admin.css', [], $this->version, 'all' );
        

    }
    
    /**
     * Registra los archivos Javascript del área de administración
     *
     * @since    1.0.0
     * @access   public
     */
    public function enqueue_scripts($hook) 
    {
        /**
         * Verifica que se carguen solamente en la página del plugin 
         */ 
        if($hook != "toplevel_page_bc_data")
        {
            return;
        }
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
         */

        /**
         * Materialize 
         */
        wp_enqueue_script( 'materialize', BC_PLUGIN_DIR_URL . 'helpers/materialize/js/materialize.min.js', ['jquery'], $this->version,true);
        /**
         * Sweet Alert 
         */ 
        wp_enqueue_script( 'sweet_alert_admin_js', BC_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.min.js', ['jquery'], $this->version, true );
        /**
         * bc admn js
         * archivo js principal de la administración        
         */
        wp_enqueue_script( $this->plugin_name, BC_PLUGIN_DIR_URL . 'admin/js/bc-admin.js', ['jquery'], $this->version, true );
        /**
         * Agrega AJAX 
         */
        wp_localize_script( $this->plugin_name, 'bcdata', 
            [
                'url'      => admin_url('admin-ajax.php'),
                'seguridad'=> wp_create_nonce('bcdata_seg')
            ]);

    }
    /**
     * Agrega el menu en el area de administración
     *
     * @since    1.0.0
     * @access   public
     */
    public function bc_add_menu()
    {
       $this->build_menupage->add_menu_page( 
         __('Beziercode Datos','beziercode-textdomain'), 
         __('Beziercode Datos','beziercode-textdomain'), 
         'manage_options', 
         'bc_data', 
         [$this,'controlador_display_menu'], 
         'dashicons-beziercode',
         22);

        $this->build_menupage->run();
    }
   
      
    /**
     * MuSestra el HTML del menu en el area de administración
     *
     * @since    1.0.0
     * @access   public
     */
    public function controlador_display_menu()
    {
         if($_GET['page'] == 'bc_data' && $_GET['action'] == 'edit' && isset($_GET['id']))
         {
            require_once BC_PLUGIN_DIR_PATH . 'admin/partials/bc-admin-display-edit.php';

         } else {
            
            require_once BC_PLUGIN_DIR_PATH . 'admin/partials/bc-admin-display.php';
         }
    }
    /**
     * Controla el envio de datos con POST desde el lado del cliente al lado del servidor
     */
      
    public function ajax_crud_table()
    {
        check_ajax_referer('bcdata_seg','nonce');

        if(current_user_can('manage_options'))
        {
            extract($_POST,EXTR_OVERWRITE);/*CONVIERTE TODOS LOS VALORES DE LA SUPERGLOBAL $_POST EN VARIABLES*/

            if($tipo == 'add')
            {

                $columns = [
                    'nombre' => $nombre,
                    'data'   => '',
                ];

                $result = $this->db->insert(BC_TABLE, $columns);

                $json = json_encode([
                    'result'    => $result,
                    'nombre'    => $nombre,
                    'insert_id' => $this->db->insert_id,
                ]);

            }
            echo $json;
            wp_die();


        }
    }


    public function ajax_crud_json()
    {
        check_ajax_referer('bcdata_seg','nonce');

        if(current_user_can('manage_options'))
        {
            extract($_POST,EXTR_OVERWRITE);/*CONVIERTE TODOS LOS VALORES DE LA SUPERGLOBAL $_POST EN VARIABLES*/

            $sql       = $this->db->prepare("SELECT data FROM " . BC_TABLE . " WHERE id =  %d ", $idTabla );
            $resultado = $this->db->get_var( $sql );

            if($tipo == 'add')
            {

                $data = $this->crud_json->addItem( $resultado, $nombres, $apellidos, $correo, $media);
               
                $columns = [
                    'data' => json_encode($data)
                ];

                $where = [
                    "id" => $idTabla,
                ];

                $format = [
                    "%s"
                ];
                $where_format = [
                    "%d"
                ];  

                $result_update = $this->db->update(BC_TABLE, $columns,$where,$format, $where_format);
                $last_item  = end($data['items']);
                $insert_id  = $last_item['id'];

                $json = json_encode([
                    'result'    => $result_update,
                    'insert_id' => $insert_id,
                ]);

            } else if($tipo == 'update'){

                $data = $this->crud_json->updateItem( $resultado, $idUser, $nombres, $apellidos, $correo, $media);
                
                $columns = [
                    'data' => json_encode($data)
                ];

                $where = [
                    "id" => $idTabla,
                ];

                $format = [
                    "%s"
                ];
                $where_format = [
                    "%d"
                ];  

                $result_update = $this->db->update(BC_TABLE, $columns,$where,$format, $where_format);

                $json = json_encode([
                    'result'    => $result_update
                ]);

            } else if($tipo == 'delete') {

                $data = $this->crud_json->deleteItem($resultado, $idUser);
                
                $columns = [
                    'data' => json_encode($data)
                ];

                $where = [
                    "id" => $idTabla,
                ];

                $format = [
                    "%s"
                ];
                $where_format = [
                    "%d"
                ];  

                $result_update = $this->db->update(BC_TABLE, $columns,$where,$format, $where_format);

                $json = json_encode([
                    'result'    => $result_update
                ]);
            }
            echo $json;
            wp_die();


        }
    }
   
        
    
    
}







