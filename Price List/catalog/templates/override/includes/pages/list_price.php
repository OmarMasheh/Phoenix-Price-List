<?php
/*
  $Id$

  CE Phoenix, E-Commerce made Easy
  https://phoenixcart.org

  Copyright (c) 2021 Phoenix Cart

  Released under the GNU General Public License
*/

  require $oscTemplate->map_to_template('template_top.php', 'component');

?>




<div class="page-header">
  <h1><?php echo HEADING_TITLE; ?></h1>
</div>

<?php
  $categories_name = '';
  $list_price_query = tep_db_query("select c.categories_id, c.categories_name, p.products_id, p.products_model, p.products_image, p.products_tax_class_id, p.products_price, pd.products_name, m.manufacturers_id, m.manufacturers_name from products p left join manufacturers m on m.manufacturers_id = p.manufacturers_id, products_description pd, categories_description c, products_to_categories pc where p.products_id = pd.products_id and p.products_id = pc.products_id and p.products_status = 1 and pc.categories_id = c.categories_id AND c.language_id = '" . (int)$languages_id . "' and pd.language_id = '" . (int)$languages_id . "'" . " order by c.categories_id, pd.products_name ASC");
  while ($list_price = tep_db_fetch_array($list_price_query)) {
    if($categories_name != $list_price['categories_name']) {
?>

<div class="row">

  <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>
  	    <div class="card-header"><a href="<?php echo tep_href_link('index.php', 'cPath=' . $list_price['categories_id']); ?>"><?php echo TABLE_HEADING_CATEGORY . $list_price['categories_name']; ?></a></div>
      </td>
  	</tr>
  </table>

<table class="table table-striped">
    <thead>
  	<tr>
  	  <th class="alert alert-success" role="alert" width="20%"><?php echo TABLE_HEADING_PRICE_LIST_IMAGE; ?></th>
  	  <th class="alert alert-success" role="alert" width="20%"><?php echo TABLE_HEADING_PRICE_LIST_PRODUCTS; ?></th>
  	  <th class="alert alert-success" role="alert" width="20%"><?php echo TABLE_HEADING_PRICE_LIST_MODEL; ?></th>
  	  <th class="alert alert-success" role="alert" width="20%" ><?php echo TABLE_HEADING_PRICE_LIST_MANUFACTURER; ?></th>
  	  <th class="alert alert-success" role="alert" width="20%" ><?php echo TABLE_HEADING_PRICE_LIST_PRICE; ?></th>
  	</tr>
    </thead>
  </table>

</div>

<?php
    }
?>
<div class="contentText">
  <table border="0" width="100%" cellspacing="20" cellpadding="20">
    <tr>
  	  <td  width="<?php echo (UPCOMING_IMAGE_WIDTH + 20) . 'px;">&nbsp;' . tep_image('images/' . $list_price['products_image'], $list_price['products_name'], '50%', '50%') . '&nbsp;&nbsp;'; ?></td>
      <td  width="20%"><?php echo '&nbsp;&nbsp;<a href="' . tep_href_link('product_info.php', 'products_id=' . $list_price['products_id']) . '">' . $list_price['products_name'] . '</a>'; ?></td>
  	  <td  width="20%"><?php echo '<a href="' . tep_href_link('product_info.php', 'products_id=' . $list_price['products_id']) . '">' . $list_price['products_model'] . '</a>&nbsp;'; ?></td>
  	  <td  width="20%"><?php echo '<a href="' . tep_href_link('index.php', 'manufacturers_id=' . $list_price['manufacturers_id']) . '">' . $list_price['manufacturers_name'] . '</a>'; ?></td>
<?php
  if ($new_price = tep_get_products_special_price($list_price['products_id'])) {
	echo '<td width="20%"><span style="color: #ff0000;"><del>' .  $currencies->display_price($list_price['products_price'], tep_get_tax_rate($list_price['products_tax_class_id'])) . '</del></span><br />' . $currencies->display_price($new_price, tep_get_tax_rate($list_price['products_tax_class_id'])) . '</td>';
  } else {
	echo '<td width="20%" >' . $currencies->display_price($list_price['products_price'], tep_get_tax_rate($list_price['products_tax_class_id'])) . '</td>';
  }
?>
    </tr>
  </table>
</div>

<?php
    $categories_name = $list_price['categories_name'];
  }
?>

<?php


  require $oscTemplate->map_to_template('template_bottom.php', 'component');
?>
