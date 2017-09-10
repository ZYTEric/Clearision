<footer id="footer" role="contentinfo">
<?php
$clrs_tjt = get_option('clrs_tongji');
$clrs_cpyrt = get_option("clrs_cpyrt");
$clrs_ftlogo = get_option('clrs_ftlogo');
if (!empty($clrs_tjt)) {
  echo $clrs_tjt;
};
if (!empty($clrs_ftlogo)) {
  echo '<img src="'.$clrs_ftlogo.'" width="120" height="30" /><br />';
}
if (!empty($clrs_cpyrt)) {
  echo str_replace('{year}', date('Y'),$clrs_cpyrt);
}
?>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>