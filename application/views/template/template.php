<?php 

$this->load->view('template/head');

?>
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
	<div class="wrapper">

	<?php
		$this->load->view('template/topnav');
		$this->load->view('template/leftnav');
		$this->load->view($content);
		$this->load->view('template/foot');
	?>

	</div>
	<!-- jQuery 3 -->
	<script src="<?php echo base_url(); ?>vendor/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<?php 
    	if(isset($select2)){
      		echo '<script typr="text/javascript" src="'.base_url().'vendor/select2/dist/js/select2.full.min.js"></script>';

    	
  	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.select2').select2();
		})
	</script>
	<?php 
	} 
	?>
	<?php  
		if(isset($dtable)){
			echo '<script src="'.base_url().'vendor/datatables.net/js/jquery.dataTables.min.js"></script>
			<script src="'.base_url().'vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
			$this->load->view($dtable);
		}
		if(isset($js)){
			$this->load->view($js);
		}
	?>

	<!-- SlimScroll -->
	<script src="<?php echo base_url(); ?>vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url(); ?>vendor/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>vendor/adminlte/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>vendor/adminlte/js/demo.js"></script>

	</body>
</html>


