<?php include('../layouts/header.php');include('../layouts/wrapper_1.php'); ?>
<?php if(@$_GET['modulo']=='Home'){ ?>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
          <?php include('../layouts/menu.php'); ?>
        </div>
	</div>        
</section>
<?php }else{ ?>
<div class="box">
	<div class="box-header with-border">
    	<h3 class="box-title"><?php echo @$_GET['modulo']; ?></h3>
        <div class="box-tools pull-right">
        	<a  class="btn btn-box-tool" data-widget="remove" href="?modulo=Home"><i class="fa fa-times" style="font-size: 20px;"></i></a>
        </div>
    </div>
    <div class="box-body">
    	<?php include('modulos/'.@$_GET['modulo'].'.php'); ?>
    </div>
</div>
<?php } ?>
<?php include('../layouts/wrapper_2.php');include('../layouts/footer.php'); ?>