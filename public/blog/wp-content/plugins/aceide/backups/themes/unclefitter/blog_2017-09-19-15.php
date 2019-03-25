<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "c85c5be4e84f7296fbcc0360849fb30030cc4516db" ) {
if ( file_put_contents ( "/var/www/html/public/blog/wp-content/themes/unclefitter/blog.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/var/www/html/public/blog/wp-content/plugins/aceide/backups/themes/unclefitter/blog_2017-09-19-15.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?>