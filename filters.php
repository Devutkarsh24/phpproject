<?php include 'sidebar.php'; ?>
<div class="content">
  <h2>Filter Items (AJAX)</h2>
  <input id="q" placeholder="Search name...">
  <select id="cat">
    <option value="">All Categories</option>
    <option>Peripherals</option>
    <option>Display</option>
    <option>Computers</option>
  </select>
  <select id="price">
    <option value="">Any Price</option>
    <option value="0-1000">Under 1000</option>
    <option value="1000-10000">1000 - 10000</option>
    <option value="10000-60000">10000 - 60000</option>
  </select>
  <button id="go">Filter</button>

  <table border="1" cellpadding="6" style="margin-top:10px;">
    <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Category</th></tr></thead>
    <tbody id="list"></tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const load = () => {
  $.get('filter_api.php', {
    q: $('#q').val(), cat: $('#cat').val(), price: $('#price').val()
  }, function(html){ $('#list').html(html); });
};
$('#go, #q, #cat, #price').on('change keyup', load);
load();
</script>
