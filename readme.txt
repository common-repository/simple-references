=== Simple References ===
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=F99Y5NH75SF34&lc=FR&item_name=FunAndProg&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: gestion,simple, referenes, custom taximonies, jquery, bxslider
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin permit to approuve your gestion of your client (or references).

== Description ==

This plugin permit to approuve your gestion of your client (or references).
You shoudl be create a simple desctiption of your refernce , with a title, decription, and logo.
You have 2 solution for view the references. You can put a slide or just a list.

An to use is simple , you just add htis in your template : 
fnp_get_references($limit=-1, $post_per_page=10, $miniature=true, $link=true, $sizew=140, $sizeh=140,$cssClass="fnp_thumb img_black", $sliderJs=true);

The simple difference for use the categories or tags is
And you can add in your template page of your themes:
	fnp_get_references_by_cat or fnp_get_references_by_tags 
with this options ($key, $limit=-1, $post_per_page=10, $thumb=true, $link=true, $sizew=140, $sizeh=140,$cssClass="fnp_thumb img_black", $sliderJs=true) 

== Installation ==

1. Upload `Simple_references` folder into the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php fnp_get_references() or  fnp_get_references_by_cat("cat") ?>` in your templates

== Frequently Asked Questions ==

= Options of  fnp_get_references() ? =

fnp_get_references($limit=-1, $post_per_page=10, $thumb=true, $link=true, $sizew=140, $sizeh=140,$cssClass="fnp_thumb img_black", $sliderJs=true):

* limit : limit oy all references,
* post_per_page : limit of reference on your page,
* thumb         : if you can use minature ,
* link : 		: If you want a link ,
* sizew         : width size of you thumb,
* sizeh 		: height size of you thumb,
* cssClass      : default class of you thumb,
* sliderJs      : If you yant a slide or a list,

= Options of  fnp_get_references_by_cat() ? =

fnp_get_references_by_cat($category, $limit=-1, $post_per_page=10, $thumb=true, $link=true, $sizew=140, $sizeh=140,$cssClass="fnp_thumb img_black", $sliderJs=true) :

* category : category id,
* limit : limit oy all references,
* post_per_page : limit of reference on your page,
* thumb         : if you can use minature ,
* link : 		: If you want a link ,
* sizew         : width size of you thumb,
* sizeh 		: height size of you thumb,
* cssClass      : default class of you thumb,
* sliderJs      : If you yant a slide or a list

= Options of  fnp_get_references_by_tags() ? =

fnp_get_references_by_tags($tags, $limit=-1, $post_per_page=10, $thumb=true, $link=true, $sizew=140, $sizeh=140,$cssClass="fnp_thumb img_black", $sliderJs=true) :

* tag 	        : tag id,
* limit 	    : limit oy all references,
* post_per_page : limit of reference on your page,
* thumb         : if you can use minature ,
* link : 		: If you want a link ,
* sizew         : width size of you thumb,
* sizeh 		: height size of you thumb,
* cssClass      : default class of you thumb,
* sliderJs      : If you yant a slide or a list

== Screenshots ==

1. List in Admin Menu
2. List Of Your references
3. Exemple Of Slider

== Changelog ==

= 0.1 =
* First version.
= 0.2 =
* Add option for categorie and tags.