
//List Drawers
// eslint-disable-next-line no-unused-vars
async function drawersList(usuarioId) {
  const $ = selector => document.querySelector(selector)
  const drawersList = $('#drawersList')
  const url = `./api/list-${usuarioId}`
  const response = await fetch(url)
  const drawers = await response.json()
  let drawersListText = `<article class="row">`
  if(drawers.length){
    for(const drawer of drawers){
      drawersListText += `<section class="col card-300">
      <article class="card text-center shadow-${drawer.category_color}-md">
        <section class="card-body text-center">
        <article class="row"><section class="col"><h4><a href="drawer_view.php?id=${drawer.drawer_id}" class="text-decoration-none text-indigo">${drawer.drawer_name}</h4></a></section></article>
        <article class="row"><section class="col"><span class="badge rounded-pill bg-${drawer.category_color} ">${drawer.category_name}</span></section></article>
        <article class="row mt-3"><section class="col"><img src="images/drawers/${drawer.drawer_image}" class="rounded-circle" width="120px" alt="${drawer.drawer_name}"></section></article>
        <article class="row mt-3">
        <section class="col text-center small fst-italic text-muted">${drawer.drawer_descriptinon}</section>
        </article>
        <article class="row mt-3">
        <section class="col-3"></section>
        <section class="col-3 d-grid gap-2"><a href="drawer_view.php?id=${drawer.drawer_id}" class="btn btn-outline-success"><i class="fa-regular fa-eye"></i></a></section>
        <section class="col-3 d-grid gap-2"><a href="drawer_del.php?id=${drawer.drawer_id}" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a></section>
        <section class="col-3"></section>
        </article>
        </section>
      </article>
      </section>`
    }
  }else{
    drawersListText += `<section class="col"><h2>No drawers to show</h2></section>`
  }

  drawersListText += `</article>`
  drawersList.innerHTML = drawersListText
}

// eslint-disable-next-line no-unused-vars
async function drawerView(drawerId) {
  const $ = selector => document.querySelector(selector)
  const drawer_title = $('#drawer_title')
  const drawer_image_full_Label = $('#drawer_image_full_Label')
  const drawer_name = $('#drawer_name')
  const drawer_location = $('#drawer_location')
  const drawer_image = $('#drawer_image')
  const drawer_image_full_src = $('#drawer_image_full_src')
  const drawer_descriptinon = $('#drawer_descriptinon')
  const drawer_category = $('#drawer_category')
  const drawer_card = $('#drawer_card')
  const drawer_card_items = $('#drawer_card_items')
  const url = `./api/view-${drawerId}`
  const response = await fetch(url)
  const drawer = await response.json()
  if(drawer.length != 0 ){
    drawer_title.innerHTML = drawer[0].drawer_name
    drawer_image_full_Label.innerHTML = drawer[0].drawer_name
    drawer_name.value = drawer[0].drawer_name
    drawer_location.value = drawer[0].drawer_location
    drawer_descriptinon.value = drawer[0].drawer_descriptinon
    drawer_card.classList.add(`shadow-${drawer[0].category_color}-blur`)
    drawer_card_items.classList.add(`shadow-${drawer[0].category_color}-blur`)
    drawer_image.classList.add(`border-${drawer[0].category_color}`)
    drawer_image.src = `images/drawers/${drawer[0].drawer_image}`
    drawer_image_full_src.src = `images/drawers/${drawer[0].drawer_image_full}`

    for (let i = 0; i < drawer_category.options.length; i++) {
      if (drawer_category.options[i].value === drawer[0].drawer_category) {
        drawer_category.options[i].selected = true
        break
      }
    }
  }else{
    // window.location.href ='index.php'
  }
}

// eslint-disable-next-line no-unused-vars
async function categoryList(selecDest) {
  const $ = selector => document.querySelector(selector)
  const selecDestOptions = $('#'+selecDest)
  let options = ``
  const url = `./api/categorylist-0`
  const response = await fetch(url)
  const categories = await response.json()
  for(const category of categories){
    options += `<option class='text-${category.category_color}' value="${category.category_id}">${category.category_name}</option>`
  }
  selecDestOptions.innerHTML = options
}

// eslint-disable-next-line no-unused-vars
async function drawerItems($drawerId, usuarioId) {
  const url = `./api/itemlist-${$drawerId}-${usuarioId}`
  // eslint-disable-next-line no-unused-vars, no-undef
  const table = $('#drawer_item_table').DataTable( {
    destroy: true,
    // language: {'url': '/dataTables/Spanish.json'},
    ajax: {'url': url,'dataSrc': ''},
    deferRender: true,
    stateSave: true,
    stateDuration: 120,
    pageLength: 15,
    order: [],
    paging: true,
    responsive: true,
    dom: 'Bfrtip',
    orderCellsTop: true,
    buttons: [ 'copy', 'excel',
      { extend: 'pdf',
        orientation: 'landscape',
        pageSize: 'A4'
      },
      'print',

    ],
    columns: [
      { 'data': 'item_image' , className: 'text-center'},//0
      { 'data': 'item_name' },//1
      { 'data': 'category_name' },//2
      { 'data': 'item_descrption' },//3
      { 'data': 'item_amount' , className: 'text-end'},//4
      { 'data': 'item_id' , className: 'text-center'},//5
      { 'data': 'item_id' , className: 'text-center'},//6

    ],
    columnDefs: [

      {
        'targets': 0,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          let srcIMG = 'default.png'
          if (row['item_image'].length > 0){srcIMG = `${row['item_image']}`}
          const respuesta =  `<img class="border border-teal mb-3 rounded-circle" src="images/item/${srcIMG}" alt="" width="60px">`
          return respuesta
        }
      },
      {
        'targets': 2,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          const respuesta =  `<span class="text-${row['category_color']}">${row['category_name']}</span>`
          return respuesta
        }
      },
      {
        'targets': 5,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          const respuesta = `<a href="item_view.php?id=${row['item_id']}&did=${row['item_drawer']}" class="btn btn-outline-success"><i class="fa-regular fa-eye"></i></a>`
          return respuesta
        }
      },
      {
        'targets': 6,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          const respuesta = `<a href="item_del.php?id=${row['item_id']}" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>`
          return respuesta
        }
      }
    ]
  })
}

// eslint-disable-next-line no-unused-vars
async function itemView(itemId) {
  const $ = selector => document.querySelector(selector)
  const url = `./api/itemview-${itemId}`
  console.log('url: ', url)
  const item_title = $('#item_title')
  const item_image_full_Label = $('#item_image_full_Label')
  const item_name = $('#item_name')
  const item_amount = $('#item_amount')
  const item_image = $('#item_image')
  const item_image_full_src = $('#item_image_full_src')
  const item_descriptinon = $('#item_descriptinon')
  const item_category = $('#item_category')
  const item_card = $('#item_card')
  const item_drawer = $('#item_drawer')
  const searchImage = $('#searchImage')
  // const searchPdf = $('#searchPdf')

  const response = await fetch(url)
  const item = await response.json()
  if(item.length != 0 ){
    item_title.innerHTML = item[0].item_name
    item_image_full_Label.innerHTML = item[0].item_name
    item_name.value = item[0].item_name
    item_amount.value = item[0].item_amount
    item_descriptinon.value = item[0].item_descrption
    item_card.classList.add(`shadow-${item[0].category_color}-blur`)
    item_image.classList.add(`border-${item[0].category_color}`)
    item_image.src = `images/item/${item[0].item_image}`
    item_image_full_src.src = `images/item/${item[0].item_image}`
    searchImage.href = `https://www.google.com/search?q=${item[0].item_descrption}&source=lnms&tbm=isch`
    // searchPdf.href = `https://www.google.com/search?q=filetype%3Apdf+${item[0].item_descrption}`

    for (let i = 0; i < item_category.options.length; i++) {
      if (item_category.options[i].value === item[0].item_category) {
        item_category.options[i].selected = true
        break
      }
    }
    for (let i = 0; i < item_drawer.options.length; i++) {
      if (item_drawer.options[i].value === item[0].item_drawer) {
        item_drawer.options[i].selected = true
        break
      }
    }
  }else{
    // window.location.href ='index.php'
  }
}

// eslint-disable-next-line no-unused-vars
async function drawerListSelect(selecDest,usuarioId) {
  const $ = selector => document.querySelector(selector)
  const selecDestOptions = $('#'+selecDest)
  const url = `./api/list-${usuarioId}`
  let options = ''
  const response = await fetch(url)
  const drawers = await response.json()
  if(drawers.length){
    for(const drawer of drawers){
      options += `<option class='text-${drawer.category_color}' value="${drawer.drawer_id}">${drawer.drawer_name}</option>`
    }
  }else{
    options += `<option value="0">No drawers to show</option>`
  }
  selecDestOptions.innerHTML = options
}
// eslint-disable-next-line no-unused-vars
async function itemsAll(usuarioId) {
  const url = `./api/itemsall-${usuarioId}`
  // eslint-disable-next-line no-unused-vars, no-undef
  const table = $('#item_all_table').DataTable( {
    destroy: true,
    // language: {'url': '/dataTables/Spanish.json'},
    ajax: {'url': url,'dataSrc': ''},
    deferRender: true,
    stateSave: true,
    stateDuration: 120,
    pageLength: 20,
    order: [],
    paging: true,
    responsive: true,
    dom: 'Bfrtip',
    orderCellsTop: true,
    buttons: [ 'copy', 'excel',
      { extend: 'pdf',
        orientation: 'landscape',
        pageSize: 'A4'
      },
      'print',

    ],
    columns: [
      { 'data': 'item_image' , className: 'text-center'},//0
      { 'data': 'item_name' },//1
      { 'data': 'category_name' },//2
      { 'data': 'drawer_name' },//3
      { 'data': 'item_descrption' },//4
      { 'data': 'item_amount' , className: 'text-center'},//5
      { 'data': 'item_id' , className: 'text-center'},//6
      { 'data': 'item_id' , className: 'text-center'},//7

    ],
    columnDefs: [

      {
        'targets': 0,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          let srcIMG = 'default.png'
          if (row['item_image'].length > 0){srcIMG = `${row['item_image']}`}
          const respuesta =  `<img class="border border-teal mb-3 rounded-circle" src="images/item/${srcIMG}" alt="" width="90px">`
          return respuesta
        }
      },
      {
        'targets': 2,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          const respuesta =  `<span class="text-${row['category_color']}">${row['category_name']}</span>`
          return respuesta
        }
      },
      {
        'targets': 6,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          const respuesta = `<a href="item_view.php?id=${row['item_id']}&did=${row['item_drawer']}" class="btn btn-outline-success"><i class="fa-regular fa-eye"></i></a>`
          return respuesta
        }
      },
      {
        'targets': 7,
        'data': 'download_link',
        'render': function ( data, type, row, meta ) {
          const respuesta = `<a href="item_del.php?id=${row['item_id']}" class="btn btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>`
          return respuesta
        }
      }
    ]
  })



}