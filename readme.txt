=== WPis ===
Contributors: axelrafn
Donate link: http://www.axelrafn.org/
Tags: translation, íslenska, þýðing, íslensk þýðing, ísland, Ísland, i8n
Requires at least: 2.0.2
Tested up to: 3.2.1
Stable tag: 1.0.5

Þessi viðbót aðstoðar með að viðhalda nýjustu útgáfunni af íslensku þýðingunni frá þýðingarhópnum okkar.

== Description ==

Þessi viðbót var búin til fyrir íslenska vefi sem keyra WordPress vefumsjónarkerfið.

Þetta er frekar lítil viðbót sem hjálpar þér að viðhalda íslenskri þýðingu fyrir Wordpress frá þýðingarhópnum okkar.
Sem stendur virkar hún bara á Linux/Unix þjónum með cURL uppsett.

Það kemur villumelding þegar viðbótin er virkjuð, um að viðbótin hafi framkallað XXXX marga stafi af óvæntri útprentun. Þetta þarf ekkert að óttast en þetta skemmir ekkert fyrir, þetta gerist bara við virkjun viðbótarinnar.
Sem stendur er ég að reyna að elta uppi hvers vegna þetta kemur fram.

== Installation ==

1. Upphala wpis möppunni í `/wp-content/plugins/` möppuna.
1. Virkja viðbótina í 'Viðbætur' valmyndinni í WordPress.
1. Smella á “Uppfæra Þýðingu” til að sækja nýjustu þýðinguna.
1. Uppfæra wp-config.php skjalið á vefþjóninum þínum og breyta í: define(“WPLANG”, “is_IS”); 

== Changelog ==

= 1.0.5 =
* Lítils háttar uppfærsla til að undirbúa fyrir komandi uppfærslur og nýjungar

= 1.0.2 =
* Lagaði uppsetningarlýsinguna, gleymdist að taka fram með stillingu í wp-config.php
* Nú þarf ekki að uppfæra fréttir í fyrsta skiptið sem viðbótin er skoðuð á bakenda WordPress
 
= 1.0.1 =
* Lagaði lýsingar í bæði readme.txt og wpis.php

= 1.0 =
* Fyrsta stöðuga útgáfan sem er dreift til allra sem vilja

= 0.4 =
* Upphaflega útgáfan sem var notuð af takmörkuðum hóp.
