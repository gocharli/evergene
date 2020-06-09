<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once('dompdf/autoload.inc.php');

	use Dompdf\Dompdf;

	class Pdf extends Dompdf {

		public function __construct(){

			parent::__construct();
		}

		public function load_view($view, $data = array()) {
			
			$html = $this->ci()->load->view($view, $data, TRUE);
	 
			$this->load_html($html);
		}

		protected function ci(){

			return get_instance();
		}
	}
?>