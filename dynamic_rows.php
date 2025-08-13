<?php include 'sidebar.php'; ?>
<div class="content">
  <h2>Add / Remove Rows</h2>

  <button id="addRow">+ Add Row</button>
  <form id="rowsForm" style="margin-top:12px;">
    <table id="itemsTable" border="1" cellpadding="6">
      <thead>
        <tr><th>Name</th><th>Qty</th><th>Price</th><th>Total</th><th>Action</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><input name="name[]" placeholder="Item name"></td>
          <td><input name="qty[]" type="number" value="1" min="1"></td>
          <td><input name="price[]" type="number" value="0" step="0.01"></td>
          <td class="row-total">0.00</td>
          <td><button type="button" class="remove">✖</button></td>
        </tr>
      </tbody>
      <tfoot>
        <tr><td colspan="3" align="right"><b>Grand Total</b></td><td id="grand">0.00</td><td></td></tr>
      </tfoot>
    </table>
    <br><button type="submit">Submit</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const calc = () => {
  let g = 0;
  $('#itemsTable tbody tr').each(function(){
    const qty = +$('input[name="qty[]"]', this).val() || 0;
    const price = +$('input[name="price[]"]', this).val() || 0;
    const t = (qty*price).toFixed(2);
    $('.row-total', this).text(t);
    g += +t;
  });
  $('#grand').text(g.toFixed(2));
};

$('#addRow').on('click', () => {
  $('#itemsTable tbody').append(
    `<tr>
      <td><input name="name[]" placeholder="Item name"></td>
      <td><input name="qty[]" type="number" value="1" min="1"></td>
      <td><input name="price[]" type="number" value="0" step="0.01"></td>
      <td class="row-total">0.00</td>
      <td><button type="button" class="remove">✖</button></td>
    </tr>`
  );
});
$('#itemsTable').on('input', 'input', calc);
$('#itemsTable').on('click', '.remove', function(){
  $(this).closest('tr').remove(); calc();
});
calc();

$('#rowsForm').on('submit', function(e){
  e.preventDefault();
  alert('You can serialize & send with AJAX: ' + $(this).serialize());
});
</script>
