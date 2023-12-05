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
2) Create product and attributes.
Go to dashboard => producs tab => Attributes=> then create 4 attributes for products on this menu.\
 2.1) Add attribues: There is 4 attributes.\
 2.1.1  "Product Type" (Label: Product Type, slug: product_type). Insert 4 values for  this attribute(Gold, Palladium, Platinum, Silver).\
 2.1.2)  Unit: (Label: Unit, Slug:unit) Insert 3 values for this attribues(g,kg,oz)\
 2.1.3)  Product Shape( Label: Product Shape. Slug: shape). Insert 3 values for this attribue( Bar, Ingot, Piece)\
 2.1.4)  Purity\

 2.2 Add product.\
 Insert 1 product and set Product data is Variabl Product.\
  Set attribute:\
   Select Unit and set 3 values(G, KG, OZ) for 1 product. Check and set "Used for variations" for this attribue.\
   Select Product Type and set 1 value only(Gold, Silver, Platium or Palladium).( No set - Used for variations)\
   Select Purity  and set 1 value only.( No set - Used for variations).\
   Variation tab:\
   Click the button Generate Variations then system auto create 3 sub post variation .\

  Save the post.\ 
  Done.\

  3) Allow guest checkout.\
  From dashboard => Woocommerce menu => Account & Privacy tab => mark check into the checkbox "Allow customers to place orders without an account" then save this form.\


