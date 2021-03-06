<!DOCTYPE html>
<?php
include_once('../config/time.php');
session_start();

if (isset($_SESSION['user']))
	$user = $_SESSION['user'];
else
	header('Location: ../index.php');

include_once('../functions/functions.php');
header("Content-type: text/html; charset=utf-8");
$menu_id = '';
$action_id = '';
$edit = '';
$edited = '';
$card_id ='';
$card_ids ='';
$date='';
$employee = '';
$active = '';
$comment = '';

if(isset($_GET['menu_id'])){
    $menu_id = $_GET['menu_id'];
}

if(isset($_GET['action_id'])){
    $action_id = $_GET['action_id'];
}

if(isset($_GET['card_id'])){
    $card_id = $_GET['card_id'];
}

if(isset($_GET['edit'])){
    $edit = $_GET['edit'];
}

if(isset($_SESSION["edited"])){
	$edited = $_SESSION["edited"];
}

require_once("../db/db.php");
$query = "SELECT * FROM cards WHERE id=" . $card_id . " LIMIT 1;";
$result = mysqli_query($connection, $query);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)):
    $card_ids = $row['card_id'];
    $date = $row['date'];     //echo '<td>' . $date = date('d/m/Y') . '</td>';
    $employee = $row['name'];
    $active = $row['active'];
    $comment = $row['comment'];
    $new = $row['new'];
endwhile;

?>
<html lang="pt_BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> Acesso eletrônico </title>
    <!-- Bootstrap -->
    <link rel="icon" href="../base/images/Iconka-Pool-Pool-bird.ico">
    <!-- Bootstrap Core CSS -->
    <link href="../base/css/bootstrap.css" rel="stylesheet">
    <link href="../base/css/bootstrap-select.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../base/css/simple-sidebar.css" rel="stylesheet">
    
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <?php include('../views/slider.php'); ?>
        </div>
        <!-- /#sidebar-wrapper -->
            
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php include('../views/nav_menu.php'); ?>
                <!--<div class="padding-top-20"></div>-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <a href="#menu-toggle" class="btn btn-default btn-sm pull-left menu-button" id="menu-toggle"><span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true"></span></a>
                            </div>
                            <div class="col-xs-8 col-sm-6 col-md-4 col-lg-3 pull-right">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="padding-top-20"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group pull-left">  
                                    <!--<button type="submit" class="btn btn-warning btn-sm" name="submit" form="add_user">Edit</button>-->
                                    <?php
                                    if(!isset($_GET['edit'])){
                                        echo '<a href="?menu_id=' . $menu_id . '&action_id=' . $action_id . '&card_id=' . $card_id . '&edit=true" class="btn btn-warning btn-sm" role="button">Editar</a>';
                                    }
                                    else{
                                        echo '<button type="submit" class="btn btn-success btn-sm" name="submit" form="save_card">Salvar</button>';
                                    }
                                    ?>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Deletar</button>
                                    
                                    <?php if($edit == 'true')
                                        echo '<a href="add_card_view.php?menu_id=' . $menu_id . '&action_id=' . $action_id . '&card_id=' . $card_id . '" class="btn btn-default btn-sm" role="button">Cancelar</a>';
                                    ?>
                                    <!--<a href="#" class="btn btn-primary btn-sm" role="button">Add user</a>    -->
                                </div>								
								<div class="modal fade" id="deleteModal">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;&nbsp;
Atenção!</h4>
									  </div>
									  <div class="modal-body">
										<p>Você deseja excluir este cartão?</p>
									  </div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary btn-sm" id="deleteBtn">Sim</button>
											<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
										</div>
									</div><!-- /.modal-content -->
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->								
                                
                                <div class="btn-group pull-right">
                                    <a href="cards.php?menu_id=<?php echo $menu_id; ?>"&action_id=<?php echo $action_id; ?>" class="btn btn-default btn-sm role="button"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></a>
                                    <a href="" class="btn btn-default btn-sm active"role="button"><span class="glyphicon glyphicon glyphicon-credit-card" aria-hidden="true"></span></a>
                                </div>                                
                                <!-- NEXT - PREV BUTTONS RIGHT FUNCTION-->
                                <?php //next_prev_btn($connection, $menu_id, $action_id, $card_id); ?>
								<!-- END NEXT - PREV BUTTONS RIGHT FUNCTION-->
                            </div>
                        </div>                        
                        <hr class="line">                        
                        <div class="row">
                            <div class="col-lg-12">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-offset-2">
												<?php if($edited == "success"): ?>
												<?php echo '<div  id="successMessage" class="alert alert-success alert-dismissible" role="alert">';?>
												<?php echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';?>
												<?php echo '<strong>Atenção! </strong> Editado com Successo!';?>
												<?php echo '</div>';?>
												<?php $_SESSION["edited"] = False; ?>
												<?php endif; ?>
												<?php if($edited == "fail"): ?>
												<?php echo '<div id="successMessage" class="alert alert-warning alert-dismissible" role="alert">';?>
												<?php echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';?>
												<?php echo '<strong>Atenção! </strong> Algo errado!';?>
												<?php echo '</div>';?>
												<?php $_SESSION["edited"]=False; ?>
												<?php endif; ?>
                                                
												<div class="panel panel-default">
                                                    <!-- Default panel contents -->
                                                    <div class="panel-heading">Adicionar novo cartão</div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form action="save_card.php?menu_id=<?php echo $menu_id . '&action_id='. $action_id . '&card_id='.$card_id; ?>" method="POST" id="save_card"  class="form-horizontal" accept-charset="UTF-8">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <fieldset>
                                                                                <!-- Form Name -->
                                                                                <legend><h4>Status</h4></legend>   
                                                                                <!-- Select Basic -->
                                                                                <div class="form-group">
                                                                                       
                                                                                    <label class="col-md-3 control-label" for="selectbasic">ID Cartão</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static"><?php echo $card_ids; ?></p>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                
                                                                                <!-- Text input-->
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label" for="textinput">Data</label>  
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static"><?php echo date("d/m/Y",strtotime($row['date'])) ?> 
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label" for="textinput">Terminal</label>  
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">TC-54L</p>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                       
																	   <!--Referente a configuaração e edição de carttões cadastrados-->
																		<div class="col-md-6">
                                                                            <fieldset>
                                                                               <legend><h4>Configuração</h4></legend>   
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label" for="textinput">Registrados</label>  
                                                                                    <div class="col-md-9">
                                                                                        <select id="first-disabled"  name="selectEmployee" class="selectpicker"  data-live-search="true" data-live-search-placeholder="Search" <?php if($edit != 'true' or $edit =='') echo 'disabled'; ?>
                                                                                            <option value="0">Registrados</option>
                                                                                            <?php get_user_list($connection, $employee); ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Multiple Radios (inline) -->
                                                                                 <div class="form-group">
                                                                                    <label class="col-md-3 control-label" for="radios">Ativo</label>
                                                                                    <div class="col-md-9"> 
                                                                                            <label class="radio-inline" for="radios-0">
                                                                                                <input name="active" id="radios-0" <?php if($active==1 || $new==1) echo 'checked="checked"' ?> value="1"  type="radio" <?php if($edit != 'true' or $edit =='') echo 'disabled'; ?>>
                                                                                                Sim
                                                                                            </label> 
                                                                                            <label class="radio-inline" for="radios-1">
                                                                                                <input name="active" id="radios-1" value="0" <?php if($active==0 && $new==0) echo 'checked="checked"' ?>  type="radio" <?php if($edit != 'true' or $edit =='') echo 'disabled'; ?>>
                                                                                                Não
                                                                                            </label>
                                                                                    </div>
                                                                                </div>
                                                                                                                                                              
                                                                                  <!-- Textarea -->
                                                                                <div class="form-group">
                                                                                    <label class="col-md-3 control-label" for="textarea">Comente</label>
                                                                                    <div class="col-md-9">                     
                                                                                        <textarea class="form-control" id="textarea" name="textarea"<?php if($edit != 'true' or $edit =='') echo 'disabled'; ?>><?php echo $comment?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            &nbsp;
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                        <table class="table">
                                                          
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.row (nested) -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../base/js/jquery.js"></script>
    <script src="../base/js/bootstrap-select.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../base/js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    setTimeout(function() {
        $('#successMessage_manual').fadeOut("slow");
    }, 1000); // <-- time in milliseconds 
        
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    
	$(function(){
		$('#deleteBtn').click(function(e){
			e.preventDefault();
			window.location.href = ' <?php echo 'delete_card.php?menu_id=' . $menu_id . '&action_id=' . $action_id . '&card_id='. $card_id ?>';
		});
	});
    
        
    $(document).ready(function () {
        var mySelect = $('#first-disabled2');
    
        $('#special').on('click', function () {
          mySelect.find('option:selected').prop('disabled', true);
          mySelect.selectpicker('refresh');
        });
    
        $('#special2').on('click', function () {
          mySelect.find('option:disabled').prop('disabled', false);
          mySelect.selectpicker('refresh');
        });
    
        //$('#basic2').selectpicker({
        //  liveSearch: true,
        //  maxOptions: 1
        //});		
    });
    
    
    
    </script>

</body>

</html>
