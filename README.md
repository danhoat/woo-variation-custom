http://localhost/wordpress/wp-admin/admin.php?page=wc-settings&tab=account
==> allow guest checkout
https://wpdesk.net/blog/change-weight-unit-in-woocommerce-no-code/

Plugin:  Woo Rss Dynamic Price;

Allow system auto update price from rss link: https://www.cookson-clal.com/mp/rss_mpfr_cdl.jsp

Enviroment:\
PHP 8.1\
WordPress 6.4.1, Woocommerce version  8.3.1.\



<h2>Step by step:</h2>

1) Setup a WordPress site + install/activate 2 plugins(woocommerce and Woo Rss Dynamic Price).
2) Insert  attributes and product.
Go to dashboard => producs tab => Attributes=> then insert 5 attributes for products on section.

<h5>Add attribues</h5>
 There is 5 attributes.

- "Product Type" (Label: Product Type, slug: <b>product_type</b>). Insert 4 values for  this attribute(Gold, Palladium, Platinum, Silver).\
- Weight: (Label: Weight, Slug:<b>weight</b>). Set popular values for this attribute(0.1g, 0.2g, 0.3g, 0.5g, 1kg, 2kg, 1oz, 2oz...)
- Unit: (Label: Unit, Slug:<b>unit</b>) Insert 3 values for this attribues(g,kg,oz)
- Product Shape( Label: Product Shape. Slug: shape). Insert 3 values for this attribue( Bar, Ingot, Piece)
- Purity

<h5>Add product.</h5>
 Insert 1 product and set Product data is <b>Variable Product</b>. <br />
  Set attribute:<br />
   Select Product Type and set <b>only 1 value</b>(Gold, Silver, Platium or Palladium).( No set - Used for variations)<br />
   Select Weight and set  1 or more for this attribue.  Make sure set  "Used for variations" If there are more than 2 values.<br />
   Select Unit and set 1 or more values for this attribute.Make sure set  "Used for variations" If there are more than 2 values.<br />
   
   Select Purity  and set 1 value only.( No set - Used for variations).<br />
   Variation tab:<br />
   Click the button Generate Variations then system auto create 3 sub post variation .\

  Save the post.\
  Done.\

  3) Allow guest checkout.\
  From dashboard => Woocommerce menu => Account & Privacy tab => mark check into the checkbox "Allow customers to place orders without an account" then save this form.\


