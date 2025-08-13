<?php include 'sidebar.php'; ?>
<div class="content">
  <h2>Summernote Editor</h2>
  <input id="title" placeholder="Post title" style="width:100%;padding:8px">
  <br><br>
  <textarea id="editor"></textarea>
  <br>
  <button id="savePost">Save Post</button>
  <div id="status"></div>
</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

<style>
/* Summernote customization - keep only one copy */
.note-editable {
    resize: none !important;
}
.note-statusbar {
    display: none !important;  /* Hide double arrow bar */
    visibility: hidden !important;
    height: 0 !important;
    overflow: hidden !important;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#editor').summernote({
    placeholder: 'Write here...',
    height: 220,
    disableResizeEditor: true
});

$('#savePost').on('click', function(){
  $.post('summernote_api.php', {
    title: $('#title').val(),
    content: $('#editor').summernote('code')
  }, function(res){
    if(res.status === 'success'){
      Swal.fire({icon:'success', title:'Saved', timer:1500, showConfirmButton:false});
      $('#title').val('');
      $('#editor').summernote('reset');
    } else {
      Swal.fire({icon:'error', title:'Error', text:res.message});
    }
  }, 'json');
});
</script>
