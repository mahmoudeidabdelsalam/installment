<?php 
/* 
* Template Name: installment Template 
*/ 

get_header(); 

$args = array(
  'post_type' => 'products',
);
$loop = new WP_Query( $args );

?>

<div class="installment">
  <div class="form">
    <div class="form-group">
      <label for="Products">Products</label>
      <select name="products" id="Products">
        <option value="0">choose...</option>
        <?php if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); ?>
        <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
        <?php endwhile; endif;?>
      </select>
    </div>
    <div class="form-group">
      <label for="Category">Category</label>
      <select name="category" id="Category" disabled>
        <option value="0">choose...</option>
      </select>
    </div>
    <div class="form-group">
      <label for="SubCategory">Sub Category</label>
      <select name="subcategory" id="SubCategory" disabled>
        <option value="0">choose...</option>
      </select>
    </div>
    <div class="form-group">
      <label for="date">date</label>
      <select name="date" id="date" disabled>
        <option value="0">choose...</option>
      </select>
    </div>
    <div class="form-group">
      <label for="amount">amount</label>
      <input type="namber" name="amount" id="amount">
    </div>

    <button id="submit" type="submit" class="btn btn-primary">financial Planning</button>
  </div>

  <div class="box-financial" id="January" style="display:none;">
    <h2>January</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="February" style="display:none;">
    <h2>February</h2>
    <div class="the_total"></div>
  </div>
  <div  class="box-financial"id="March" style="display:none;">
    <h2>March</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="April" style="display:none;">
    <h2>April</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="May" style="display:none;">
    <h2>May</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="June" style="display:none;">
    <h2>June</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="July" style="display:none;">
    <h2>July</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="August" style="display:none;">
    <h2>August</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="September" style="display:none;">
    <h2>September</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="October" style="display:none;">
    <h2>October</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="November" style="display:none;">
    <h2>November</h2>
    <div class="the_total"></div>
  </div>
  <div class="box-financial" id="December" style="display:none;">
    <h2>December</h2>
    <div class="the_total"></div>
  </div>

  <div id="total" class="col-total"></div>


</div>


<script type="text/javascript">
  jQuery(function ($) {


    $('#Products').on('change', function () {
      var products_id = $('#Products').val();
      $.ajax({
        url: "<?= admin_url( 'admin-ajax.php' ); ?>",
        type: 'POST',
        data: {
          'action': 'products_add_front_end',
          'post_id': products_id
        },
        beforeSend: function () {
          $('#Loading').show();
        },
        success: function (results) {
          $('#Loading').hide();
          $("#Category").removeAttr('disabled');
          $("#Category").append(results);
        }
      });
    });


    $('#Category').on('change', function () {
      var term_id = $('#Category').val();
      $.ajax({
        url: "<?= admin_url( 'admin-ajax.php' ); ?>",
        type: 'POST',
        data: {
          'action': 'sub_add_front_end',
          'term_id': term_id
        },
        beforeSend: function () {
          $('#Loading').show();
        },
        success: function (results) {
          $('#Loading').hide();
          $("#SubCategory").removeAttr('disabled');
          $("#SubCategory").append(results);
        }
      });
    });

    $('#Products').on('change', function () {
      var products_id = $('#Products').val();
      $.ajax({
        url: "<?= admin_url( 'admin-ajax.php' ); ?>",
        type: 'POST',
        data: {
          'action': 'date_add_front_end',
          'products_id': products_id
        },
        beforeSend: function () {
        },
        success: function (results) {
          $("#date").append(results);
        }
      });
    });


    $('#submit').on('click', function () {
      var products_id = $('#Products').val();
      var category    = $('#Category').val();
      var subcategory = $('#SubCategory').val();
      var date        = $('#date').val();
      var amount      = $('#amount').val();

      $.ajax({
        url: "<?= admin_url( 'admin-ajax.php' ); ?>",
        type: 'POST',
        data: {
          'action': 'financial_add_front_end',
          'products_id': products_id,
          'category': category,
          'subcategory': subcategory,
          'date': date,
          'amount': amount,
        },
        beforeSend: function () {

        },
        success: function (results) {
          $("#" + date).append(results);
          $("#" + date).show();
          
          var list = $("#" + date + " .subtotal").map(function(){return $(this).attr("price");}).get();
          
          var the_total = $(".subtotal").map(function(){return $(this).attr("price");}).get();

          console.log(the_total);

          var total = 0;
          for (var i = 0; i < list.length; i++) {
              total += list[i] << 0;
          }

          var all_total = 0;
          for (var j = 0; j < the_total.length; j++) {
              all_total += the_total[j] << 0;
          }


          console.log(all_total);


          $("#" + date + " .the_total").text(total);

          $("#total").text(all_total);

        }
      });
    });


  });
</script>
<div class="copyright">
  Copyright © 2020 Powered by Mahmoud
</div>
<?php get_footer(); ?>