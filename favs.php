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
            <section class="col-md-3 text-start">
              <h3 class="text-indigo">Mercado Libre Bookmarks</h3>
            </section>
            <section class="col-md-6 text-end"></section>
            <section class="col-md-3 text-end"><a href="favs_new.php" class="btn btn-indigo"><i class="fa-regular fa-circle-plus"></i>&nbsp;New List of Bookmarks</a></section>
          </article>
        </section>
        <section class="card-body" id="bookmarksList">
          <table id="bookmarksListTable" class="table table-sm table-hover" style="width:100%">
          <thead class="small">
            <th></th>
            <th>Title</th>
            <th>Price</th>
            <th>Action</th>
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
bookmarksTable()
</script>