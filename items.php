<?php include 'sidebar.php'; ?>
<div class="content">
  <h2>Items (AJAX + Modals)</h2>
  <button id="addBtn">+ Add Item</button>
  <table id="tbl" border="1" cellpadding="6" style="margin-top:10px;width:100%">
    <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Action</th></tr></thead>
    <tbody></tbody>
  </table>
</div>

<!-- Modal -->
<div id="modal" style="display:none; position:fixed; inset:0; background:#0006; align-items:center; justify-content:center;">
  <div style="background:#fff; padding:18px; width:360px; border-radius:8px;">
    <h3 id="mTitle">Add Item</h3>
    <input type="hidden" id="id">
    <label>Name</label><input id="name" style="width:100%"><br><br>
    <label>Price</label><input id="price" type="number" step="0.01" style="width:100%"><br><br>
    <!-- <label>Category</label><input id="category" style="width:100%"><br><br> -->
    <label>Category</label>
    <select id="category" style="width:100%">
      <option value="">Select Category</option>
      <option value="Peripherals">Peripherals</option>
      <option value="Display">Display</option>
      <option value="Computers">Computers</option>
    </select><br><br>
    <button id="save">Save</button>
    <button id="cancel">Cancel</button>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const load = () => {
  $.getJSON('items_api.php', {action:'list'}, res => {
    const rows = res.map(r=>`
      <tr>
        <td>${r.id}</td>
        <td>${r.name}</td>
        <td>${r.price}</td>
        <td>${r.category??''}</td>
        <td>
          <button class="edit" data-id="${r.id}">Edit</button>
          <button class="del" data-id="${r.id}">Delete</button>
        </td>
      </tr>`).join('');
    $('#tbl tbody').html(rows);
  });
};

$('#addBtn').on('click', ()=>{$('#mTitle').text('Add Item'); $('#id').val(''); $('#name,#price,#category').val(''); $('#modal').css('display','flex');});
$('#cancel').on('click', ()=>$('#modal').hide());

$('#tbl').on('click','.edit', function(){
  const id = $(this).data('id');
  $.getJSON('items_api.php',{action:'get',id}, r=>{
    $('#mTitle').text('Edit Item'); $('#id').val(r.id);
    $('#name').val(r.name); $('#price').val(r.price); $('#category').val(r.category);
    $('#modal').css('display','flex');
  });
});

$('#tbl').on('click','.del', function(){
  const id = $(this).data('id');
  Swal.fire({icon:'warning',title:'Delete?',showCancelButton:true}).then(res=>{
    if(res.isConfirmed){
      $.post('items_api.php',{action:'delete',id}, function(s){
        if(s.status==='success'){ Swal.fire({icon:'success',title:'Deleted',timer:1200,showConfirmButton:false}); load(); }
      },'json');
    }
  });
});

$('#save').on('click', ()=>{
  const payload = { action: $('#id').val()? 'update':'create',
    id: $('#id').val(), name: $('#name').val(), price: $('#price').val(), category: $('#category').val() };
  $.post('items_api.php', payload, function(s){
    if(s.status==='success'){ $('#modal').hide(); load(); Swal.fire({icon:'success',title:'Saved',timer:1200,showConfirmButton:false}); }
    else Swal.fire({icon:'error',title:'Error',text:s.message});
  }, 'json');
});

load();
</script>
