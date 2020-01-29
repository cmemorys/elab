<?php 
  //LIST MENU
  $menu = [
    'aslab' => [
      'Kelas' => [
        'List'=>'aslab/kelas/list',
        'Buat' => 'aslab/kelas/buat',
        'Tugas Kelas' => 'aslab/kelas/tugas'
      ],
      'Materi' => [
        'List'=>'aslab/materi/list' , 
        'Upload' => 'aslab/materi/upload'
      ],
      'Praktikum' => [
        'List Matkul' => 'aslab/praktikum/list',
        'Tambah Matkul' => 'aslab/praktikum/tambah'
      ],
      'Aslab' => [
        'List Aslab' => 'aslab/aslab/list',
        'Tambah Aslab' => 'aslab/aslab/tambah'
      ]
    ],
    'mahasiswa' => [
      'Tugas' => [
        'Upload Tugas'=>'mahasiswa/tugas/upload'
      ],
      'Materi'=>[
        'List Materi'=>'mahasiswa/materi/list'
      ]
    ],
  ];
?>
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <?php 
        $status = $_SESSION['level'];
        if($menu[$status] == true){
          foreach ($menu[$status] as $key => $mn) {
      ?>
      <li class="treeview <?php if($this->uri->segment(2) == strtolower($key)){ echo 'active'; } ?>">
        <a href="#">
          <i class="fa fa-circle-o"></i> <span><?php echo $key; ?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php 
            foreach ($mn as $ki => $sm) {
          ?>
          <li class="<?php if(uri_string() == $sm){ echo 'active';} ?>"><a href="<?php echo base_url(); echo $sm; ?>"><i class="fa fa-circle-o"></i> <?php echo $ki; ?></a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } } ?>
    </ul>
  </section>
</aside>