<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */

/** Available data
 * - summaryBasket : Order base item (basket) with addresses, services, products, etc.
 * - summaryTaxRates : List of tax values grouped by tax rates
 * - summaryNamedTaxes : Calculated taxes grouped by the tax names
 * - summaryShowDownloadAttributes : True if product download links should be shown, false if not
 * - summaryCostsDelivery : Sum of all shipping costs
 * - summaryCostsPayment : Sum of all payment costs
 */


$enc = $this->encoder();
$order = $this->extOrderItem;

$msg = $msg2 = '';
$key = 'pay:' . $order->getPaymentStatus();
$status = $this->translate( 'mshop/code', $key );
$format = $this->translate( 'client', 'Y-m-d' );

switch( $order->getPaymentStatus() )
{
	case 3:
		/// Payment e-mail intro with order ID (%1$s), order date (%2$s) and payment status (%3%s)
		$msg = $this->translate( 'client', 'The payment for your order %1$s from %2$s has been refunded.' );
		break;
	case 4:
		/// Payment e-mail intro with order ID (%1$s), order date (%2$s) and payment status (%3%s)
		$msg = $this->translate( 'client', 'Thank you for your order %1$s from %2$s.' );
		$msg2 = $this->translate( 'client', 'The order is pending until we receive the final payment. If you\'ve chosen to pay in advance, please transfer the money to our bank account with the order ID %1$s as reference.' );
		break;
	case 6:
		/// Payment e-mail intro with order ID (%1$s), order date (%2$s) and payment status (%3%s)
		$msg = $this->translate( 'client', 'Thank you for your order %1$s from %2$s.' );
		$msg2 = $this->translate( 'client', 'We have received your payment, and will take care of your order immediately.' );
		break;
	default:
		/// Payment e-mail intro with order ID (%1$s), order date (%2$s) and payment status (%3%s)
		$msg = $this->translate( 'client', 'Thank you for your order %1$s from %2$s.' );
}

$message = sprintf( $msg, $order->getId(), date_create( $order->getTimeCreated() )->format( $format ), $status );
$message .= "\n" . sprintf( $msg2, $order->getId(), date_create( $order->getTimeCreated() )->format( $format ), $status );

/// Price format with price value (%1$s) and currency (%2$s)
$priceFormat = $this->translate( 'client', '%1$s %2$s' );


?>
<?php $this->block()->start( 'email/payment/html' ); ?>
<!doctype html><html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><title> <?= $enc->html( sprintf( $this->translate( 'client', 'Your order %1$s' ), $order->getId() ), $enc::TRUST ); ?> </title><!--[if !mso]><!-- --><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">#outlook a { padding:0; }
          .ReadMsgBody { width:100%; }
          .ExternalClass { width:100%; }
          .ExternalClass * { line-height:100%; }
          body { margin:0;padding:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; }
          table, td { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt; }
          img { border:0;height:auto;line-height:100%; outline:none;text-decoration:none;-ms-interpolation-mode:bicubic; }
          p { display:block;margin:13px 0; }</style><!--[if !mso]><!--><style type="text/css">@media only screen and (max-width:480px) {
            @-ms-viewport { width:320px; }
            @viewport { width:320px; }
          }</style><!--<![endif]--><!--[if mso]>
        <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <![endif]--><!--[if lte mso 11]>
        <style type="text/css">
          .outlook-group-fix { width:100% !important; }
        </style>
        <![endif]--><!--[if !mso]><!--><link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css"><style type="text/css">@import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);</style><!--<![endif]--><style type="text/css">@media only screen and (min-width:480px) {
        .mj-column-per-100 { width:100% !important; max-width: 100%; }
.mj-column-per-50 { width:50% !important; max-width: 50%; }
.mj-column-per-33 { width:33.333333333333336% !important; max-width: 33.333333333333336%; }
      }</style><style type="text/css">@media only screen and (max-width:480px) {
      table.full-width-mobile { width: 100% !important; }
      td.full-width-mobile { width: auto !important; }
    }</style><style type="text/css"><?= $this->get( 'htmlCss' ); ?></style></head><body><div class="aimeos"><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="center" class="logo" style="font-size:0px;padding:10px 25px;word-break:break-word;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;"><tbody><tr><td style="width:550px;"><img height="auto" src="<?= $this->get( 'htmlLogo' ); ?>" style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;" width="550"></td></tr></tbody></table></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" class="email-common-salutation" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"> <?= $enc->html( $this->get( 'emailIntro' ) ); ?> </div></td></tr><tr><td align="left" class="email-common-intro" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"> <?= nl2br( $enc->html( $message, $enc::TRUST ) ); ?> </div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="common-summary-outlook common-summary-address-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div class="common-summary common-summary-address" style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="item-outlook payment-outlook" style="vertical-align:top;width:300px;" ><![endif]--><div class="mj-column-per-50 outlook-group-fix item payment" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'Billing address' ), $enc::TRUST ); ?></h3> <?php foreach( $this->summaryBasket->getAddress( 'payment' ) as $addr ) : ?> <div class="content"> <?= preg_replace( ["/\n+/m", '/ +/'], ['<br/>', ' '], trim( $enc->html( sprintf(
						/// Address format with company (%1$s), salutation (%2$s), title (%3$s), first name (%4$s), last name (%5$s),
						/// address part one (%6$s, e.g street), address part two (%7$s, e.g house number), address part three (%8$s, e.g additional information),
						/// postal/zip code (%9$s), city (%10$s), state (%11$s), country (%12$s), language (%13$s),
						/// e-mail (%14$s), phone (%15$s), facsimile/telefax (%16$s), web site (%17$s), vatid (%18$s)
						$this->translate( 'client', '%1$s
%2$s %3$s %4$s %5$s
%6$s %7$s
%8$s
%9$s %10$s
%11$s
%12$s
%13$s
%14$s
%15$s
%16$s
%17$s
%18$s
'
						),
						$addr->getCompany(),
						$this->translate( 'mshop/code', $addr->getSalutation() ),
						$addr->getTitle(),
						$addr->getFirstName(),
						$addr->getLastName(),
						$addr->getAddress1(),
						$addr->getAddress2(),
						$addr->getAddress3(),
						$addr->getPostal(),
						$addr->getCity(),
						$addr->getState(),
						$this->translate( 'country', $addr->getCountryId() ),
						$this->translate( 'language', $addr->getLanguageId() ),
						$addr->getEmail(),
						$addr->getTelephone(),
						$addr->getTelefax(),
						$addr->getWebsite(),
						$addr->getVatID()
					) ) ) ); ?> </div> <?php endforeach; ?> </div></td></tr></table></div><!--[if mso | IE]></td><td class="item-outlook delivery-outlook" style="vertical-align:top;width:300px;" ><![endif]--><div class="mj-column-per-50 outlook-group-fix item delivery" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'Delivery address' ), $enc::TRUST ); ?></h3> <?php if( ( $addresses = $this->summaryBasket->getAddress( 'delivery' ) ) !== [] ) : ?> <?php foreach( $addresses as $addr ) : ?> <div class="content"> <?= preg_replace( ["/\n+/m", '/ +/'], ['<br/>', ' '], trim( $enc->html( sprintf(
							/// Address format with company (%1$s), salutation (%2$s), title (%3$s), first name (%4$s), last name (%5$s),
							/// address part one (%6$s, e.g street), address part two (%7$s, e.g house number), address part three (%8$s, e.g additional information),
							/// postal/zip code (%9$s), city (%10$s), state (%11$s), country (%12$s), language (%13$s),
							/// e-mail (%14$s), phone (%15$s), facsimile/telefax (%16$s), web site (%17$s), vatid (%18$s)
							$this->translate( 'client', '%1$s
%2$s %3$s %4$s %5$s
%6$s %7$s
%8$s
%9$s %10$s
%11$s
%12$s
%13$s
%14$s
%15$s
%16$s
%17$s
%18$s
'
							),
							$addr->getCompany(),
							$this->translate( 'mshop/code', $addr->getSalutation() ),
							$addr->getTitle(),
							$addr->getFirstName(),
							$addr->getLastName(),
							$addr->getAddress1(),
							$addr->getAddress2(),
							$addr->getAddress3(),
							$addr->getPostal(),
							$addr->getCity(),
							$addr->getState(),
							$this->translate( 'country', $addr->getCountryId() ),
							$this->translate( 'language', $addr->getLanguageId() ),
							$addr->getEmail(),
							$addr->getTelephone(),
							$addr->getTelefax(),
							$addr->getWebsite(),
							$addr->getVatID()
						) ) ) ); ?> </div> <?php endforeach; ?> <?php else : ?> <div class="content"> <?= $enc->html( $this->translate( 'client', 'like billing address' ), $enc::TRUST ); ?> </div> <?php endif; ?> </div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="common-summary-outlook common-summary-service-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div class="common-summary common-summary-service" style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="item-outlook payment-outlook" style="vertical-align:top;width:300px;" ><![endif]--><div class="mj-column-per-50 outlook-group-fix item payment" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'payment' ), $enc::TRUST ); ?></h3> <?php foreach( $this->summaryBasket->getService( 'payment' ) as $service ) : ?> <div class="content"><h4><?= $enc->html( $service->getName() ); ?></h4> <?php if( ( $attributes = $service->getAttributeItems() ) !== [] ) : ?> <ul class="attr-list"> <?php foreach( $attributes as $attribute ) : ?> <?php if( strpos( $attribute->getType(), 'hidden' ) === false ) : ?> <li class="<?= $enc->attr( 'payment-' . $attribute->getCode() ); ?>"><span class="name"><?= $enc->html( $attribute->getName() ?: $this->translate( 'client/code', $attribute->getCode() ) ); ?>:</span> <?php switch( $attribute->getValue() ) : case 'array': case 'object': ?> <?php foreach( (array) $attribute->getValue() as $value ) : ?> <span class="value"><?= $enc->html( $value ); ?></span> <?php endforeach ?> <?php break; default: ?> <span class="value"><?= $enc->html( $attribute->getValue() ); ?></span> <?php endswitch; ?> </li> <?php endif; ?> <?php endforeach; ?> </ul> <?php endif; ?> </div> <?php endforeach; ?> </div></td></tr></table></div><!--[if mso | IE]></td><td class="item-outlook delivery-outlook" style="vertical-align:top;width:300px;" ><![endif]--><div class="mj-column-per-50 outlook-group-fix item delivery" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'delivery' ), $enc::TRUST ); ?></h3> <?php foreach( $this->summaryBasket->getService( 'delivery' ) as $service ) : ?> <div class="content"><h4><?= $enc->html( $service->getName() ); ?></h4> <?php if( ( $attributes = $service->getAttributeItems() ) !== [] ) : ?> <ul class="attr-list"> <?php foreach( $attributes as $attribute ) : ?> <?php if( strpos( $attribute->getType(), 'hidden' ) === false ) : ?> <li class="<?= $enc->attr( 'delivery-' . $attribute->getCode() ); ?>"><span class="name"><?= $enc->html( $attribute->getName() ?: $this->translate( 'client/code', $attribute->getCode() ) ); ?>:</span> <?php switch( $attribute->getValue() ) : case 'array': case 'object': ?> <?php foreach( (array) $attribute->getValue() as $value ) : ?> <span class="value"><?= $enc->html( $value ); ?></span> <?php endforeach ?> <?php break; default: ?> <span class="value"><?= $enc->html( $attribute->getValue() ); ?></span> <?php endswitch; ?> </li> <?php endif; ?> <?php endforeach; ?> </ul> <?php endif; ?> </div> <?php endforeach; ?> </div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="common-summary-outlook common-summary-additional-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div class="common-summary common-summary-additional" style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="item-outlook coupon-outlook" style="vertical-align:top;width:200px;" ><![endif]--><div class="mj-column-per-33 outlook-group-fix item coupon" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'Coupon codes' ), $enc::TRUST ); ?></h3><div class="content"> <?php if( ( $coupons = $this->summaryBasket->getCoupons() ) !== [] ) : ?> <ul class="attr-list"> <?php foreach( $coupons as $code => $products ) : ?> <li class="attr-item"><?= $enc->html( $code ); ?></li> <?php endforeach; ?> </ul> <?php endif; ?> </div></div></td></tr></table></div><!--[if mso | IE]></td><td class="item-outlook customerref-outlook" style="vertical-align:top;width:200px;" ><![endif]--><div class="mj-column-per-33 outlook-group-fix item customerref" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'Your reference' ), $enc::TRUST ); ?></h3><div class="content"> <?= $enc->attr( $this->summaryBasket->getCustomerReference() ); ?> </div></div></td></tr></table></div><!--[if mso | IE]></td><td class="item-outlook comment-outlook" style="vertical-align:top;width:200px;" ><![endif]--><div class="mj-column-per-33 outlook-group-fix item comment" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:inherit;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"><h3><?= $enc->html( $this->translate( 'client', 'Your comment' ), $enc::TRUST ); ?></h3><div class="content"> <?= $enc->html( $this->summaryBasket->getComment() ); ?> </div></div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="common-summary-outlook common-summary-detail-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div class="common-summary common-summary-detail" style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" class="basket" style="font-size:0px;padding:10px 25px;word-break:break-word;"><table cellpadding="0" cellspacing="0" width="100%" border="0" style="cellspacing:0;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;"><tr class="header"><th class="status"></th><th class="label"><?= $enc->html( $this->translate( 'client', 'Name' ), $enc::TRUST ); ?></th><th class="quantity"><?= $enc->html( $this->translate( 'client', 'Qty' ), $enc::TRUST ); ?></th><th class="price"><?= $enc->html( $this->translate( 'client', 'Sum' ), $enc::TRUST ); ?></th></tr> <?php
				$detailTarget = $this->config( 'client/html/catalog/detail/url/target' );
				$detailController = $this->config( 'client/html/catalog/detail/url/controller', 'catalog' );
				$detailAction = $this->config( 'client/html/catalog/detail/url/action', 'detail' );
				$detailConfig = $this->config( 'client/html/catalog/detail/url/config', ['absoluteUri' => 1] );
				$detailFilter = array_flip( $this->config( 'client/html/catalog/detail/url/filter', ['d_prodid'] ) );
			?> <?php foreach( $this->summaryBasket->getProducts() as $product ) : ?> <tr class="body product"><td class="status"> <?php if( ( $status = $product->getStatus() ) >= 0 ) : $key = 'stat:' . $status ?> <?= $enc->html( $this->translate( 'mshop/code', $key ) ); ?> <?php endif; ?> </td><td class="label"> <?php $params = array_diff_key( array_merge( $this->param(), ['d_name' => $product->getName( 'url' ), 'd_prodid' => $product->getProductId(), 'd_pos' => ''] ), $detailFilter ); ?> <a class="product-label" href="<?= $enc->attr( $this->url( ( $product->getTarget() ?: $detailTarget ), $detailController, $detailAction, $params, [], $detailConfig ) ); ?>"> <?= $enc->html( $product->getName(), $enc::TRUST ); ?> </a><p class="code"><span class="name"><?= $enc->html( $this->translate( 'client', 'Article no.' ), $enc::TRUST ); ?>: </span><span class="value"><?= $product->getProductCode(); ?></span></p> <?php foreach( $this->config( 'client/html/common/summary/detail/product/attribute/types', ['variant', 'config', 'custom'] ) as $attrType ) : ?> <?php if( ( $attributes = $product->getAttributeItems( $attrType ) ) !== [] ) : ?> <ul class="attr-list attr-type-<?= $enc->attr( $attrType ); ?>"> <?php foreach( $attributes as $attribute ) : ?> <li class="attr-item attr-code-<?= $enc->attr( $attribute->getCode() ); ?>"><span class="name"><?= $enc->html( $this->translate( 'client/code', $attribute->getCode() ) ); ?>:</span> <span class="value"> <?php if( $attribute->getQuantity() > 1 ) : ?> <?= $enc->html( $attribute->getQuantity() ); ?>× <?php endif; ?> <?= $enc->html( $attrType !== 'custom' && $attribute->getName() ? $attribute->getName() : $attribute->getValue() ); ?> </span></li> <?php endforeach; ?> </ul> <?php endif ?> <?php endforeach; ?> <?php if( $this->extOrderItem->getPaymentStatus() >= $this->config( 'client/html/common/summary/detail/download/payment-status', \Aimeos\MShop\Order\Item\Base::PAY_RECEIVED )
								&& ( $attribute = $product->getAttributeItem( 'download', 'hidden' ) ) !== null ) : ?> <ul class="attr-list attr-list-hidden"><li class="attr-item attr-code-<?= $enc->attr( $attribute->getCode() ); ?>"><span class="name"><?= $enc->html( $this->translate( 'client/code', $attribute->getCode() ) ); ?></span><span class="value"> <?php
											$dlTarget = $this->config( 'client/html/account/download/url/target' );
											$dlController = $this->config( 'client/html/account/download/url/controller', 'account' );
											$dlAction = $this->config( 'client/html/account/download/url/action', 'download' );
											$dlConfig = $this->config( 'client/html/account/download/url/config', ['absoluteUri' => 1] );
										?> <a href="<?= $enc->attr( $this->url( $dlTarget, $dlController, $dlAction, ['dl_id' => $attribute->getId()], [], $dlConfig ) ); ?>"> <?= $enc->html( $attribute->getName() ); ?> </a></span></li></ul> <?php endif; ?> </td><td class="quantity"> <?= $enc->html( $product->getQuantity() ); ?> </td><td class="price"> <?= $enc->html( sprintf( $priceFormat, $this->number( $product->getPrice()->getValue() * $product->getQuantity(), $product->getPrice()->getPrecision() ), $this->translate( 'currency', $product->getPrice()->getCurrencyId() ) ) ); ?> </td></tr> <?php endforeach; ?> <?php foreach( $this->summaryBasket->getService( 'delivery' ) as $service ) : ?> <?php if( $service->getPrice()->getValue() > 0 ) : $priceItem = $service->getPrice(); ?> <tr class="body delivery"><td class="status"></td><td class="label"><?= $enc->html( $service->getName() ); ?></td><td class="quantity">1</td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $priceItem->getValue(), $priceItem->getPrecision() ), $this->translate( 'currency', $priceItem->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php endforeach; ?> <?php foreach( $this->summaryBasket->getService( 'payment' ) as $service ) : ?> <?php if( $service->getPrice()->getValue() > 0 ) : $priceItem = $service->getPrice(); ?> <tr class="body payment"><td class="status"></td><td class="label"><?= $enc->html( $service->getName() ); ?></td><td class="quantity">1</td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $priceItem->getValue(), $priceItem->getPrecision() ), $this->translate( 'currency', $priceItem->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php endforeach; ?> <?php if( $this->summaryBasket->getPrice()->getCosts() > 0 ) : ?> <tr class="footer subtotal"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( $this->translate( 'client', 'Sub-total' ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $this->summaryBasket->getPrice()->getValue(), $this->summaryBasket->getPrice()->getPrecision() ), $this->translate( 'currency', $this->summaryBasket->getPrice()->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php if( ( $costs = $this->get( 'summaryCostsDelivery', 0 ) ) > 0 ) : ?> <tr class="footer delivery"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( $this->translate( 'client', '+ Shipping' ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $costs, $this->summaryBasket->getPrice()->getPrecision() ), $this->translate( 'currency', $this->summaryBasket->getPrice()->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php if( ( $costs = $this->get( 'summaryCostsPayment', 0 ) ) > 0 ) : ?> <tr class="footer payment"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( $this->translate( 'client', '+ Payment costs' ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $costs, $this->summaryBasket->getPrice()->getPrecision() ), $this->translate( 'currency', $this->summaryBasket->getPrice()->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php if( $this->summaryBasket->getPrice()->getTaxFlag() === true ) : ?> <tr class="footer total"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( $this->translate( 'client', 'Total' ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $this->summaryBasket->getPrice()->getValue() + $this->summaryBasket->getPrice()->getCosts(), $this->summaryBasket->getPrice()->getPrecision() ), $this->translate( 'currency', $this->summaryBasket->getPrice()->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php foreach( $this->get( 'summaryNamedTaxes', [] ) as $taxName => $priceItem ) : ?> <?php if( ( $taxValue = $priceItem->getTaxValue() ) > 0 ) : ?> <tr class="footer tax"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( sprintf( $priceItem->getTaxFlag() ? $this->translate( 'client', 'Incl. %1$s%% %2$s' ) : $this->translate( 'client', '+ %1$s%% %2$s' ), $this->number( $priceItem->getTaxRate() ), 'tax' . $taxName ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $taxValue, $priceItem->getPrecision() ), $this->translate( 'currency', $priceItem->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php endforeach; ?> <?php if( $this->summaryBasket->getPrice()->getTaxFlag() === false ) : ?> <tr class="footer total"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( $this->translate( 'client', 'Total' ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $this->summaryBasket->getPrice()->getValue() + $this->summaryBasket->getPrice()->getCosts() + $this->summaryBasket->getPrice()->getTaxValue(), $this->summaryBasket->getPrice()->getPrecision() ), $this->translate( 'currency', $this->summaryBasket->getPrice()->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> <?php if( $this->summaryBasket->getPrice()->getRebate() > 0 ) : ?> <tr class="footer rebate"><td class="status"></td><td class="label" colspan="2"><?= $enc->html( $this->translate( 'client', 'Included rebates' ) ); ?></td><td class="price"><?= $enc->html( sprintf( $priceFormat, $this->number( $this->summaryBasket->getPrice()->getRebate(), $this->summaryBasket->getPrice()->getPrecision() ), $this->translate( 'currency', $this->summaryBasket->getPrice()->getCurrencyId() ) ) ); ?></td></tr> <?php endif; ?> </table></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="email-common-outro-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div class="email-common-outro" style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"> <?= $enc->html( nl2br( $this->translate( 'client', 'If you have any questions, please reply to this e-mail' ) ), $enc::TRUST ); ?> </div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="email-common-legal-outlook" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]--><div class="email-common-legal" style="Margin:0px auto;max-width:600px;"><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;"><tbody><tr><td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;"><!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]--><div class="mj-column-per-100 outlook-group-fix" style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;"><table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%"><tr><td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;"><div style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;"> <?= nl2br( $enc->html( $this->translate( 'client', 'All orders are subject to our terms and conditions.' ), $enc::TRUST ) ); ?> </div></td></tr></table></div><!--[if mso | IE]></td></tr></table><![endif]--></td></tr></tbody></table></div><!--[if mso | IE]></td></tr></table><![endif]--></div></body></html>
<?php $this->block()->stop(); ?>
<?= $this->block()->get( 'email/payment/html' ); ?>
