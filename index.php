<?php
include("head.php");
if(empty($_GET['id']))
{
  $categoryId = 0;

}else{
  $categoryId =$_GET["id"];
}
?>

<!-- Container -->
<main class="container-fluid">

  <article class="row ms-2 me-2">
    <section class="col">
      <article class="card shadow-indigo-sm">
        <section class="card-header">
          <article class="row">
            <section class="col-md-3 text-start">
              <h3 class="text-indigo">Drawers</h3>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="switchTableCard" onchange="changeView()">
                <label class="form-check-label" id="switchTableCardLabel" for="switchTableCard">Change view to cards</label>
              </div>
            </section>
            <section class="col-md-6 text-end"></section>
            <section class="col-md-3 text-end"><a href="drawer_new.php" class="btn btn-indigo"><i class="fa-regular fa-circle-plus"></i>&nbsp;Add Drawer</a></section>
          </article>
        </section>
        <section class="card-body" id="drawersList">
          <!-- <table id="drawersListTable" class="table table-sm table-hover" style="width:100%">
          <thead class="small">
            <th></th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Content</th>
            <th>Actions</th>
          </thead>
          <tbody class="small">
          </tbody>
        </table> -->
        </section>
      </article>
    </section>
  </article>

</main>
<!-- /Container -->
<?php include("footer.php"); ?>
<script>
  drawersListTable(<?= $usuarioId ?>,<?=$categoryId?>)
  async function changeView() {
    const switchTableCard = document.querySelector('#switchTableCard')
    const switchTableCardLabel = document.querySelector('#switchTableCardLabel')

    if (switchTableCard.checked) {

      switchTableCardLabel.innerHTML = 'Change view to table'
      drawersListCards(<?= $usuarioId ?>,<?=$categoryId?>)

    } else {
      switchTableCardLabel.innerHTML = 'Change view to cards'
      drawersListTable(<?= $usuarioId ?>,<?=$categoryId?>)
    }
  }
</script>