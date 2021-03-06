<h2>Listagem de matérias</h2>

<!-- <div class="line"></div> -->

<?php

// SELECT DE MATÉRIAS - APENAS AS ATIVAS E PENDENTES
$select = $conn->prepare("SELECT *
                          FROM materias
                          LEFT JOIN professores p ON p.prof_id = materias.mat_professor
                          LEFT JOIN usuarios u ON u.usu_id = materias.mat_cadastrado_por
                          WHERE mat_status <> ?
                          ORDER BY mat_nome ASC");
// $select->bindParam(1, "Desativado");
$select->execute(array("Desativado"));

?>

<div class="col-xs-12" style="height:50px;"></div>

<div class="pull-left"><?php echo $select->rowCount(); ?> matérias cadastradas no total</div>
<div class="table-responsive">
<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Nome da matéria</th>
      <th scope="col">Professor</th>
      <th scope="col">E-mail</th>
      <th scope="col">Cadastrada por</th>
    </tr>
  </thead>
  <tbody>

    <?php
    //verifica se existem registros
    if($select->rowCount() > 0):

    // estrutura de repetição
    while($row = $select->fetch(PDO::FETCH_OBJ)): ?>
    <tr>

      <!-- NOME DA MATÉRIA -->
      <td>
        <?php if($row->mat_status == "Pendente"){
          echo $row->mat_nome;
        ?>
        <span class="badge badge-warning">Aprovação pendente</span>
        <?php
        } else { ?>
          <a href="<?php echo urlSite."materia/".$row->mat_alias; ?>"><?php echo $row->mat_nome; ?></a>
        <?php } ?>
      </td>

      <!-- NOME DO PROFESSOR -->
      <td>
        <?php if($row->mat_status <> "Pendente"){ ?>
        <a href="<?php echo urlSite."professor/".$row->prof_alias; ?>">
          <?php echo $row->prof_nome." ".$row->prof_sobrenome; ?>
        </a>
        <?php
        } else {
          echo $row->prof_nome." ".$row->prof_sobrenome;
        } ?>
      </td>

      <!-- E-MAIL DO PROFESSOR -->
      <td>
        <?php echo $row->prof_email; ?>
      </td>

      <!-- USUÁRIO QUE CADASTROU MATÉRIA -->
      <td>
        <?php echo $row->usu_nome." ".$row->usu_sobrenome; ?>
      </td>

    </tr>
    <?php endwhile; endif;?>

  </tbody>
</table>
</div>
