<?php
include("head.php");
$itemId= $_GET['id'];
$drawerId = $_GET['did'];
?>

<!-- Container -->
<main class="container-fluid">
  <article class="row">
    <section class="col-md-1"></section>
    <section class="col-md-10">
      <article class="card" id="item_card">
        <section class="card-header">
          <article class="row">
            <section class="col-md-6 text-start">
              <h3 class="text-indigo" id="item_title">Drawers</h3>
            </section>
            <section class="col-md-6 text-end"><a href="drawer_view.php?id=<?=$drawerId?>" class="btn btn-primary"><i class="fa-regular fa-circle-chevron-left"></i>&nbsp;Back</a></section>
          </article>
        </section>
        <section class="card-body">
          <article class="row">
            <section class="col-md-4 text-center">
              <a href="#item_image_full" data-bs-toggle="modal">
                <img src="" id="item_image" class="img-fluid rounded-4 border border-3">
              </a>
              <article class="row mt-3">
                <section class="col">
                <form action="item_img.php" method="post" enctype="multipart/form-data">
                  <input id="item_id" name="item_id" type="hidden" value="<?= $itemId?>">
                  <input id="item_drawer_img" name="item_drawer_img" type="hidden" value="<?= $drawerId?>">
                  <label for="file-upload" class="custom-file-upload btn btn-indigo">
                  <i class="fa-regular fa-cloud-upload-alt"></i>&nbsp;Change Image</label>
                  <input id="file-upload" name="file-upload" type="file" accept=".jpeg, .jpg" onChange="this.form.submit()">
                </form>
                </section>
                <section class="col">
                  <a id="searchImage" href='https://www.google.com/search?q= &source=lnms&tbm=isch' class='btn btn-primary' target='_blank'>
                  <i class="fa-regular fa-search"></i>&nbsp;Search Image</a>
                </section>
                <section class="col">
                  <a id="searchML" href='https://www.google.com/search?q= &source=lnms&tbm=isch' class='btn btn-yellow' target='_blank'>
                  <i class="fa-brands fa-shopify"></i>&nbsp;MercadoLibre</a>
                </section>
                <!-- <section class="col">
                  <a id="searchPdf" href='https://www.google.com/search?q= &source=lnms&tbm=isch' class='btn btn-primary m-2' target='_blank'>
                  <i class="fa-regular fa-search"></i>&nbsp;Search Pdf</a>
                </section> -->
              </article>
            </section>
            <section class="col-md-8">
            <form action="item_save.php" method="post" enctype="multipart/form-data">
              <article class="row mb-3">
                <section class="col">
                <input id="item_id_status" name="item_id_status" type="hidden" value="<?= $itemId?>">
                <input id="item_owner" name="item_owner" type="hidden" value="<?= $usuarioId ?>">
                  <div class="form-floating">
                    <input type='text' class='form-control' id='item_name' name='item_name' value='item_name' placeholder='item_name' title='item_name'>
                    <label class="text-indigo " for="item_name">Drawer Name</label>
                  </div>
                </section>
              </article>
              <article class="row mb-3">
                <section class="col">
                  <div class="form-floating">
                    <input type='number' class='form-control' id='item_amount' name='item_amount' value='item_amount' placeholder='item_amount' title='item_amount'>
                    <label class="text-indigo " for="item_amount">Amount</label>
                  </div>
                </section>
                <section class="col">
                  <div class="form-floating">
                    <input type='number' class='form-control' id='item_price' name='item_price' value='item_price' placeholder='item_price' title='item_price' min="0" value="item_price" step="0.01">
                    <label class="text-indigo" for="item_price">Price U$S</label>
                  </div>
                </section>
              </article>
              <article class="row mb-3">
                <section class="col">
                <div class="form-floating">
                    <textarea id='item_descriptinon' class='form-control' name='item_descriptinon' rows='5' cols='10' placeholder='item_descriptinon' title='item_descriptinon'>item_descriptinon</textarea>
                    <label class="text-indigo " for="item_descriptinon">Description</label>
                  </div>
                </section>
              </article>
              <article class="row mb-3">
                <section class="col">
                <div class="form-floating">
                  <select name='item_category' id='item_category' class='form-control'>
                  </select>
                  <label class="text-indigo " for="item_category">Category</label>
                </div>
                </section>
              </article>
              <article class="row mb-3">
                <section class="col">
                <div class="form-floating">
                  <select name='item_drawer' id='item_drawer' class='form-control'>
                  </select>
                  <label class="text-indigo " for="item_drawer">Actual Drawer > Move to</label>
                </div>
                </section>
              </article>
              <article class="row mb-3">
                <section class="col-md-6 text-start p-3">
                  <a href="item_del.php?id=<?= $itemId?>" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i>&nbsp;Delete Item</a>
                </section>
                <section class="col-md-6 text-end p-3">
                  <button class="btn btn-success"><i class="fa-regular fa-floppy-disk"></i>&nbsp;Save</button>
                </section>
              </article>
            </form>
            </section>
          </article>
        </section>
      </article>
    </section>
    <section class="col-md-1"></section>
  </article>
</main>
<!-- /Container -->
<!-- Modal Full Image-->
<div class="modal fade" id="item_image_full" tabindex="-1" aria-labelledby="item_image_full_Label" aria-hidden="true">
  <div class="modal-dialog  modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-indigo" id="item_image_full_Label"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="item_image_full_src" class="img-fluid rounded-4 border border-3">
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
<script>
  // categoryList('item_category')
  // drawerListSelect('item_drawer',<?= $usuarioId ?>)
  itemView(<?= $itemId?>,<?= $usuarioId ?>)
</script>