<?php
  include("head.php");
?>
<!-- Container -->
<main class="container-fluid">

<article class="row text-center ms-2 me-2">
  <section class="col">
    <article class="card shadow-indigo-sm">
      <section class="card-header">
      <article class="row">
        <section class="col-md-3 text-start"><h3 class="text-indigo">Drawers</h3></section>
        <section class="col-md-6 text-start">
        <div class="input-group mb-3">
          <span class="input-group-text bg-indigo text-white" id="drawer_search_addon"><i class="fa-regular fa-magnifying-glass"></i></span>
          <input type="text" class="form-control search" id="drawer_search" placeholder="Search" aria-label="Search" aria-describedby="drawer_search_addon" onkeyup="searchItems(this.value)" >
        </div>
        </section>
        <section class="col-md-3 text-end"><a href="drawer_new.php" class="btn btn-indigo"><i class="fa-regular fa-circle-plus"></i>&nbsp;Add Drawer</a></section>
      </article>
      </section>
      <section class="card-body" id="drawersList"></section>
    </article>
  </section>
</article>

</main>
<!-- /Container -->
<?php include("footer.php"); ?>
<script>
  drawersList(<?=$usuarioId?>)
  async function searchItems(busqueda) {
    if (busqueda.length > 2) {
      console.log('buscando')
      const url = `./api/search-${busqueda}`
      const response = await fetch(url)
      const searchResult = await response.json()
      console.log('searchResult: ', searchResult)

    }
  }
</script>