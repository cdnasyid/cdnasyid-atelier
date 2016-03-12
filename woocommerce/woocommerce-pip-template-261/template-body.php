<header class="p-y-2">
	<div class="container">
		<div class="row m-b-2">
			<div class="col-xs-12">
				<a class="btn btn-danger print" href="#" onclick="window.print()"><?php _e('Print', 'woocommerce-pip'); ?></a>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-6">
				<img class="img-fluid m-b-3" src="http://www.cdnasyid.com/wp-content/uploads/2016/03/cdn-yellow-white-2-165.png">
			</div>
			<div class="col-xs-6">
				<?php if ($action == 'print_invoice') { ?>
				<h1><?php _e('Invoice', 'woocommerce-pip'); ?></h1>
				<h3><?php echo woocommerce_pip_invoice_number($order->id); ?></h3>
				<?php } else { ?>
				<h1><?php _e('Packing list', 'woocommerce-pip'); ?></h1>
				<?php } ?>
				<h6><?php _e('Order', 'woocommerce-pip'); ?> <?php echo $order->get_order_number(); ?> &mdash; <time datetime="<?php echo date("Y/m/d", strtotime($order->order_date)); ?>"><?php echo date("Y/m/d", strtotime($order->order_date)); ?></time></h6>
			</div>
		</div>
	</div>
</header>





<section class="article">
	<div class="container m-t-3">
		<div class="col-xs-6">

			<h4><?php _e('Billing address', 'woocommerce-pip'); ?></h4>

			<p>
				<?php echo $order->get_formatted_billing_address(); ?>
			</p>

			<?php do_action( 'wc_print_invoice_packing_template_body_after_billing_address', $order ); ?>

			<?php if (get_post_meta($order->id, 'VAT Number', TRUE) && $action == 'print_invoice') : ?>
				<p><strong><?php _e('VAT:', 'woocommerce-pip'); ?></strong> <?php echo get_post_meta($order->id, 'VAT Number', TRUE); ?></p>
			<?php endif; ?>
			<?php if ($order->billing_email) : ?>
				<p><strong><?php _e('Email:', 'woocommerce-pip'); ?></strong> <?php echo $order->billing_email; ?></p>
			<?php endif; ?>
			<?php if ($order->billing_phone) : ?>
				<p><strong><?php _e('Tel:', 'woocommerce-pip'); ?></strong> <?php echo $order->billing_phone; ?></p>
			<?php endif; ?>

		</div>

		<div class="col-xs-6">

			<h4><?php _e('Shipping address', 'woocommerce-pip'); ?></h4>

			<?php if (get_post_meta( $order_id, '_wcms_packages', true )) { ?>
				<?php $packages = get_post_meta( $order_id, '_wcms_packages', true );
					foreach ($packages as $package):
						echo '<p>' . WC()->countries->get_formatted_address( $package['full_address'] ) . '</p>';
					endforeach;
				?>
			<?php }
				else { ?>
				<p>
					<?php echo $order->get_formatted_shipping_address(); ?>
				</p>
				<?php } ?>
				<?php if (get_post_meta( $order_id, '_tracking_provider', true )) : ?>
					<p><strong><?php _e('Tracking provider:', 'woocommerce-pip'); ?></strong> <?php echo get_post_meta( $order_id, '_tracking_provider', true ); ?></p>
				<?php endif; ?>
				<?php if (get_post_meta( $order_id, '_tracking_number', true )) : ?>
					<p><strong><?php _e('Tracking number:', 'woocommerce-pip'); ?></strong> <?php echo get_post_meta( $order_id, '_tracking_number', true ); ?></p>
				<?php endif; ?>

		</div>

		<div class="col-xs-12">

			<?php if ( 'print_packing' == $action && 'yes' == get_option( 'woocommerce_calc_shipping' ) ) : ?>
			<div>
				<strong><?php _e( 'Shipping:', 'woocommerce-pip' ); ?></strong>
				<?php echo $order->get_shipping_method(); ?>
			</div>
			<?php endif; ?>

			<?php if ($order->customer_note) { ?>
			<div>
				<h3><?php _e('Order notes', 'woocommerce-pip'); ?></h3>
				<?php echo $order->customer_note; ?>
			</div>
			<?php } ?>

		</div>
	</div>

	<div class="container m-t-1">
		<div class="datagrid">
		<?php if ($action == 'print_invoice') { ?>
			<table>
				<thead>
					<tr>
					  <th scope="col" style="text-align:left; width: 15%;"><?php _e('SKU', 'woocommerce-pip'); ?></th>
						<th scope="col" style="text-align:left; width: 40%;"><?php _e('Product', 'woocommerce-pip'); ?></th>
						<th scope="col" style="text-align:left; width: 15%;"><?php _e('Quantity', 'woocommerce-pip'); ?></th>
						<th scope="col" style="text-align:left; width: 30%;"><?php _e('Price', 'woocommerce-pip'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
					  <th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php _e('Subtotal:', 'woocommerce-pip'); ?></th>
						<td style="text-align:left;"><?php echo $order->get_subtotal_to_display(); ?></td>
					</tr>
					<?php if (get_option('woocommerce_calc_shipping')=='yes') : ?><tr>
					  <th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php _e('Shipping:', 'woocommerce-pip'); ?></th>
						<td style="text-align:left;"><?php echo $order->get_shipping_to_display(); ?></td>
					</tr><?php endif; ?>
					<?php echo woocommerce_pip_order_fees($order); ?>
					<?php if ($order->cart_discount > 0) : ?><tr>
					  <th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php _e('Cart Discount:', 'woocommerce-pip'); ?></th>
						<td style="text-align:left;"><?php echo wc_price($order->cart_discount); ?></td>
					</tr><?php endif; ?>
					<?php if ($order->order_discount > 0) : ?><tr>
					  <th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php _e('Order Discount:', 'woocommerce-pip'); ?></th>
						<td style="text-align:left;"><?php echo wc_price($order->order_discount); ?></td>
					</tr><?php endif; ?>
					<!-- If there is more than one tax... -->
					<?php $tax_items = $order->get_tax_totals(); ?>
					<?php if ( count( $tax_items ) > 1 ) : foreach ( $tax_items as $tax_item ) : ?><tr>
					<th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php echo esc_html( $tax_item->label ); ?>:</th>
						<td style="text-align:left;"><?php echo wc_price( $tax_item->amount ); ?></td>
					</tr>
					<?php endforeach; ?><tr>
						<th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php _e( 'Total Tax:', 'woocommerce-pip' ); ?></th>
						<td style="text-align:left;"><?php echo wc_price( $order->get_total_tax() ); ?></td>
					</tr>
					<!-- if there is only one tax... -->
					<?php else: foreach ( $tax_items as $tax_item ): ?><tr>
						<th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php echo esc_html( $tax_item->label ); ?>:</th>
						<td style="text-align:left;"><?php echo wc_price( $tax_item->amount ); ?></td>
					</tr><?php endforeach; endif; ?>
					<!-- end if -->
					<tr>
					  <th colspan="2" style="text-align:left;">&nbsp;</th>
						<th scope="row" style="text-align:right;"><?php _e('Total:', 'woocommerce-pip'); ?></th>
						<td style="text-align:left;"><?php echo wc_price($order->order_total); ?> <?php _e('- via', 'woocommerce-pip'); ?> <?php echo ucwords($order->payment_method_title); ?></td>
					</tr>
				</tfoot>
				<tbody>
					<?php echo woocommerce_pip_order_items_table($order, TRUE); ?>
				</tbody>
			</table>
		<?php } else { ?>
			<table>
				<thead>
					<tr>
					  <th scope="col" style="text-align:left; width: 22.5%;"><?php _e('SKU', 'woocommerce-pip'); ?></th>
						<th scope="col" style="text-align:left; width: 57.5%;"><?php _e('Product', 'woocommerce-pip'); ?></th>
						<th scope="col" style="text-align:left; width: 15%;"><?php _e('Quantity', 'woocommerce-pip'); ?></th>
						<th scope="col" style="text-align:left; width: 20%;"><?php _e('Total Weight', 'woocommerce-pip'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php echo woocommerce_pip_order_items_table($order); ?>
				</tbody>
			</table>
		<?php } ?>
		</div>
	</div>
</section>

<section class="article m-y-2">
	<div class="container text-xs-center">
		<?php echo woocommerce_pip_print_return_policy(); ?>
	</div>
</section>

<section class="footer m-y-2">
	<div class="container text-xs-center">
		<?php echo woocommerce_pip_print_footer(); ?>
	</div>
</section>
