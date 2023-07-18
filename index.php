<?php
  include("head.php");
?>

<!-- Container -->
<main class="container-fluid">

<article class="row ms-2 me-2">
  <section class="col">
    <article class="card shadow-indigo-sm">
      <section class="card-header">
      <article class="row">
        <section class="col-md-3 text-start"><h3 class="text-indigo">Drawers</h3></section>
        <section class="col-md-6 text-start"></section>
        <section class="col-md-3 text-end"><a href="drawer_new.php" class="btn btn-indigo"><i class="fa-regular fa-circle-plus"></i>&nbsp;Add Drawer</a></section>
      </article>
      </section>
      <section class="card-body" id="drawersList">
      <table id="drawersListTable" class="table table-sm table-hover" style="width:100%">
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
        </table>
      </section>
    </article>
  </section>
</article>

</main>
<!-- /Container -->
<?php include("footer.php"); ?>
<script>
  drawersList(<?=$usuarioId?>)
</script>